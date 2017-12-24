<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Tools\TreeTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Models\AdminUser;

class LoginController extends Controller
{
	private $adminUser;
	protected $isNeedVerify = true;

	public function __construct(AdminUser $adminUser)
	{	
		parent::__construct();
		$this->adminUser 	= $adminUser;
	}
	
	public function login(Request $request)
	{
		$username 	= $request->input('username', '');
		$password 	= $request->input('password', '');
		$verifyCode = $request->input('verifyCode', '');
		$isRemember = $request->input('isRemember', '');

		if($username && $password){
			$userInfo = $this->adminUser->getUserInfoByPassword($username, $password);
		}else{
			$return['data'] = '请填写用户名和密码';
			$return['code'] = getReturnCode('LOGIN_MSG_ERROR_CODE');
		}

		if($userInfo){
			if($this->isNeedVerify && config('systemConfig.IDENTIFYING_CODE')){
				// 验证码验证部分
			}

			// 获取菜单和权限
        	$menuRuleList = $this->getMenuAndRule($userInfo['id']);

        	if ($isRemember || !$this->isNeedVerify) {
	        	$secret['username'] = $username;
        		$secret['password'] = $password;
	        	$data['rememberKey'] = encrypt($secret);
	        }
	        // 返回信息
	        $data['userInfo']		= $userInfo;
	        $data['_AUTH_LIST_'] 	= $menuRuleList['rulesList'];
	        $data['sessionId']		= $this->getSessionId($userInfo['id']);
			$data['authKey'] 		= $this->createAuthKey($data);
	        $data['authList']		= $menuRuleList['rulesList'];
	        $data['menusList']		= $menuRuleList['menusList'];
	        unset($data['_AUTH_LIST_']);
			$return['data'] = $data;
			$return['code'] = getReturnCode('SUCCESS_CODE');
		}else{
			$return['data'] = '用户不存在';
			$return['code'] = getReturnCode('USER_NOT_EXIST');
		}
		
        return $this->apiReturn($return['data'], $return['code']);
		
	}

	protected function getSessionId($user_id)
	{
		return userPasswordMd5($user_id.time());
	}

	protected function createAuthKey($data)
	{
		$authKey = userPasswordMd5($data['userInfo']['username'].$data['userInfo']['password'].$data['sessionId']);
		if(!Cache::add('Auth_'.$authKey, $data, config('systemConfig.LOGIN_SESSION_VALID'))){
			Cache::put('Auth_'.$authKey, null);
			Cache::put('Auth_'.$authKey, $data, config('systemConfig.LOGIN_SESSION_VALID'));
		}
		return $authKey;
	}

	protected function getMenuAndRule($user_id)
	{
		if ($user_id === 1) {
    		$menusList = \Models\AdminMenu::where(['status' => 1])->orderBy('sort', 'asc')->get()->toArray();
    		$rules =\Models\AdminRule::where(['status' => 1])->get()->toArray();
    	} else {
    		$groups = \Models\AdminGroup::where(['user_id' => $user_id])->get()->toArray();
            $ruleIds = [];
    		foreach($groups as $k => $v) {
    			$ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
    		}

            $ruleMap['id'] = array('in', $ruleIds);
            $ruleMap['status'] = 1;
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $rules =\Models\AdminRule::where($ruleMap)->get()->toArray();
            foreach ($rules as $k => $v) {
            	$ruleIds[] = $v['id'];
            	$rules[$k]['name'] = strtolower($v['name']);
            }
            empty($ruleIds)&&$ruleIds = '';
    		$menuMap['status'] = 1;
            $menuMap['rule_id'] = array('in',$ruleIds);
            $menusList = \Models\AdminMenu::where($menuMap)->orderBy('sort', 'asc')->get()->toArray();
        }
        if (!$menusList) {
            return null;
        }
        //处理菜单成树状
        $tree = new TreeTool();
        $return['menusList'] = $tree->list_to_tree($menusList, 'id', 'pid', 'child', 0, true, array('pid'));
        $return['menusList'] = memuLevelClear($return['menusList']);
        // 处理规则成树状
        $return['rulesList'] = $tree->list_to_tree($rules, 'id', 'pid', 'child', 0, true, array('pid'));
        $return['rulesList'] = rulesDeal($return['rulesList']);

        return $return;
	}

}