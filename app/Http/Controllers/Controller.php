<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * @author:     ouhanrong
     * 功能：return json data
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function jsonFormat($code = 0, $msg = '成功', $data = array())
    {
        if(is_object($data)){
            if(method_exists($data,'toArray')){
                $data = $data->toArray();
            }
        }

        if(!is_array($data)){
            $data = (array)$data;
        }

        return [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
    }
}
