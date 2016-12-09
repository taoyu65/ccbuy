<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class statisticController extends Controller
{
    protected $configFileName = 'ccbuy';
    /**
     * @param $year
     * @param $type - profits or customer or ***
     * @param string $r - refresh
     * @return string
     */
    public function index($year, $type, $r = '')
    {
        $refresh = false;   //if false than use json to show the data otherwise to refresh
        if($r === 'refresh')
            $refresh = true;
        switch ($type) {
            case 'profits':
                return $this->profits($year, $refresh, 'profit');
            case 'customer':
                return $this->getProfitByCustomer($year, $refresh, 'customer');
            case 'items':
                break;
            default:
                return '';
        }
    }


    /**
     * @param $year - get what year's data
     * @param $refresh - if refresh page to see newest data
     * @return string - data such as '1,2,3,4'
     */
    private function profits($year, $refresh, $type)
    {
        if ($year == '2016' || $year == '2017' || $year == 'All') {
            //read data from json file but the form of data is 'data,data,data'
            $path = Config::get($this->configFileName.'.statistic.profitsPath.'. $type . $year);
            if($refresh) {  //see if the page refresh or not
                $data = $this->getProfitsByYear($year, $type);
                file_put_contents(public_path($path), $data);
            }else{
                $profits = file_get_contents(public_path($path));
                if ($profits == '') {
                    $data = $this->getProfitsByYear($year, $type);
                    file_put_contents(public_path($path), $data);
                }
                else{
                    $data = $profits;
                }
            }
            //get all month x axis
            if ($year == 'all') {
                $month = Config::get($this->configFileName.'.statistic.profitAll');
                $year = trans('statistic.allYear');
            }else{
                $month = Config::get($this->configFileName.'.statistic.profitMonth');
            }
            $title = $year . trans('statistic.chart');
            return view('statistic', ['data' => $data, 'month' => $month, 'title' => $title]);
        }else{
            return '';
        }
    }

    public function allItem($refresh = 'dfsa')
    {
        $path = Config::get($this->configFileName.'.statistic.profitsPath.allItem');
        if ($refresh === 'refresh') {       //if refresh
            $profits = $this->getAllItem();
            file_put_contents(public_path($path), $profits);
        }else{
            $profits = file_get_contents($path);
            if(!$profits || empty($profits)){
                $profits = $this->getAllItem();
                file_put_contents(public_path($path), $profits);
            }
        }
        return view('statisticAllItem', ['dataSet' => $profits]);
    }

    private function getAllItem()
    {
        $dataSet = [];
        $customers = DB::table('customs')->get();
        foreach ($customers as $customer) {
            $items = DB::table('items')
                ->join('carts', 'items.carts_id' , '=', 'carts.id')
                ->join('customs', 'customs.id', '=', 'carts.customs_id')
                ->where('customs.id', $customer->id)->get();
            $xyr = [];
            foreach ($items as $item) {
                array_push($xyr, array('x' => (int)$item->costPrice, 'y' => (int)$item->sellPrice, 'r' => (int)$item->itemProfit));
            }
            if(count($xyr) > 0)
                $dataSet[$customer->customName] = $xyr;
        }
        //dd($dataSet);
        return json_encode($dataSet);
    }

    /**
     * @param $year - get all data by year
     * @return array - array that show every month data(profits)
     */
    private function getProfitsByYear ($year, $type)
    {
        $profits = '';
        if ($year === 'All') {  //get all data by year
            //$data = DB::table('carts')->select('profits', 'date')->get();
            if(!array_key_exists('profitAll',Config::get($this->configFileName.'.statistic')))
                return false;
            $allYears = explode(',',Config::get($this->configFileName.'.statistic.profitAll'));
            switch ($type) {
                case 'profit':
                    foreach ($allYears as $year) {
                        $profits .= DB::table('carts')->whereRaw('year(date)=' . $year)->sum('profits') . ',';
                    }
                    break;
                default:
                    return '';
            }
            $profits = rtrim($profits, ',');
        }else{      //get all data by month
            $data = DB::table('carts')->select('profits', 'date')->whereRaw('year(date)='.$year)->get();
            $arr = array();
            foreach ($data as $d) {
                if($d->date != null) {
                    $date = explode('-', $d->date);
                    $monthNum = (int)$date[1];
                    if (array_key_exists($monthNum, $arr)) {
                        $arr[$monthNum] += $d->profits;
                    } else {
                        $arr[$monthNum] = $d->profits;
                    }
                }
            }
            $profits = $this->getSumByMonth($arr);
        }
        return $profits;
    }

    private function getProfitByCustomer($year, $refresh, $type)
    {
        $profitAll = explode(',', Config::get($this->configFileName.'.statistic.profitAll'));
        $path = Config::get($this->configFileName.'.statistic.profitsPath.'. $type . $year);
        if(!in_array($year, $profitAll) && $year != 'All')
            return '';
        $profits = [];
        if ($refresh) {     //if refresh
            $profits = $this->getProfitByCustomer_getData($year);
            file_put_contents(public_path($path), serialize($profits));
        }else{
            $profits = unserialize(file_get_contents($path));
            if(!$profits){
                $profits = $this->getProfitByCustomer_getData($year);
                file_put_contents(public_path($path), serialize($profits));
            }
        }
        $data = $month = '';
        foreach ($profits as $profit) {     //the return data's format is array. like 'customer' => 'profits'
            foreach ($profit as $customer => $sum) {
            }
            $data .= $sum . ',';
            $month .= $customer . ',';
        }
        $title = $year . $type . trans('statistic.chart');
        $month = rtrim($month, ',');
        return view('statistic', ['data' => $data, 'month' => $month, 'title' => $title]);
    }

    private function getProfitByCustomer_getData($year)
    {
        $profits = [];
        $customers = DB::table('customs')->get();
        if ($year === 'All') {
            foreach ($customers as $customer) {
                $sum = DB::table('carts')->where('customs_id', $customer->id)->sum('profits');
                array_push($profits,[$customer->customName => $sum]);
            }
        } else{
            foreach ($customers as $customer) {
                $sum = DB::table('carts')->where('customs_id', $customer->id)->whereRaw('year(date)=' . $year)->sum('profits');
                array_push($profits,[$customer->customName => $sum]);
            }
        }
        return $profits;
    }
    /**
     * @param $arr - get all the summary of profits by month
     * @return string - such as '1,2,3 ...'
     */
    private function getSumByMonth($arr)
    {
        $monthList = explode(',', Config::get($this->configFileName.'.statistic.profitMonth'));
        $returnData = [];
        foreach ($monthList as $month) {
            switch ($month) {
                case 'Jan':
                    $value = $this->getValue(1, $arr);
                    array_push($returnData, $value);break;
                case 'Feb':
                    $value = $this->getValue(2, $arr);
                    array_push($returnData, $value);break;
                case 'Mar':
                    $value = $this->getValue(3, $arr);
                    array_push($returnData, $value);break;
                case 'Apr':
                    $value = $this->getValue(4, $arr);
                    array_push($returnData, $value);break;
                case 'May':
                    $value = $this->getValue(5, $arr);
                    array_push($returnData, $value);break;
                case 'Jun':
                    $value = $this->getValue(6, $arr);
                    array_push($returnData, $value);break;
                case 'Jul':
                    $value = $this->getValue(7, $arr);
                    array_push($returnData, $value);break;
                case 'Aug':
                    $value = $this->getValue(8, $arr);
                    array_push($returnData, $value);break;
                case 'Sep':
                    $value = $this->getValue(9, $arr);
                    array_push($returnData, $value);break;
                case 'Oct':
                    $value = $this->getValue(10, $arr);
                    array_push($returnData, $value);break;
                case 'Nov':
                    $value = $this->getValue(11, $arr);
                    array_push($returnData, $value);break;
                case 'Dec':
                    $value = $this->getValue(12, $arr);
                    array_push($returnData, $value);break;

            }
        }
        $re = implode(',', $returnData);
        return $re;
    }
    private function getValue($m, $arr)
    {
        if (!array_key_exists($m, $arr)) {
            return '';
        }else{
            return $arr[$m];
        }
    }
}