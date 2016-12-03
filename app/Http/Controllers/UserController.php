<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    //login
    public function submit(Request $request)
    {
        $name = $request->get('name');
        $password = $request->get('password');

        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            return redirect(url('firstpage'));
        }
        return view('cc_admin/login', ['error' => '<script>alert("please check username or password")</script>']);
    }

    //logout
    public function logout ()
    {
        $this->setDatabase();
        Auth::logout();
        return view('cc_admin/login');
    }

    /**
     * @param $demo - demo or user - different database
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function demo($demo)
    {
        if ($demo === 'demo') {
            $this->setDemoDatabase();
        }else{

            $this->setDatabase();
        }
        return redirect('cc_admin/login?t='.$demo);
    }
    private function setDemoDatabase()
    {
        //demo will be direct to separated database
        $data = [
            'DB_DATABASE' => 'ccbuy_demo',
        ];
        $this->modifyEnv($data);
    }

    private function setDatabase()
    {
        $name = Config::get('ccbuy.database');
        $data = [
            'DB_DATABASE' => $name,
        ];
        $this->modifyEnv($data);
    }
    private function modifyEnv(array $data)
    {
        $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

        $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

        $contentArray->transform(function ($item) use ($data){
            foreach ($data as $key => $value){
                if(str_contains($item, $key)){
                    return $key . '=' . $value;
                }
            }
            return $item;
        });
        $content = implode($contentArray->toArray(), "\n");
        \File::put($envPath, $content);
    }
}
