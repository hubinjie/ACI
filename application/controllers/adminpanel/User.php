<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends Admin_Controller {
	
	var $method_config;
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Times_model'));
		$this->load->helper(array('member','auto_codeIgniter','string'));
		
		$this->method_config['upload'] = array(
										'thumb'=>array('upload_size'=>1024,'upload_file_type'=>'jpg|png|gif','upload_path'=>'uploadfile/user','upload_url'=>SITE_URL.'uploadfile/user/'),
										);
	}
	
	function index($page_no=1)
	{
		$page_no = max(intval($page_no),1);
        
        $where_arr = array();
		$orderby = $keyword= "";
        if (isset($_GET['dosubmit'])) {
			$keyword =isset($_GET['keyword'])?safe_replace(trim($_GET['keyword'])):'';
			if($keyword!="") $where_arr[] = "concat(username,fullname,email,mobile) like '%{$keyword}%'";
        	
        }
        $where = implode(" and ",$where_arr);
        $data_list = $this->Member_model->listinfo($where,'*',$orderby , $page_no, $this->Member_model->page_size,'',$this->Member_model->page_size,page_list_url('adminpanel/user/index',true));
				
		$this->view('index',array('data_list'=>$data_list,'pages'=>$this->Member_model->pages,'keyword'=>$keyword,'require_js'=>true));
	}
	
	function check_username($username='')
	{
		if(isset($_POST['username'])&&$username==''){
			$username = trim(safe_replace($_POST['username']));
			$c = $this->Member_model->count(array('username'=>$username));
			echo  $c>0?'{"valid":false}':'{"valid":true}';
		}else{
			$username = trim(safe_replace($username));
			$c = $this->Member_model->count(array('username'=>$username));
			return $c>0?true:false;
		}
		
	}
	
	 /**
     * 删除选中数据
     * @param post pid 
     * @return void
     */
    function delete()
    {
        if(isset($_POST))
		{
			$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
			$where = $this->Member_model->to_sqls($pidarr, '', 'user_id');
			$status = $this->Member_model->delete($where);
			if($status)
			{
				$this->showmessage('操作成功', HTTP_REFERER);
			}else 
			{
				$this->showmessage('操作失败');
			}
		}
    }
	
	function lock()
	{
		if(isset($_POST))
		{
			$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
			$where = $this->Member_model->to_sqls($pidarr, '', 'user_id');
			$status = $this->Member_model->update(array('is_lock'=>'^1'),$where);
			if($status)
			{
				$this->showmessage('操作成功', HTTP_REFERER);
			}else 
			{
				$this->showmessage('操作失败');
			}
		}
	}
	
	function edit($id=0)
	{
		$id = intval($id);
        
        $data_info =$this->Member_model->get_one(array('user_id'=>$id));
		
		//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
			if(!$data_info)exit(json_encode(array('status'=>false,'tips'=>'信息不存在')));


			$password = isset($_POST["password"])?trim(safe_replace($_POST["password"])):exit(json_encode(array('status'=>false,'tips'=>'密码不能为空')));
			
			$repassword = isset($_POST["repassword"])?trim(safe_replace($_POST["repassword"])):exit(json_encode(array('status'=>false,'tips'=>'密码不能为空')));
			if($repassword!=$password)exit(json_encode(array('status'=>false,'tips'=>'密码输入不一样')));
			
			if(trim($password)!="")$password = md5(md5($password.$data_info['encrypt']));
			else
				$password = $data_info['password'];
			
			
			$email = isset($_POST["email"])?trim(safe_replace($_POST["email"])):exit(json_encode(array('status'=>false,'tips'=>'EMAIL不能为空')));
			if($email=='')exit(json_encode(array('status'=>false,'tips'=>'EMAIL不能为空')));
			if(!is_email($email))
			{
				exit(json_encode(array('status'=>false,'tips'=>'EMAIL格式不正确')));
			}

			$mobile= isset($_POST["mobile"])?trim(safe_replace($_POST["mobile"])):exit(json_encode(array('status'=>false,'tips'=>'手机号不能为空')));
			if(!is_mobile($mobile)){
				exit(json_encode(array('status'=>false,'tips'=>'手机号格式不正确')));
			}
			
			$group_id= isset($_POST["group_id"])?intval($_POST["group_id"]):exit(json_encode(array('status'=>false,'tips'=>'用户组不能为空')));
			if($group_id==0)
			{
				exit(json_encode(array('status'=>false,'tips'=>'用户组不能为空')));
			}
			
			$fullname= isset($_POST["fullname"])?trim(safe_replace($_POST["fullname"])):exit(json_encode(array('status'=>false,'tips'=>'全名不能为空')));
			$thumb= isset($_POST["thumb"])?trim(safe_replace($_POST["thumb"])):exit(json_encode(array('status'=>false,'tips'=>'成员图像不能为空')));
			$is_lock= isset($_POST["is_lock"])?intval($_POST["is_lock"]):exit(json_encode(array('status'=>false,'tips'=>'是否锁定登录不能为空')));
			
            $status = $this->Member_model->update(
												array(
													'password'=>$password,
													'group_id'=>$group_id,
													'mobile'=>$mobile,
													'email'=>$email,
													'fullname'=>$fullname,
													'is_lock'=>$is_lock,
													'avatar'=>$thumb
											),array('user_id'=>$id));
            if($status)
            {
				exit(json_encode(array('status'=>true,'tips'=>'修改成功')));
            }else
            {
            	exit(json_encode(array('status'=>false,'tips'=>'修改失败')));
            }
        }else
        {
			if(!$data_info)$this->showmessage('信息不存在');
        	$this->view('edit',array('is_edit'=>true,'data_info'=>$data_info,'require_js'=>true));
        }
	}
	
	function add()
	{
		//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
        	//接收POST参数
			$username = isset($_POST["username"])?trim(safe_replace($_POST["username"])):exit(json_encode(array('status'=>false,'tips'=>'用户名不能为空')));
			if($username=='')exit(json_encode(array('status'=>false,'tips'=>'用户名不能为空')));
			
			$password = isset($_POST["password"])?trim(safe_replace($_POST["password"])):exit(json_encode(array('status'=>false,'tips'=>'密码不能为空')));
			if($password=='')exit(json_encode(array('status'=>false,'tips'=>'密码不能为空')));
			
			$repassword = isset($_POST["repassword"])?trim(safe_replace($_POST["repassword"])):exit(json_encode(array('status'=>false,'tips'=>'密码不能为空')));
			if($repassword=='')exit(json_encode(array('status'=>false,'tips'=>'重复密码不能为空')));
			if($repassword!=$password)exit(json_encode(array('status'=>false,'tips'=>'密码输入不一样')));
			$encrypt = random_string('alnum',5);
			$password = md5(md5($password.$encrypt));
			
			
			$email = isset($_POST["email"])?trim(safe_replace($_POST["email"])):exit(json_encode(array('status'=>false,'tips'=>'EMAIL不能为空')));
			if($email=='')exit(json_encode(array('status'=>false,'tips'=>'EMAIL不能为空')));
			if(!is_email($email))
			{
				exit(json_encode(array('status'=>false,'tips'=>'EMAIL格式不正确')));
			}
			
			$group_id= isset($_POST["group_id"])?intval($_POST["group_id"]):exit(json_encode(array('status'=>false,'tips'=>'用户组不能为空')));
			if($group_id==0)
			{
				exit(json_encode(array('status'=>false,'tips'=>'用户组不能为空')));
			}


			$mobile= isset($_POST["mobile"])?trim(safe_replace($_POST["mobile"])):exit(json_encode(array('status'=>false,'tips'=>'手机号不能为空')));
			if(!is_mobile($mobile)){
				exit(json_encode(array('status'=>false,'tips'=>'手机号格式不正确')));
			}

			$fullname= isset($_POST["fullname"])?trim(safe_replace($_POST["fullname"])):exit(json_encode(array('status'=>false,'tips'=>'全名不能为空')));
			$thumb= isset($_POST["thumb"])?trim(safe_replace($_POST["thumb"])):exit(json_encode(array('status'=>false,'tips'=>'成员图像不能为空')));
			$is_lock= isset($_POST["is_lock"])?intval($_POST["is_lock"]):exit(json_encode(array('status'=>false,'tips'=>'是否锁定登录不能为空')));
			
			if($this->check_username($username))exit(json_encode(array('status'=>false,'tips'=>'用户名已经存在')));
            $new_id = $this->Member_model->insert(
												array(
													'username'=>$username,
													'password'=>$password,
													'group_id'=>$group_id,
													'email'=>$email,
													'mobile'=>$mobile,
													'fullname'=>$fullname,
													'is_lock'=>$is_lock,
													'avatar'=>$thumb,
													'reg_time'=>date('Y-m-d H:i:s'),
													'encrypt'=>$encrypt,
													'reg_ip'=>$this->input->ip_address(),
											));
            if($new_id)
            {
				exit(json_encode(array('status'=>true,'tips'=>'新增成功','new_id'=>$new_id)));
            }else
            {
            	exit(json_encode(array('status'=>false,'tips'=>'新增失败','new_id'=>0)));
            }
        }else
        {
        	$this->view('edit',array('is_edit'=>false,'require_js'=>true,'data_info'=>$this->Member_model->default_info()));
        }
	}
	
	/**
     * 上传附件
     * @param string $fieldName 字段名
     * @param string $controlId HTML控件ID
     * @param string $callbackJSfunction 是否返回函数
     * @return void
     */
	function upload($fieldName='',$controlId='',$callbackJSfunction=false)
	{
		$isImage=true;
    	if( isset($this->method_config['upload'][$fieldName]))
        {
        	if(isset($_POST['dosubmit']))
            {
                $upload_path = $this->method_config['upload'][$fieldName]['upload_path'];
               
               
               if($upload_path=='')die('缺少上传参数');
               
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = $this->method_config['upload'][$fieldName]['upload_file_type'];
                $config['max_size'] = $this->method_config['upload'][$fieldName]['upload_size'];
                $config['overwrite']  = FALSE;
                $config['encrypt_name']=false;
                $config['file_name']=date('Ymdhis').random_string('nozero',4);
               
                dir_create($upload_path);//创建正式文件夹
                $this->load->library('upload', $config);
                 
                if ( ! $this->upload->do_upload('upload')) $this->showmessage("上传失败:".$this->upload->display_errors());
                $filedata =  $this->upload->data();
                
                $file_name = $filedata['file_name'];
                $file_size = $filedata['file_size'];
                $image_width = $isImage?$filedata['image_width']:0;
                $image_height =  $isImage?$filedata['image_height']:0;
                $uc_first_id=  ucfirst($controlId);
                $this->showmessage("上传成功！",'','','',$callbackJSfunction?"window.parent.get{$uc_first_id}(\"$file_name\",\"$file_size\",\"$image_width\",\"$image_height\");":"$(window.parent.document).find(\"#$controlId\").val(\"$file_name\");$(\"#dialog\" ).dialog(\"close\")");	
            }else
            {
            	$this->view('upload',array('field_name'=>$fieldName,'control_id'=>$controlId,'upload_url'=>$this->method_config['upload'][$fieldName]['upload_url'],'is_image'=>$isImage,'hidden_menu'=>true));
            }
        }else
        {
        	die('缺少上传参数');
        }
	}

	/**
	 * 用户弹窗
	 * @return array
	 */
	function user_window($controlId='',$page_no=0)
	{
		$page_no = max(intval($page_no),1);

		$where_arr = array();
		$orderby = $keyword= "";
		if (isset($_GET['dosubmit'])) {
			$keyword =isset($_GET['keyword'])?safe_replace(trim($_GET['keyword'])):'';
			if($keyword!="") $where_arr[] = "concat(username,fullname,email,mobile) like '%{$keyword}%'";

		}
		$where = implode(" and ",$where_arr);
		$data_list = $this->Member_model->listinfo($where,'*',$orderby , $page_no, $this->Member_model->page_size,'',$this->Member_model->page_size,page_list_url('adminpanel/user/index',true));

		$this->view('choose',array('hidden_menu'=>true,'data_list'=>$data_list,'control_id'=>$controlId,'pages'=>$this->Member_model->pages,'keyword'=>$keyword,'require_js'=>true));
	}
}