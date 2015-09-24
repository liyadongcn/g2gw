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
	const AD_SIZE_960_90  = '960_90';
	const AD_SIZE_468_90  = '468_90';
	const AD_SIZE_250_250 = '250_250';
	const AD_SIZE_300_250 = '300_250';
	const AD_SIZE_336_280 = '336_280';
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
			'jd' => [
					'pc' => [
							'960_90' => <<<JS
							<script type="text/javascript">var jd_union_unid="335137776",jd_ad_ids="505:6",jd_union_pid="COTRt6L/KRDwl+efARoAINS0lKIBKgA=";var jd_width=960;var jd_height=90;var jd_union_euid="";var p="ABcGVB1SFAUTNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyT1EqZVlsB1lnExgSQWtaRTZuGRFDVAtZK1kXCxAEVRhZEjIQBVEbWRMEFABlKwRRX083HnVaJV1WWggrWxAHEQ9VGF0dAxQDXCta";</script><script type="text/javascript" charset="utf-8" src="http://u.x.jd.com/static/js/auto.js"></script>
JS
							,
							'250_250' => <<<JS
							<script type="text/javascript">var jd_union_unid="335137776",jd_ad_ids="520:6",jd_union_pid="CP6LwKL/KRDwl+efARoAIJzElKIBKgA=";var jd_width=250;var jd_height=250;var jd_union_euid="";var p="ABcGVB1fFAAWNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyVUBTQwJjY3FkD0MmFXZsYBd5EBIAcgtZK1kXCxAEVRhZEjIQBVEbWRMEFABlKwRRX083HnVaJV1WWggrWxAHEQ9VGFMWChEOVCta";</script><script type="text/javascript" charset="utf-8" src="http://u.x.jd.com/static/js/auto.js"></script>
JS
					],
					'mobile' => [
							'468_90' => <<<JS
							<script type="text/javascript">var jd_union_unid="335137776",jd_ad_ids="508:6",jd_union_pid="CPugu6L/KRDwl+efARoAIKy8lKIBKgA=";var jd_width=468;var jd_height=90;var jd_union_euid="";var p="ABcGVB1eFAEUNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyRUYOeBtDfVRlKWkQYHkIWTJ8KW9lVAtZK1kXCxAEVRhZEjIQBVEbWRMEFABlKwRRX083HnVaJV1WWggrWxAHEQ9VGFIRAxMCUSta";</script><script type="text/javascript" charset="utf-8" src="http://u.x.jd.com/static/js/auto.js"></script>
JS
							,
							'300_250' => <<<JS
							<script type="text/javascript">var jd_union_unid="335137776",jd_ad_ids="513:6",jd_union_pid="CJaAkKP/KRDwl+efARoAIK68lKIBKgA=";var jd_width=300;var jd_height=250;var jd_union_euid="";var p="ABcGVB1TFAYTNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyFHACUwVSRG1nKWEJQ3dEcAofLkpFRAtZK1kXCxAEVRhZEjIQBVEbWRMEFABlKwRRX083HnVaJV1WWggrWxAHEQ9VHlgXCxcOXSta";</script><script type="text/javascript" charset="utf-8" src="http://u.x.jd.com/static/js/auto.js"></script>
JS
							,
							'336_280' => <<<JS
							<script type="text/javascript">var jd_union_unid="335137776",jd_ad_ids="512:6",jd_union_pid="CITiqKP/KRDwl+efARoAII2JmKIBKgA=";var jd_width=336;var jd_height=280;var jd_union_euid="";var p="ABcGVRlZFAMXNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyTQICRCdQA1JlDlMAHHpQWSJSPmB%2FRAtZK1kXCxAEVRhZEjIQBVEbWRMEFABlKwRRX083HnVaJV1WWggrWxAHEQ9VHlwQBxEFVyta";</script><script type="text/javascript" charset="utf-8" src="http://u.x.jd.com/static/js/auto.js"></script>
JS
							,
					],					
			],
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