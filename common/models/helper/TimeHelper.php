<?php
namespace common\models\helper;

use yii;

class TimeHelper
{
	/**
	 * This function is to get the friendly time showing.
	 * if the time difference is less than $days ,it will be showed as human readable type such as  one day ago, 10 seconds ago.
	 * otherwise it will show the time format as normal.
	 *
	 * @param datetime|integer $time
	 * @param integer $days the days you hope before that you want to show as a friendly time.
	 * @return string the time format string.
	 *
	 * */
	public static function getRelativeTime($time,$days=null)
	{
		if(empty($time)) return "未知";
		
		$now=time();
		$compareTime=strtotime($time);
		
		$dif_days=ceil(($now-$compareTime)/86400); //60s*60min*24h
		
	
		if( isset($days) && $dif_days>$days){//
			return $time;
		}else{
			return yii::$app->formatter->asRelativeTime($time,time()+8*3600);
		}
	}
	
	public static  function formatTimeLength($length)
	{
		$hour = 0;
		$minute = 0;
		$second = 0;
		$result = '';
	
		if ($length >= 60)
		{
			$second = $length % 60;
			if ($second > 0)
			{
				$result = $second . '秒';
			}
			$length = floor($length / 60);
			if ($length >= 60)
			{
				$minute = $length % 60;
				if ($minute == 0)
				{
					if ($result != '')
					{
						$result = '0分' . $result;
					}
				}
				else
				{
					$result = $minute . '分' . $result;
				}
				$length = floor($length / 60);
				if ($length >= 24)
				{
					$hour = $length % 24;
					if ($hour == 0)
					{
						if ($result != '')
						{
							$result = '0小时' . $result;
						}
					}
					else
					{
						$result = $minute . '小时' . $result;
					}
					$length = floor($length / 24);
					$result = $length . '天' . $result;
				}
				else
				{
					$result = $length . '小时' . $result;
				}
			}
			else
			{
				$result = $length . '分' . $result;
			}
		}
		else
		{
			$result = $length . '秒';
		}
		return $result;
	}
}