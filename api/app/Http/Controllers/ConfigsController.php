<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;

class ConfigsController extends Controller {

	public function getConfigs() 
	{
		var_dump(Cache::get('DB_CONFIG_DATA'));exit();
		if(!Cache::has('DB_CONFIG_DATA')){
			//获取所有系统配置
            // $systemConfig = model('admin/SystemConfig')->getDataList();
            $systemConfig = 'OMG';
            Cache::put('DB_CONFIG_DATA', null);
            Cache::put('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
		}else{
			$systemConfig = Cache::get('DB_CONFIG_DATA');
		}
        return $this->apiReturn($systemConfig, SUCCESS_CODE);
	}
}