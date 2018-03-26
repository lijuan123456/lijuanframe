<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/22
 * Time: 15:44
 */

namespace houdunwang\view;


class Base
{
	//这里不用include是因为他只能在自己里加载所以声明一个属性方便其他地方都可以用
	private $file;
	//这里接收数据库
	private $data;
	public function make ( $tpl = '' )
	{
		//检测一下$tpl这个是否存接收到没有走默认值(常量是可以在其他地方随便用的)
		$tpl = $tpl ? $tpl : ACTION;
		//调用模板里面的值不能写死这样可以调用APP里的其他模板。
		$this->file = '../app/' . MODUME . '/view/' . CONTROLLER . '/' . $tpl . '.php';
		//把结果反出view里的runParse
		return $this;
	}
	//分配变量
	public function with($arr){
		//把数据接收过来
		$this->data = $arr;
		//返回出来外面接收的是个对象.把结果反出view里的runParse
		return $this;
	}

/*	public function __toString ()
	{
		//第一，取出变量
		extract ( $this->data );
		if(!file_exists ( $this->file )){
			throw new \Exception( '错误提示:文件不存在' );
		}
		include_once $this->file;
		return '';
	}*/

	/**
	 *析构函数
	 * 在类运行完的时候自动执行它
	 */
	public function __destruct ()
	{
		//第一，取出变量
		extract ( $this->data );
		//第二，判断这个文件存在不
		if(!file_exists ( $this->file )){
			//throw把抛出的错误事一组的从错误的起点到进过哪里在会到错误的放
			throw new \Exception( '错误提示:文件不存在' );
		}
		//引入模板
		include_once $this->file;
	}
}
