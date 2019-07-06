<?php
namespace app\api\controller;

use think\Request;
use think\Session;
use app\common\model\User;
use app\common\model\Device;
use app\common\model\MonitorData;

class Index
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
	
	public function getDevice()
	{
		//获取用户名
		$postData = Request::instance()->post();
		$user = $postData['user'];
		//获取用户名下的设备
		$device = new Device;
		$devices = $device->getDevice($user);
		
		return $devices;
	}
	
	public function getAllDevice()
	{
		$device = new Device;
		$devices = $device->getAllDevice();
		
		return $devices;
	}
	
	public function getAllUser()
	{
		return User::getAllUser();
	}
	
	public function getRealtimeData()
	{
		$monitorData = new MonitorData;
		$realtimeData = $monitorData->getRealtimeData(1);
		
		return $realtimeData;
	}
	
	public function getHistoryData()
	{
		$monitorData = new MonitorData;
		$historyData = $monitorData->getHistoryData(1);
		
		return $historyData;
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
	
	public function addUser()
	{
		//接收表单数据
		$postData = Request::instance()->post();
		//实例化User空对象
		$User = new User;
		//为对象赋值
		$User->user_name = $postData['user_name'];
		$User->password = $postData['password'];
		$User->authorization = $postData['authorization'];
		//保存到数据库中
		$result = $User->save();
		
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
	
		public function deleteUser()
	{
		//接收表单数据
		$postData = Request::instance()->post();
		//获取要删除的对象
		$User = User::get($postData['user_name']);
		//删除对象
		$result = $User->delete();
		
		return json_encode($result);
	}
	
	public function addMonitorData()
	{
		//接收数据{data: [['device_number', 'temperature', 'pm2.5', 'humidity', 'formaldehyde', 'light', 'time'], []], otherData: {}}
		$postData = Request::instance()->post();
		//获取环境数据
		$monitorData = $postData['data'];
		//实例化空对象
		$convertedData = [];
		for($i = 0; $i < count($monitorData); $i++){
			$temp = [];
			$temp['device_number'] = $monitorData[$i][0];
			$temp['temperature'] = $monitorData[$i][1];
			$temp['pm2_5'] = $monitorData[$i][2];
			$temp['humidity'] = $monitorData[$i][3];
			$temp['formaldehyde'] = $monitorData[$i][4];
			$temp['light'] = $monitorData[$i][5];
			$temp['time'] = $monitorData[$i][6];
			
			array_push($convertedData, $temp);
		}
		$MonitorData = new MonitorData;
		
		$MonitorData->saveAll($convertedData);
		return '1';
	}
}