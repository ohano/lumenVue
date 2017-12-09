<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
    	// reponseCrossDomain();
    }

    protected function apiReturn($data, $code = 0)
	{
		return array('code' => $code, 'data' => $data);
	}
}
