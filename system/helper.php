<?php
header ( 'Content-type:text/html;charset=utf8' );
/**
 * 设置时区
 */
date_default_timezone_set ( 'PRC' );
session_start ();
/**
 * 打印函数
 *
 * @param $var    打印的变量
 */
function p ( $var )
{
	echo '<pre style="width: 100%;padding: 5px;background: #CCCCCC;border-radius: 5px">';
	if ( is_bool ( $var ) || is_null ( $var ) ) {
		var_dump ( $var );
	} else {
		print_r ( $var );
	}
	echo '</pre>';
}

/**
 * 定义常量:IS_POST
 * 将侧是否为post请求
 */
define ( 'IS_POST' , $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ? true : false );
define (
	'IS_AJAX' , ( isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&
				  $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] == 'XMLHttpRequest' ) ? true : false );
/**
 * 合法化代码并且写入数据库文件
 *
 * @param $data    合法化的数据
 * @param $file    数据库文件
 */
function dataToFile ( $data , $file = './data.php' )
{
	$newData = var_export ( $data , true );
	//p($newData);
	$str
		= <<<str
<?php
return $newData;
?>
str;
	//p($str);
	file_put_contents ( $file , $str );
}

/**
 * 成功提示
 *
 * @param $msg    提示消息
 * @param $url    成功之后跳转地址
 */
function success ( $msg , $url )
{
	//解析变量看字符串最外层引号
	//{}变量分离
	echo "<script>alert('{$msg}');location.href='{$url}'</script>";
	die;
}

/**
 * 失败提示信息
 *
 * @param $msg    提示消息
 */
function error ( $msg )
{
	echo "<script>alert('{$msg}');history.back()</script>";
	die;
}

/**
 * 自动加载
 * 当实例化一个未找到的类时候回自动出发
 * 会将找不到类名传入
 * 体现为什么类名需要和文件名保持一致：因为加载类文件时候根据类名加载文件
 *
 * @param $className    类名
 */
function __autoload ( $className )
{
	//p($className);//ArticleController
	//p(substr ($className,-10));
	if ( substr ( $className , -10 ) == 'Controller' ) {
		include './controller/' . $className . '.php';
	} else {
		include './tools/' . $className . '.php';
	}
}

//封装个函数用来替换base里的入口
function c ( $var = null )
{
	if ( is_null ( $var ) ) {
		//扫描config里的文件
		$files = glob ( '../system/config/*.php' );
		//p($files);die;
		//升，名一个空数组来接受最后循环出来的文件
		$data = [];
		foreach ( $files as $file ) {
			$content = include $file;
			//p ( $content );
			//die;
			// [0] => ../system/config/database.php
			//截取/database.php
			$filename = basename ( $file );
			//p ($filename);die;
			//截取这个首次出现的位
			//置int、、8号位值。
			$position = strpos ( $filename , '.php' );
			//p($position);//8
			//	把database截取出来
			$index = substr ( $filename , 0 , $position );
			//p ($index);//database
			$data[ $index ] = $content;
			//p ($content);
			//p ($data[$index]);die;
			return $data;
		}
	}
	//p ( $var );
	//explode把字符串装成数组
	$info = explode ( '.' , $var );
	//p ( $info );
	//die;
	//conut数据一共有几条
	if ( count ( $info ) == 1 ) {
		//如果只有一条数据时database里的所有数据
		$file = '../system/config/' . $var . '.php';

		//is_file ()检测是不是一个文件是基于值行加载$file否则就是null
		return is_file ( $file ) ? include $file : null;

	}
	//conut数据共有几条 2条的时候。走的database文件里的第个数据
	if ( count ( $info ) == 2 ) {
		//加载这个文件
		//p ($var);
		//p ($info);
		$file = '../system/config/' . $info[0] . '.php';
		//如果是个文件
		//p($file);
		if ( is_file ( $file ) ) {
			//就执行这个文件
			$data = include $file;

			//取出文件里的一条数据下标是1的name
			return isset( $data[ $info[ 1 ] ] ) ? $data[ $info[ 1 ] ] : null;

		}
	}
}