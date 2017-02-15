<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/5
 * Time: 14:53
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Exceptions\JsonException;
use App\Http\Business\UsersBusiness;

class UserController extends Controller
{
    /**
     * 功能：用户列表
     * author: ouhanrong
     * @param UsersBusiness $users_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * author: ouhanrong
     * @param Input $input
     * @param UsersBusiness $users_business
     * @return array
     */
    public function store(Input $input, UsersBusiness $users_business)
    {
        $post_data = $input->get();

        $response = $users_business->storeUser($post_data);

        return $this->jsonFormat(0, '保存成功');

    }

    /**
     * 功能：编辑用户界面
     * author: ouhanrong
     * @param $id
     * @param UsersBusiness $users_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws JsonException
     */
    public function edit($id, UsersBusiness $users_business)
    {
        $data = $users_business->getUserDetails($id, ['id','username']);

        return view('admin.user.edit', ['user' => $data]);
    }

    /**
     * 功能：更新用户信息
     * author: ouhanrong
     * @param $id
     * @param Input $input
     * @param UsersBusiness $users_business
     * @return array
     */
    public function update($id, Input $input, UsersBusiness $users_business)
    {
        $post_data = $input->get();

        $response = $users_business->updateUser($id, $post_data);

        return $this->jsonFormat(0, '操作成功~');
    }

}