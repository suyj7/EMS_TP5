<?php
namespace app\api\behavior;

use think\Reponse;

class CORS
{
	public function appInit(&$params)
	{
		header('Access-Control-Allow-Origin: http://localhost:8088');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Headers: token, Origin, X-Requested-With, Content-Type, Accept');
		header('Access-Control-Allow-Methods: POST, GET');
		if (request()->isOptions()) {
			exit();
		}
	}
}