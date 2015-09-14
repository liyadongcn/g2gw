<?php
namespace common\models\helper;

use yii;

class BrowserHelper
{

	/*判断是否移动端访问*/
	
	public static function is_mobile() {
	
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
	
		$mobile_browser = Array(
	
				"mqqbrowser", //手机QQ浏览器
	
				"opera mobi", //手机Opera
	
				"juc","iuc",//UC浏览器
	
				"fennec","ios","applewebKit/420","applewebkit/525","applewebkit/532","ipad","iphone","ipaq","ipod",
	
				"iemobile", "windows ce",//windows phone
	
				"240×320","480×640","acer","android","anywhereyougo.com","asus","audio","blackberry","blazer","coolpad" ,"dopod", "etouch", "hitachi","htc","huawei", "jbrowser", "lenovo","lg","lg-","lge-","lge", "mobi","moto","nokia","phone","samsung","sony","symbian","tablet","tianyu","wap","xda","xde","zte"
	
		);
		
		$is_mobile = false;
	
		foreach ($mobile_browser as $device) {
	
			if (stristr($user_agent, $device)) {
	
				$is_mobile = true;break;
			}
		}	
				return $is_mobile;
	}
}