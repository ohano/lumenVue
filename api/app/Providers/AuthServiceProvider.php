<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Models\AdminUser;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {   
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        // var_dump($this->app['auth']);
        $this->app['auth']->viaRequest('api', function ($request) {

            /*获取头部信息*/ 
            $authKey = 'Auth_'.$request->headers->get('authKey');
            $sessionId = $request->headers->get('sessionid');
            $cache = Cache::get($authKey);
            
            // 校验sessionid和authKey
            if (empty($sessionId)||empty($authKey)||empty($cache)) {
                return ['code'=>101, 'error'=>'登录已失效'];
                // header('Content-Type:application/json; charset=utf-8');
                // exit(json_encode(['code'=>101, 'error'=>'登录已失效']));
            }

            // 检查账号有效性
            $userInfo = $cache['userInfo'];
            $map['id'] = $userInfo['id'];
            $map['status'] = 1;
            if (\Models\AdminUser::where($map)->get()->toArray()) {
                return ['code'=>103, 'error'=>'账号已被删除或禁用'];
            }
            // 更新缓存
            Cache::put($authKey, $cache, config('systemConfig.LOGIN_SESSION_VALID'));
            $authAdapter = new AuthAdapter($authKey);
            $request = Request::instance();
            $ruleName = $request->module().'-'.$request->controller() .'-'.$request->action(); 
            if (!$authAdapter->checkLogin($ruleName, $cache['userInfo']['id'])) {
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode(['code'=>102,'error'=>'没有权限']));
            }
            $GLOBALS['userInfo'] = $userInfo;
            return $authKey;
            
        });

    }
}
