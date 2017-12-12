<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Models\AdminUser;

class LoginController extends Controller
{
	private $adminUser;
	public function __construct(AdminUser $adminUser)
	{	
		parent::__construct();
		$this->adminUser = $adminUser;
	}
	
	public function login(Request $request)
	{
		$username = $request->input('username', '');
		$password = $request->input('password', '');
		if($username || $password){
			$userInfo = $this->adminUser->getUserInfoByPassword($username, $password);
		}else{
			return $this->apiReturn('请填写用户名和密码', getReturnCode('LOGIN_MSG_ERROR_CODE'));
		}
		var_dump($userInfo);exit();
        $param = $this->param;
        $username = $param['username'];
        $password = $param['password'];
        $verifyCode = !empty($param['verifyCode'])? $param['verifyCode']: '';
        $isRemember = !empty($param['isRemember'])? $param['isRemember']: '';
        $data = $userModel->login($username, $password, $verifyCode, $isRemember);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        } 
        return resultArray(['data' => $data]);
		
	}

}