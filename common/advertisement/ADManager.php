<?php
namespace common\advertisement;

use yii;

class ADManager
{
	// 广告来源
	const AD_TAOBAO = 'taobao';
	const AD_JD = 'jd';
	const AD_BAIDU = 'baidu';
	const AD_360 = '360';
	const AD_SOGOU = 'sogou';
	// 广告尺寸
	const AD_SIZE_320_90  = '320_90';
	const AD_SIZE_1000_90 = '1000_90';
	const AD_SIZE_250_250 = '250_250';
	// 广告展现设备
	const AD_MOBILE = 'mobile';
	const AD_PC     = 'pc';
	
	static private  $_ADJS = [
			'taobao' => [
					'pc' => [
						'1000_90' => <<<JS
							<script type="text/javascript">
							        document.write('<a style="display:none!important" id="tanx-a-mm_43616038_10876662_36914234"></a>');
							        tanx_s = document.createElement("script");
							        tanx_s.type = "text/javascript";
							        tanx_s.charset = "gbk";
							        tanx_s.id = "tanx-s-mm_43616038_10876662_36914234";
							        tanx_s.async = true;
							        tanx_s.src = "http://p.tanx.com/ex?i=mm_43616038_10876662_36914234";
							        tanx_h = document.getElementsByTagName("head")[0];
							        if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
							</script>
JS
,
						 '250_250' => <<<JS
							<script type="text/javascript">
							        document.write('<a style="display:none!important" id="tanx-a-mm_43616038_10876662_36914843"></a>');
							        tanx_s = document.createElement("script");
							        tanx_s.type = "text/javascript";
							        tanx_s.charset = "gbk";
							        tanx_s.id = "tanx-s-mm_43616038_10876662_36914843";
							        tanx_s.async = true;
							        tanx_s.src = "http://p.tanx.com/ex?i=mm_43616038_10876662_36914843";
							        tanx_h = document.getElementsByTagName("head")[0];
							        if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
							</script>
JS
					],
					'mobile' => [
						'320_90' => <<<JS
							<script type="text/javascript">
							        document.write('<a style="display:none!important" id="tanx-a-mm_43616038_10876662_36860505"></a>');
							        tanx_s = document.createElement("script");
							        tanx_s.type = "text/javascript";
							        tanx_s.charset = "gbk";
							        tanx_s.id = "tanx-s-mm_43616038_10876662_36860505";
							        tanx_s.async = true;
							        tanx_s.src = "http://p.tanx.com/ex?i=mm_43616038_10876662_36860505";
							        tanx_h = document.getElementsByTagName("head")[0];
							        if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
							</script>
JS
					],
			],
			'jd' => [],
			'baidu' => [],
			'360' => [],
			'sogou' => [
					'pc' => [
							'250_250' => <<<JS
							<script type="text/javascript">
							var sogou_ad_id=470489;
							var sogou_ad_height=250;
							var sogou_ad_width=250;
							</script>
							<script type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>
JS
					],
					'mobile' => [

					],
			],			
	];
	
	public static function getAd($source,$device,$size)
	{
// 		var_dump( self::$_ADJS[$source][$device][$size]);
// 		die();
		if(isset(self::$_ADJS[$source][$device][$size]))
		{
			return self::$_ADJS[$source][$device][$size];
		}
		return null;
	}
	
	
}