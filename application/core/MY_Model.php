<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		
	}
}

class Base_Model extends MY_Model{
	protected $table_name = '';
	public  $db_tablepre = 't_sys_';
	
	
	function __construct(){
	
		$this->table_name = $this->db_tablepre.$this->table_name;
		
		parent::__construct();
	}
	
	function set_db($db_config='')
	{
		$this->db= $this->load->database($db_config,TRUE);
	}
	
	/**
	 *  设置表名
	 */
	function set_table_name($tablename='',$tablepre='t_sys_')
	{
		$this->db_tablepre = $tablepre;
		$this->table_name = $this->db_tablepre.$this->table_name;
	}
	
	/**
	 *  缓存sql查询
	 */
	final  public function cache_select($where = '', $data = '*', $limit = '', $order = '', $group = '', $key='')
	{
		$this->db->cache_on();
		$result=$this->select($where,$data,$limit,$order,$group,$key);
		$this->db->cache_off();
		return $result;
	}
	
	
	/**
	 * 查询多条数据并分页扩展
	 * @param $where
	 * @param $order
	 * @param $page
	 * @param $pagesize
	 * @return unknown_type
	 */
	final public function listinfo($where = '',$data='*', $order = '', $page = 1, $pagesize = 20, $key='', $setpages = 10,$urlrule = '',$array = array()) {
		$this->number = $this->count($where);
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		if($offset>$this->number)
		{
			$page=round($this->number/$pagesize);
			$offset = max($pagesize*($page-1),0);
		}
	

		if($this->number >$pagesize)
			$this->pages = pages($this->number, $page, $pagesize, $urlrule, $array, $setpages);
		else
			$this->pages = "";
		$array = array();
		if ($this->number > 0) {
			return $this->select($where, $data, "$offset, $pagesize", $order, '', $key);
		} else {
			return array();
		}
	}
	
	/**
	 * 执行sql查询
	 * @param $where 		查询条件[例`name`='$name']
	 * @param $data 		需要查询的字段值[例`name`,`gender`,`birthday`]
	 * @param $limit 		返回结果范围[例：10或10,10 默认为空]
	 * @param $order 		排序方式	[默认按数据库默认方式排序]
	 * @param $group 		分组方式	[默认为空]
	 * @param $key          返回数组按键名排序
	 * @return array		查询结果集数组
	 */
	final public function select($where = '', $data = '*', $limit = '', $order = '', $group = '', $key='') {
		
		if (!empty($where))
		{
		 $where = $this->db->where($where);
		}
		$data=str_replace("，",",",$data);
		$this->db->select($data);
		if(!empty($limit))
		{
			$limit_arr=explode(",", $limit);
			if(count($limit_arr)==1)
				$this->db->limit($limit);
			else
				$this->db->limit($limit_arr[1],$limit_arr[0]);
		}
		if(!empty($order))$this->db->order_by($order); 
		if(!empty($group))$this->db->group_by($group);
		
		$this->db->from($this->table_name);
		$datalist =array();
		$Q = $this->db->get();
	    if ($Q->num_rows() > 0)
	    {
	        foreach ($Q->result_array() as $rs)
	        {
		        if($key) {
					$datalist[$rs[$key]] = $rs;
				} else {
					$datalist[] = $rs;
				}
	        }
	    }
	
	    $Q->free_result();
		return $datalist;
	}

	/**
	 * 处理sql查询结果
	 * @return array		查询结果集数组
	 */
	final public function process_sql($get_db_data,$key='') {
		$datalist =array();
		$Q = $get_db_data;
	    if ($Q->num_rows() > 0)
	    {
	        foreach ($Q->result_array() as $rs)
	        {
		        if($key) {
					$datalist[$rs[$key]] = $rs;
				} else {
					$datalist[] = $rs;
				}
	        }
	    }
	
	    $Q->free_result();
		return $datalist;
	}
	
	/**
	 * 执行sql查询
	 * @param $where 		SQL
	 * @return array		查询结果集数组
	 */
	final public function select_sql($sql,$key='') {
		$datalist =array();
		$Q = $this->db->query($sql);

	    if ($Q->num_rows() > 0)
	    {
	        foreach ($Q->result_array() as $rs)
	        {
		        if($key) {
					$datalist[$rs[$key]] = $rs;
				} else {
					$datalist[] = $rs;
				}
	        }
	    }
	
	    $Q->free_result();
		return $datalist;
	}

	/**
	 * 执行sql查询
	 * @param $where 		SQL
	 * @return array		查询结果集数组
	 */
	final public function select_db_sql($db,$sql,$key='') {
		$datalist =array();
		$Q = $db->query($sql);
	    if ($Q->num_rows() > 0)
	    {
	        foreach ($Q->result_array() as $rs)
	        {
		        if($key) {
					$datalist[$rs[$key]] = $rs;
				} else {
					$datalist[] = $rs;
				}
	        }
	    }
	
	    $Q->free_result();
		return $datalist;
	}
	
	/**
	 * 获取单条记录查询
	 * @param $where 		查询条件
	 * @param $data 		需要查询的字段值[例`name`,`gender`,`birthday`]
	 * @param $order 		排序方式	[默认按数据库默认方式排序]
	 * @param $group 		分组方式	[默认为空]
	 * @return array/null	数据查询结果集,如果不存在，则返回空
	 */
	final public function get_one($where = '', $data = '*', $order = '', $group = '') {
		$datainfo= $this->select($where , $data, '1', $order , $group);
		if(count($datainfo)>0)$datainfo=$datainfo[0];
		
	/*	if(defined('IN_ADMIN'))
		foreach($datainfo as $k=>$v)
		{
			if(!defined('NOT_CONVERT'))
			$datainfo[$k]=htmlspecialchars($v);
		}*/
		return $datainfo;
	}
	
	/**
	 * 直接执行sql查询
	 * @param $sql							查询sql语句
	 * @return	boolean/query resource		如果为查询语句，返回资源句柄，否则返回true/false
	 */
	final public function query($sql) {
		return $this->db->query($sql);
	}
	
	/**
	 * 执行添加记录操作
	 * @param $data 		要增加的数据，参数为数组。数组key为字段值，数组值为数据取值
	 * @param $return_insert_id 是否返回新建ID号
	 * @return boolean
	 */
	final public function insert($data, $return_insert_id = true) {
		if(DEMO_STATUS)return true;
		$this->db->insert($this->table_name, $data);
		if($return_insert_id)return $this->db->insert_id();
	}
	
	final public function insert_batch($data)
	{
		return $this->db->insert_batch($this->table_name, $data);
	}
	
	/**
	 * 获取最后一次添加记录的主键号
	 * @return int 
	 */
	final public function insert_id() {
		return $this->db->insert_id();
	}
	
	/**
	 * 执行更新记录操作
	 * @param $data 		要更新的数据内容，参数可以为数组也可以为字符串，建议数组。
	 * 						为数组时数组key为字段值，数组值为数据取值
	 * 						为字符串时[例：`name`='phpcms',`hits`=`hits`+1]。
	 *						为数组时[例: array('name'=>'phpcms','password'=>'123456')]
	 *						数组的另一种使用array('name'=>'+=1', 'base'=>'-=1');程序会自动解析为`name` = `name` + 1, `base` = `base` - 1
	 * @param $where 		更新数据时的条件,可为数组或字符串
	 * @return boolean
	 */
	final public function update($data, $where = '',$use_set=false) {
		if(DEMO_STATUS)return true;
		$this->db->where($where);
	
		if(is_array($data))
			{
				foreach($data as $k=>$v)
				{
					switch (substr($v, 0, 2)) {
						case '+=':
							$this->db->set($k, $k."+".str_replace("+=","",$v), false);
							unset($data[$k]);
							break;
						case '-=':
							$this->db->set($k, $k."-".str_replace("-=","",$v), false);
							unset($data[$k]);
							break;
						case '<>':
							$this->db->set($k, $k."<>".$v, false);
							unset($data[$k]);
							break;
						case '<=':
							$this->db->set($k, $k."<=".$v, false);
							unset($data[$k]);
							break;
						case '>=':
							$this->db->set($k, $k.">=".$v, false);
							unset($data[$k]);
							break;
						case '^1':
							$this->db->set($k, $k."^1", false);
							unset($data[$k]);
							break;
						case 'in':
							if(substr($v, 0, 3)=="in("){
								$this->db->where_in($k, $v, false);
								unset($data[$k]);
								break;
							}else{

							}

						default:
							$this->db->set($k, $v, true);
					}
				}
			}
		
		return $this->db->update($this->table_name, $data);
	}
	
	/**
	 * 返回最后运行的查询（是查询语句，不是查询结果）
	 * @return int 
	 */
	final public function last_query() {
		return $this->db->last_query();
	}
	
	/**
	 * 执行删除记录操作
	 * @param $where 		删除数据条件,不充许为空。
	 * @return boolean
	 */
	final public function delete($where) {
		if(DEMO_STATUS)return true;
		return $this->db->delete($this->table_name, $where);
	}
	
	/**
	 * 计算记录数
	 * @param string/array $where 查询条件
	 */
	final public function count($where = '') {
		$r = $this->get_one($where, "COUNT(*) AS num");
		return isset($r['num'])?$r['num']:0;
	}
	
	
	
	final public function sum($field,$where = '') {
		$r = $this->get_one($where, "sum({$field}) AS s");
		return $r['s'];
	}
	
	final public function max_one($field,$where = '') {
		$r = $this->get_one($where, "max({$field}) AS s");
		return $r;
	}
	
	/**
	 * 生成sql语句，如果传入$in_cloumn 生成格式为 IN('a', 'b', 'c')
	 * @param $data 条件数组或者字符串
	 * @param $front 连接符
	 * @param $in_column 字段名称
	 * @return string
	 */
	final public function to_sqls($data, $front = ' AND ', $in_column = false,$is_digt=false) {
		if($in_column && is_array($data)) {
			$ids = '\''.implode('\',\'', $data).'\'';
			if($is_digt)$ids = implode(',', $data) ;
			$sql = "$in_column IN ($ids)";
			return $sql;
		} else {
			if ($front == '') {
				$front = ' AND ';
			}
			if(is_array($data) && count($data) > 0) {
				$sql = '';
				foreach ($data as $key => $val) {
					$sql .= $sql ? " $front `$key` = '$val' " : " `$key` = '$val' ";	
				}
				return $sql;
			} else {
				return $data;
			}
		}
	}
	
}
