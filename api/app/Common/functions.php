<?php


// 解决跨域问题
function reponseCrossDomain()
{
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
}

/**
 * [getReturnCode 获取响应码]
 * @param  string $msg [description]
 * @return string      错误码
 */
function getReturnCode(string $msg)
{	
	return config('return_code.'.$msg);
}

/**
 * [userPasswordMd5 用户密码加密]
 * @param  [string] $password      [密码]
 * @param  string $auth_key [description]
 * @return [boole]           [description]
 */
function userPasswordMd5($password, $auth_key = '')
{
    return '' === $password ? '' : md5(sha1($password) . $auth_key);
}

/**
 * 给树状菜单添加level并去掉没有子菜单的菜单项
 * @param  array   $data  [description]
 * @param  integer $root  [description]
 * @param  string  $child [description]
 * @param  string  $level [description]
 */
function memuLevelClear($data, $root=1, $child='child', $level='level')
{
    if (is_array($data)) {
        foreach($data as $key => $val){
        	$data[$key]['selected'] = false;
        	$data[$key]['level'] = $root;
        	if (!empty($val[$child]) && is_array($val[$child])) {
				$data[$key][$child] = memuLevelClear($val[$child],$root+1);
        	}else if ($root<3&&$data[$key]['menu_type']==1) {
        		unset($data[$key]);
        	}
        	if (empty($data[$key][$child])&&($data[$key]['level']==1)&&($data[$key]['menu_type']==1)) {
        		unset($data[$key]);
        	}
        }
        return array_values($data);
    }
    return array();
}

/**
 * [rulesDeal 给树状规则表处理成 module-controller-action ]
 * @param     [array]                   $data [树状规则数组]
 * @return    [array]                         [返回数组]
 */
function rulesDeal($data)
{   
    if (is_array($data)) {
        $ret = [];
        foreach ($data as $k1 => $v1) {
            $str1 = $v1['name'];
            if (is_array($v1['child'])) {
                foreach ($v1['child'] as $k2 => $v2) {
                    $str2 = $str1.'-'.$v2['name'];
                    if (is_array($v2['child'])) {
                        foreach ($v2['child'] as $k3 => $v3) {
                            $str3 = $str2.'-'.$v3['name'];
                            $ret[] = $str3;
                        }
                    }else{
                        $ret[] = $str2;
                    }
                }
            }else{
                $ret[] = $str1;
            }
        }
        return $ret;
    }
    return [];
}