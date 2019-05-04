<?php
namespace app\common\model;

use think\Model;

class MonitorData extends Model
{
	public function getRealtimeData($deviceNumber)
	{
		$realtimeData = self::where('device_number', $deviceNumber)->limit(1)->order('time', 'desc')->select();
		
		return json_encode($realtimeData);
	}
	
	public function getHistoryData($deviceNumber)
	{
		$historyData = self::where('device_number', $deviceNumber)->limit(10)->order('time', 'asc')->select();
		
		return json_encode($historyData);
	}
}