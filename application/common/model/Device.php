<?php
namespace app\common\model;

use think\Model;

class Device extends Model
{
	public function getDevice($username)
	{
		$devices = self::where('user', $username)->select();
		
		return json_encode($devices);
	}
}