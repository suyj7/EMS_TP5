<?php
namespace app\api\controller;

use think\Request;
use think\Session;
use app\common\model\User;
use app\common\model\Device;
use app\common\model\MonitorData;

class MonitorData
{
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
	
	public function addMonitorData()
	{
		//接收数据{data: [['device_number', 'temperature', 'pm2.5', 'humidity', 'formaldehyde', 'light', 'time'], []], otherData: {}}
		//$postData = Request::instance()->post();
		//获取环境数据
		//$monitorData = $postData['data'];
		$monitorData = [['3', '34', '10', '20', '100', '30', '2019-04-09 19:21:58']];
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