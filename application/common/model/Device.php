<?php
namespace app\common\model;

use think\Model;

class Device extends Model
{
	public function getDevice($username)
	{
		$devices = self::where('user_name', $username)->select();
		
		return json_encode($devices);
	}
	
	public function getAllDevice()
	{
		$devices = self::select();
		
		return json_encode($devices);
	}
}