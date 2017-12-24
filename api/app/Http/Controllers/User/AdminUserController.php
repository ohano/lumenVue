<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    

    public function list(Request $request)
    {	
        // $userModel = model('User');
        // $param = $this->param;
        // $keywords = !empty($param['keywords']) ? $param['keywords']: '';
        // $page = !empty($param['page']) ? $param['page']: '';
        // $limit = !empty($param['limit']) ? $param['limit']: '';    
        // $data = $userModel->getDataList($keywords, $page, $limit);
        // return resultArray(['data' => $data]);
        $user = $request->user();
        var_dump($user);exit();
        return 312312;
    }

}