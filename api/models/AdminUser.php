<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
	/**
     * 与模型关联的数据表
     */
	protected $table = 'admin_user';

	/**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = false;

    /**
     * [getUserInfoByPassword description]
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return array           用户数组
     */
    public function getUserInfoByPassword($username, $password)
    {
    	$userInfo = $this->where(['username'=>$username, 'password'=>userPasswordMd5($password)])->get();
    	return $userInfo;
    }
}