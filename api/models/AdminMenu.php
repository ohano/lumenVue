<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model 
{
	/**
     * 与模型关联的数据表
     */
	protected $table = 'admin_menu';

	/**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = false;
}