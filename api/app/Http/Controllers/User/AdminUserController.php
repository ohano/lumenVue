<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;


class AdminUserController extends Controller
{
	
	public function list()
	{
		$userModel = model('User');
        $param = $this->param;
        $keywords = !empty($param['keywords']) ? $param['keywords']: '';
        $page = !empty($param['page']) ? $param['page']: '';
        $limit = !empty($param['limit']) ? $param['limit']: '';    
        $data = $userModel->getDataList($keywords, $page, $limit);
        return resultArray(['data' => $data]);
	}
}