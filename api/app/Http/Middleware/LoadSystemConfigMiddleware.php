<?php

namespace App\Http\Middleware;
use App\Http\Controllers\ConfigsController;
use Closure;

class LoadSystemConfigMiddleware 
{
	public $systemConfig;
	public function __construct(ConfigsController $systemConfig)
	{
		$this->systemConfig = $systemConfig;
	}

	public function handle($request, Closure $next)
	{
		$configs = $this->systemConfig->getConfigs()['data'];
		config(['systemConfig' => $configs]);
		return $next($request);
	}
}