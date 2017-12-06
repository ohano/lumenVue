<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SystemConfig extends Model 
{
	public function getConfigs() 
	{
		$systemConfig = DB::table('system_config')->get();
		return $systemConfig;
	}
}