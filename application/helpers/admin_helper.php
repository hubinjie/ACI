<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('isset_trim'))
	{
		function isset_trim($var)
		{
			if(!isset($var))return false;
			if(trim($var)=="")return false;
			return true;
		}
	}
	
