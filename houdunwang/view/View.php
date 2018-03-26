<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/22
 * Time: 15:43
 */

namespace houdunwang\view;


class View
{
	//	加载方法时找不加就走__call （非静态）
	public function __call ( $name , $arguments )
	{
		//接收
		self::runParse ( $name , $arguments );

	}

	//加载方法时找不加就走__callstatic（静态）
	public static function __callstatic ( $name , $arguments )
	{
		//先接收在把结果反出
		return self::runParse ( $name , $arguments );
	}

	//创建静态方法因为调用————call或--callstatic时如果用普通方法的话不能调用静态，静态可以调用静态和普通都可以
	private static function runParse ( $name , $arguments )
	{
		//实例化 Base里的make方法.把这个return出来让静态或非静态接收
		return call_user_func_array ( [ new Base() , $name ] , $arguments );
	}

}
