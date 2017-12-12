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