<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ConfigsController extends Controller {

	public function getConfigs() 
	{
		// $systemConfig = DB::table('system_config')->where(['name'=>'SYSTEM_NAME'])->value('name');
		// var_dump($systemConfig);exit();
		if(!Cache::has('DB_CONFIG_DATA')){
			//获取所有系统配置
            // $systemConfig = model('admin/SystemConfig')->getDataList();
            // $systemConfig = Models\admin\Configs
           	$systemConfig = DB::table('system_config')->where(['name'=>'SYSTEM_NAME'])->first();
            Cache::put('DB_CONFIG_DATA', null);
            Cache::put('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
		}else{
			$systemConfig = Cache::get('DB_CONFIG_DATA');
		}
        return $this->apiReturn($systemConfig, SUCCESS_CODE);
	}
}