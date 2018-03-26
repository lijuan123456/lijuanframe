<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 14:11
 */

namespace houdunwang\core;

use houdunwang\view\Base;
//创建boot类
//use app\home\controller\ArticleController;

class Boot
{
	//方便下面调用其他的私有方法
	public static function run ()
	{
		//$_SESSION['a'] = 1;
		//p ( session_id () );
		//p ( $_SESSION );
		//die();
		//echo 'aaaa';
		//p(1);
		//调用静态init
		self::init ();
		//调用静态appRun
		self::appRun ();

	}

	//创建静态方法 静态方法加载更快
	private static function appRun ()
	{
		//判断一下能不能接受到get接收不到就要给默认值
		if ( isset( $_GET[ 's' ] ) ) {
			//接受get参数
			$s = $_GET[ 's' ];
			//把接收到的字符串转成数组
			$info = explode ( '/' , $s );
			//app\home\controller\ArticleController()) -> index()
			//数组里的0号元素就是home.1就相当于Article 。2就相当于index
			$m = $info[ 0 ];
			$c = $info[ 1 ];
			$a = $info[ 2 ];

		} else {
			//给默认值
			$m = 'home';
			$c = 'index';
			$a = 'index';

		}
		//改成常量方便其他地方调用
		define ( 'MODUME' , $m );
		define ( 'CONTROLLER' , strtolower ( $c ) );
		define ( 'ACTION' , $a );
		//app\home\controller\ArticleController把它拼接好方便下面实例化用
		$controller = '\app\\' . $m . '\controller\\' . ucfirst ( $c ) . 'Controller';
		//实例化 经量用系统函数实例化$controller类 $a方法 []传参往前面
		echo call_user_func_array ( [ new $controller , $a ] , [] );

		//(new \app\home\controller\ArticleController()) -> index();
		//$article = new ArticleController();
		//$article->index ();


	}

	//一斤来时要先加载的头部时区历史记录session
	private static function init ()
	{
		//echo 'qqqq';
		//添加头部
		header ( 'Content-type:text/html;charset=utf8' );
		//添加时区
		date_default_timezone_set ( 'PRC' );
		//判断有没有session.没有执行session
		session_id () || session_start ();
	}

}