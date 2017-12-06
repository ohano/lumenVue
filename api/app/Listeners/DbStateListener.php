<?php

namespace App\Listeners;

use Illuminate\Database\Events\StatementPrepared;

class DbStateListener 
{
	/**
     * Handle the event.
     *
     * @param  StatementPrepared  $event
     * @return void
     */
    public function handle(StatementPrepared $event)
    {
    	//fetch配置项在5.5版本被废弃了,所以只能通过实践触发来改变fetchMode
        //设置数据库数据返回格式
        if(config('database.fetch')){
        	$event->statement->setFetchMode(config('database.fetch'));
        }
    }
} 