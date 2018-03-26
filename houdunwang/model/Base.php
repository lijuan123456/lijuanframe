<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/22
 * Time: 21:11
 */

namespace houdunwang\model;

use PDO;
use Exception;

class Base
{
	//设置成静态覅昂便调用
	private static $pdo = null;
	//库里的表
	private static $table;
	//条件
	private static $where = '';
	//排序
	private static $order = '';
	//创建条件的方法
	private $field = '';
	private $limit = '';

	public function __construct ( $class )
	{
		//链接数据库
		self::connect ();

		//获取对应的模型名称
		self::$table = strtolower ( ltrim ( strrchr ( $class , '\\' ) , '\\' ) );

	}


	public function where ( $where )
	{
		//	拼接条件
		self::$where = $where ? ' where ' . $where : '';

		return $this;

	}

	//创建排序方法
	public function orderBy ( $order )
	{
		//p($order);
		//拼接排序
		self::$order = $order ? ' order by ' . $order : '';

		return $this;
	}

	// 添加字段
	public function field ( $array )
	{
		// p($one);
		$this->field = $array ? $array : '  ';
		// p($array);die;
		// return current ($this->query ( $sql ));
		return $this;
	}

	// 限制条数
	public function limit ( $num )
	{
		// p($num);die;
		$this->limit = $num ? ' limit ' . $num : '';

		//p($this->limit);
		return $this;
	}

	public function get ()
	{
		$this->field = $this->field ? $this->field : "*";
		$sql = "select ".$this->field." from  " . self::$table . self::$order . $this->limit;
		return $this->query ( $sql );
	}
	//找到主键
	public function find ( $pri )
	{
		//获取数据库里的表的主键名
		//p($pri);
		//现获取当前操作的数据表主键字段名是什么
		$priField = $this->getPriField($pri);
		// p($priField);die;
		$sql = "select * from " . self::$table . ' where '.$priField. "= " . $pri;
		//将结果处理成一维数组返回
		return current ($this->query ( $sql ));
	}

	//获得主键id
	private function getPriField ()
	{
		//打印出标的详细信息
		$res = $this->query ( 'desc ' . self::$table );
		//循环整个库里的表
		foreach ( $res as $k=>$v ) {
			//p($v);die;
			//如果小标是key的值时PRI那么找到Field他的值时ID
			if ( $v[ 'Key' ] == 'PRI' ) {
				//把IDreturn出来
				return $v[ 'Field' ];
			}
		}
	}
	//
	//为了不用反复链接数据库，第一次进行链接，将链接的状态保存下来
	public function connect ()
	{
		//判断是否为空
		if ( is_null ( self::$pdo ) ) {
			try {
				//入口的具体的库（top）和地址用函数把里面的数据替换
				//$dsn = 'mysql:host=127.0.0.1;dbname=top';

				$dsn = 'mysql:host=' . c ( 'database.host' ) . ';dbname=' . c ( 'database.name' );

				//密码用户名用函数替换掉
				//self::$pdo = new PDO( $dsn , 'root' , 'root' );
				self::$pdo = new PDO( $dsn , c ( 'database.user' ) , c ( 'database.pass' ) );
				//改成PHP是别的编码utf8
				self::$pdo->query ( 'set name utf8' );
				//跑出异常
				self::$pdo->setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
				//走这里Exception跑出错误信息固定写法 $e参数
			} catch ( Exception $e ) {
				//如果有错误的信息就要停止不往下走。getMessage接收错误信息
				throw new Exception( $e->getMessage () );
			}

		}
	}

	//select有结果集查询
	public function query ( $spl )
	{
		try {
			//调用数据库 query里的参数是查询语句
			$res = self::$pdo->query ( $spl );

			//显示fetchAll所有的。 FETCH_ASSOC关联数组 把结果return 出来
			return $res->fetchAll ( PDO::FETCH_ASSOC );
			//走这里Exception跑出错误信息固定写法 $e参数
		} catch ( Exception $e ) {
			//如果有错误的信息就要停止不往下走。getMessage接收错误信息
			throw new Exception( $e->getMessage () );

		}
	}

	//有无结果集查询(insert、delete、update)
	public function exec ( $spl )
	{
		try {
			//调用数据库 exec 往数据库里写入信息或删除或修改
			return self::$pdo->exec ( $spl );
			//走这里Exception跑出错误信息固定写法 $e参数
		} catch ( Exception $e ) {
			//如果有错误的信息就要停止不往下走。getMessage接收错误信息
			throw new Exception( $e->getMessage () );

		}
	}
}
//实例化model
//$pdo = new Base();
//穿的参数
//$sql = "select * from student";
//调用方法
//$res = $pdo->query ( $sql );p ($res);
//添加一天数据
//$sql = "insert into student (name) values('ukl')";
//删除一天数据
//$sql = "delete from student where name='ukl'";
//改掉数据里的name名
//$sql ="update student set name='巧克力'";
//调用方法
//$res = $pdo->exec ( $sql );
