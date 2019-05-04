<?php
namespace app\api\controller;

use think\Request;
use think\Session;
use app\common\model\User;
use app\common\model\Device;
use app\common\model\MonitorData;

class Device
{
	public function getDevice()
	{
		$device = new Device;
		$devices = $device->getDevice("admin");
		
		return $devices;
	}
	
	public function getAllDevice()
	{
		$device = new Device;
		$devices = $device->getAllDevice();
		
		return $devices;
	}

	public function addDevice()
	{
		//接收表单数据
		$postData = Request::instance()->post();
		//实例化Device空对象
		$Device = new Device;
		//为对象赋值
		$Device->device_number = $postData['device_number'];
		$Device->address = $postData['address'];
		$Device->longitude = $postData['longitude'];
		$Device->latitude = $postData['latitude'];
		$Device->user_name = $postData['user_name'];
		//保存到数据库中
		$result = $Device->save();
		
		return json_encode($result);
	}

	public function deleteDevice()
	{
		//接收表单数据
		$postData = Request::instance()->post();
		//获取要删除的对象
		$Device = Device::get($postData['device_number']);
		//删除对象
		$result = $Device->delete();
		
		return json_encode($result);
	}
}