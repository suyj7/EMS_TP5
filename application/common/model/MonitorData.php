<?php
namespace app\common\model;

use think\Model;

class MonitorData extends Model
{
	public function getRealtimeData($deviceId)
	{
		$realtimeData = self::where('deviceId', $deviceId)->limit(1)->order('time', 'desc')->select();
		
		return json_encode($realtimeData);
	}
	
	public function getHistoryData($deviceId)
	{
		$historyData = self::where('deviceId', $deviceId)->limit(10)->order('time', 'asc')->select();
		
		return json_encode($historyData);
	}
}