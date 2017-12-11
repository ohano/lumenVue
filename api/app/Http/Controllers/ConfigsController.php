<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;


class ConfigsController extends Controller {
	protected $systemConfigModel;

	public function __construct(\Models\SystemConfig $systemConfigModel) 
	{
		$this->systemConfigModel = $systemConfigModel;
		parent::__construct();
	}

	public function getConfigs() 
	{
		if(!Cache::has('DB_CONFIG_DATA')){
			//获取所有系统配置
           	$systemConfig = $this->systemConfigModel->getConfigs();
           	foreach ($systemConfig as $k => $v) {
           		$return_arr[$v['name']] = $v['value'];
           	}
           	//把系统配置设进缓存中
            Cache::put('DB_CONFIG_DATA', null);
            Cache::put('DB_CONFIG_DATA', $return_arr, 36000); 
		}else{
			$return_arr = Cache::get('DB_CONFIG_DATA');
		}
        return $this->apiReturn($return_arr, $return_code['SUCCESS_CODE']);
	}
}