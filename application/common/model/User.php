<?php
namespace app\common\model;

use think\Model;
use think\Session;

class User extends Model
{
	static public function login($username, $password)
	{
		$map = array('user_name' => $username);
		$User = self::get($map);
		
		//验证用户是否存在
		if (!is_null($User)) {
			//验证密码是否正确
			if ($User->getData('password') === $password) {
				Session::set('UserName', $User->getData('user_name'));
				return true;
			}
		}
		
		return false;
	}
	
	static public function getAllUser()
	{
		$users = self::select();
		
		return json_encode($users);
	}
	
	static public function getAuthorization($username)
	{
		$map = array('user_name' => $username);
		$User = self::get($map);
		return $User->getData('authorization');
	}
	
	static public function logout()
	{
		//验证是否登录
		if (Session::has('UserName')) {
			//用户ID存在，已登录
			Session::delete('UserName');
			return true;
		}
		
		return false;
	}
}