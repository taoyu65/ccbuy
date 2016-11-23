<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class statisticController extends Controller
{
    public function index($year, $type, $r = '')
    {
        $refresh = false;   //if false than use cookie otherwise to refresh
        if($r == 'refresh')
            $refresh = true;
        switch ($type) {
            case 'profits':
                return $this->profits($year, $refresh);
            case 'customs':
                break;
            case 'items':
                break;
        }
    }


    /**
     * @param $year - get what year's data
     * @param $refresh - if refresh page to see newest data
     * @return string - data such as '1,2,3,4'
     */
    private function profits($year, $refresh)
    {
        if ($year == '2016' || $year == '2017' || $year == 'all') {
            //read data from json file but the form of data is 'data,data,data'
            $path = Config::get('ccbuy.statistic.profitsPath.profit' . $year);
            if($refresh) {  //see if the page refresh or not
                $data = $this->getProfitsByYear($year);
                file_put_contents(public_path($path), $data);
            }else{
                $profits = file_get_contents(public_path($path));
                if ($profits == '') {
                    $data = $this->getProfitsByYear($year);
                    file_put_contents(public_path($path), $data);
                }
                else{
                    $data = $profits;
                }
            }
            //get all month x axis
            if ($year == 'all') {
                $month = Config::get('ccbuy.statistic.profitAll');
            }else{
                $month = Config::get('ccbuy.statistic.profitMonth');
            }
            return view('statistic', ['data' => $data, 'month' => $month]);
        }else{
            return '';
        }
    }

    /**
     * @param $year - get all data by year
     * @return array - array that show every month data(profits)
     */
    private function getProfitsByYear ($year)
    {
        if ($year == 'all') {
            $data = DB::table('carts')->select('profits', 'date')->get();
        }else{
            $data = DB::table('carts')->select('profits', 'date')->whereRaw('year(date)='.$year)->get();
        }
        $arr = array();
        foreach ($data as $d) {
            $date = explode('-', $d->date);
            $monthNum = (int)$date[1];
            if (array_key_exists($monthNum,$arr)) {
                $arr[$monthNum] += $d->profits;
            }else{
                $arr[$monthNum] = $d->profits;
            }
        }
        $profits = $this->getSumByMonth($arr);
        return $profits;
    }

    /**
     * @param $arr - get all the summary of profits by month
     * @return string - such as '1,2,3 ...'
     */
    private function getSumByMonth($arr)
    {
        $monthList = explode(',', Config::get('ccbuy.statistic.profitMonth'));
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