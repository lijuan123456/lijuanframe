<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/22
 * Time: 9:37
 */

namespace houdunwang\core;


class Controller
{
	private $url;
	//public function index(){
	//	echo 'qq';
	//}
	//提示消息$msg
	public function message ($msg)
	{
		//echo 'ss';
		//模板
		include './view/message.php';
	}

	//重定向
//$url要加载的路径
	public function setRedirect ( $url='' )
	{
		if ( $url ) {
			//如果有数据就天道该页面
			$this->url = $url;
		} else {
			//返回到上一页面
            $this->url='javascript:history.back()';
		}
		return $this;
	}


}