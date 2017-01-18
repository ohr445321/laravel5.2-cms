<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/11
 * Time: 15:25
 */

namespace App\Http\Business;

use App\Exceptions\JsonException;
use App\Http\Business\Dao\UsersDao;
use App\Http\Common\Helper;
use DB;
use Exception;

class UsersBusiness extends BusinessBase
{
    private $users_dao = null;

    public function __construct(UsersDao $users_dao)
    {
        $this->users_dao = $users_dao;
    }

    /**
     * 功能：保存用户
     * @author:     ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function storeUser($data)
    {
        //用户名不能为空
        if (empty($data['user_name'])) {
            throw new JsonException(20000);
        }
        //密码不能为空
        if (empty($data['password'])) {
            throw new JsonException(20001);
        }
        //确认密码不能为空
        if (empty($data['re-password'])) {
            throw new JsonException(20002);
        }
        //是否密码一致
        if ($data['password'] != $data['re-password']) {
            throw new JsonException(20003);
        }

        $salt = mt_rand(1000, 9999);

        $data['salt'] = $salt;

        $data['password'] = Helper::getEncryptPwd($data['password'], $salt);

        DB::beginTransaction();
        try {
            $response = $this->users_dao->storeUser($data);
        } catch (Exception $e) {
            DB::rollback();
            throw new JsonException(10004, $e->getMessage());
        }
        DB::commit();

        return $response;
    }

    /**
     * 功能：获取用户列表信息
     * @author:     ouhanrong
     * @param array $condition
     * @param array $select_columns
     * @param array $relatives
     * @return mixed
     */
    public function getUsersList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $users_list = $this->users_dao->getUsersList($condition, $select_columns, $relatives);

        return $users_list;
    }

}