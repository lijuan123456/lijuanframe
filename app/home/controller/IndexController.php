<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 15:52
 */

namespace app\home\controller;


use houdunwang\core\Controller;
 use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Stu;

//创建类方便调用
class IndexController extends Controller
{
	//方法
	public  function index(){
		//echo 1;
		//echo 'www';
		//parent::index();
		//parent ::message ();
		//这里把view接收过来的输出
		//$url = "http://www.baidu.com";
		//$data = [
		//	"username" => '杨宇辉' ,
		//	"password" => "admin888"
		//];
		//View::make()->with(compact ("url","data"));
		//把with这个放在前面是对象 make就相当于是一个方法我们要先加载数据在加载模板
		//View::with(compact ("url","data"))->make('welcome');
		$res = c();
		//p($res);die;
		//$res = c('database');
		//$res= c('database.name');
		//p($res);
		//$data = Model::query('select * from student');
		//p($data);
		//$this->setRedirect ()->message ('成功');
		//$data = Model::query('select * from student');
		//p()
		//p(Stu::get());DIE;
		//$data = Stu::get();
		//$data = Stu::find(1);
		//p($data);
		//$data = Stu::where(' id=1 ')->get();
		//p($data);
		$data = Stu::where('id=1')->orderBy('id asc')->field('id,name,age')->limit(3)->get();
		p($data);


	}

}