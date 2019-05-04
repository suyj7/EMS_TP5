<?php
namespace app\api\controller;

use think\Request;
use think\Session;
use app\common\model\User;
use app\common\model\Device;
use app\common\model\MonitorData;

class User
{
	public function login()
	{
		//获取表单提交的数据
		$postData = Request::instance()->post();
		$returnData = array('status' => 0, 'message' => '登录失败', 'authorization' => 0);
		
		//检查提交的数据是否含有username和password字段
		if (array_key_exists('username', $postData) && array_key_exists('password', $postData) && array_key_exists('captcha', $postData)) {
			
			//检查验证码
			if (captcha_check($postData['captcha'])) {
				
				//判断是否成功登录
				if (User::login($postData['username'], $postData['password'])) {
					$returnData['status'] = 1;
					$returnData['message'] = '登录成功';
					//获取权限
					$returnData['authorization'] = User::getAuthorization($postData['username']);
				} else {
					$returnData['status'] = 0;
					$returnData['message'] = '用户名或密码错误';
				}
				
			} else {
				$returnData['status'] = 0;
				$returnData['message'] = '验证码错误';				
			}
			
		} else {
			$returnData['status'] = 2;
			$returnData['message'] = '请求数据格式有误';
		}
		
		return json_encode($returnData);
	}
	
	public function logout()
	{		
		return json_encode(User::logout());
	}
	
	public function getCaptcha() 
	{
		return captcha_src();
	}
}