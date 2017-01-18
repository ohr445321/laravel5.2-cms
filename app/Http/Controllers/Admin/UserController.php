<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/5
 * Time: 14:53
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\JsonException;
use App\Exceptions\ScriptException;
use Exception;
use App\Http\Common\Helper;
use App\Model\Users;
use Illuminate\Support\Facades\App;
use App\Http\Business\UsersBusiness;

class UserController extends Controller
{
    /**
     * author: ouhanrong
     * 功能：用户列表
     */
    public function index(UsersBusiness $users_business)
    {
        
        $user_data = $users_business->getUsersList(['page' => 2, 'sort_column' => 'id', 'sort_type' => 'desc'], ['*'], []);

        return view('admin.user.index', ['user_list' => $user_data]);
    }

    /**
     * @author:     ouhanrong
     * 功能：添加用户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user.create');
    }


    /**
     * 功能：保存用户
     * @author:     ouhanrong
     * @param Input $input
     * @return array
     */
    public function store(Input $input, UsersBusiness $users_business)
    {
        $post_data = $input->get();

        $response = $users_business->storeUser($post_data);

        return $this->jsonFormat(0, '保存成功');

    }

    public function edit($id)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10003);
        }

        $data = Users::select('id','username')->find($id);

        return view('admin.user.edit', ['user' => $data]);
    }

    public function update($id, Input $input)
    {
        if (empty($id) || !is_numeric($id)) {
            $this->jsonFormat(1, '非法操作~');
        }

        $post_data = $input->get();

        $validator = Validator::make($post_data,[
            'user_name' => 'required',
            'old-password' => 'required',
            'password' => 'required|same:re-password',
            're-password' => 'required',
        ],[
            'user_name.required' => '用户名不能为空~',
            'password.required' => '密码不能为空~',
            're-password.required' => '确认密码不能为空~',
            'password.same' => '密码不一致~',
        ]);
        
        if ($validator->fails()) {
            $error = $validator->errors()->first();

            return $this->jsonFormat(1, $error);
        }
        
        //验证原始密码是否正确
        $m_users = App::make('UsersModel');
        //获取旧密码
        $users_data = $m_users->select('password', 'salt', 'id')->find($id);
        //验证输入的旧密码是否正确
        if (!Helper::checkEncryptPwd($users_data->password, $post_data['old-password'], $users_data->salt)){
            return $this->jsonFormat(1, '原始密码不匹配~');
        }

        //修改用户信息
        $users_data->username = $post_data['user_name'];

        $users_data->password = Helper::getEncryptPwd($post_data['password'], $users_data['salt']);

        $res = $users_data->save();

        if ($res !== false) {
            return $this->jsonFormat(0, '操作成功~');
        } else {
            return $this->jsonFormat(1, '操作失败~');
        }
    }





}