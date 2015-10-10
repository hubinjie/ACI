<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * 生成验证码
 */
class Checkcode{
	//验证码的宽度
	public $width=100;
	
	//验证码的高
	public $height=35;
	
	//设置字体的地址
	private $font;
	
	//设置字体色
	public $font_color;
	
	//设置背景色
	public $background = '#FFFFFF';
	
	//验证码
	private $code;
	
	//生成验证码字符数
	public $code_len = 4;
	
	//字体大小
	public $font_size = 15;
	
	public $img_path;
	
	public $expiration = 300;
	
	//图片内存
	private $img;
	
	//文字X轴开始的地方
	private $x_start;
		
	function __construct() {
		$this->font = FCPATH.'font/elephant.ttf';
		$this->img_path = FCPATH.'images/captcha/';
		
		if(! is_dir($this->img_path)) {
			mkdir($this->img_path);
		}
	}

	/**
	 * 生成验证码
	 */
	public function create_captcha() {
	
		$this->creat_code();
		$this->create_img();
		$now = $this->get_now();
		$this->remove_old_img($now);
		
		header('Content-type:image/png');
		imagepng($this->img);
		imagedestroy($this->img);
		
		return array('word' => $this->code, 'time' => $now, 'image' => $img);
	}
	
	/**
	 * 生成随机验证码。
	 */
	private function creat_code() {
		$CI = & get_instance();
		$CI->load->helper('string');
		$this->code = random_string('alnum', $this->code_len);
	}
	
	/**
	 * 生成图片
	 */
	private function create_img() {
		$this->img = imagecreatetruecolor($this->width, $this->height);
		if (!$this->font_color) {
			$this->font_color = imagecolorallocate($this->img, rand(0,156), rand(0,156), rand(0,156));
		} else {
			$this->font_color = imagecolorallocate($this->img, hexdec(substr($this->font_color, 1,2)), hexdec(substr($this->font_color, 3,2)), hexdec(substr($this->font_color, 5,2)));
		}
		//设置背景色
		$background = imagecolorallocate($this->img,hexdec(substr($this->background, 1,2)),hexdec(substr($this->background, 3,2)),hexdec(substr($this->background, 5,2)));
		//画一个柜形，设置背景颜色。
		imagefilledrectangle($this->img,0, $this->height, $this->width, 0, $background);
		$this->creat_font();
		$this->creat_line();
	}
	
	/**
	 * 生成文字
	 */
	private function creat_font() {
		$x = $this->width/$this->code_len;
		for ($i=0; $i<$this->code_len; $i++) {
			imagettftext($this->img, $this->font_size, rand(-30,30), $x*$i+rand(0,5), $this->height/1.4, $this->font_color, $this->font, $this->code[$i]);
			if($i==0)$this->x_start=$x*$i+5;
		}
	}
	
	/**
	 * 画线
	 */
	private function creat_line() {
		imagesetthickness($this->img, 3);
	    $xpos   = ($this->font_size * 2) + rand(-5, 5);
	    $width  = $this->width / 2.66 + rand(3, 10);
	    $height = $this->font_size * 2.14;
	
	    if ( rand(0,100) % 2 == 0 ) {
	      $start = rand(0,66);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(180, 246);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 110);
	
	    imagearc($this->img, $xpos, $ypos, $width, $height, $start, $end, $this->font_color);
		
	    if ( rand(1,75) % 2 == 0 ) {
	      $start = rand(45, 111);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(200, 250);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 100);
	
	    imagearc($this->img, $this->width * .75, $ypos, $width, $height, $start, $end, $this->font_color);
	}
	
	private function get_now() {
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);
		return $now;
	}
	
	private function remove_old_img($now) {
		$current_dir = @opendir($this->img_path);
		while ($filename = @readdir($current_dir))
		{
			if ($filename != "." and $filename != ".." and $filename != "index.html")
			{
				$name = str_replace(".png", "", $filename);

				if (($name + $this->expiration) < $now)
				{
					//echo $this->img_path.$filename;
					//@unlink($this->img_path.$filename);
				}
			}
		}
		@closedir($current_dir);
	}
	
}