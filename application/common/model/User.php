<?php
namespace app\common\model;

use think\Model;
use think\Session;

class User extends Model
{
	static public function login($username, $password)
	{
		$map = array('username' => $username);
		$User = self::get($map);
		
		//验证用户是否存在
		if (!is_null($User)) {
			//验证密码是否正确
			if ($User->getData('password') === $password) {
				Session::set('UserId', $User->getData('id'));
				return true;
			}
		}
		
		return false;
	}
	
	static public function logout()
	{
		//验证是否登录
		if (Session::has('UserId')) {
			//用户ID存在，已登录
			Session::delete('UserId');
			return true;
		}
		
		return false;
	}
}