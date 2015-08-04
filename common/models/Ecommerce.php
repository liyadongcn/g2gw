<?php

namespace common\models;

use Yii;
use common\models\Brand;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ecommerce".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property string $website
 * @property string $name
 * @property integer $is_domestic
 * @property integer $accept_order
 */
class Ecommerce extends \yii\db\ActiveRecord
{
	const NUTCH_PATTERN='+^http://([a-z0-9]*\.)*';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ecommerce';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id', 'is_domestic', 'accept_order'], 'integer'],
            [['website'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 30],
            [['name','website'], 'required'],
        	[['is_domestic', 'accept_order'], 'default','value'=>true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'website' => 'Website',
            'name' => 'Name',
            'is_domestic' => 'Is Domestic',
            'accept_order' => 'Accept Order',
        ];
    }
    
    /**
     * This function is   to get the dropdownlist data for the field in this model.
     *
     * @param  string      $field   the field name.
     * @return array|null           the maping data for the dropdwonlist.
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getDropDownListData($field)
    {
    	//put more fields need to be mapped.
    	switch ($field)
    	{
    		case 'is_domestic':
    			return [
    				true=>'国内网',
    				false=>'国外网'
    			];
    		case 'accept_order':
    			return [
    				true=>'可在线购买',
    				false=>'不可在线购买'
    			];
    		case 'brand_id':	
    			return ArrayHelper::map(Brand::find()->all(),'id','en_name');
    			
    		default:
    			return [];
    	}
    }
    
    public function getBrand()
    {
    	return $this->hasOne(Brand::className(), ['id'=>'brand_id']);
    }
    
    public static function exportURLS($filename)
    {    	
    	$ecommerces=Ecommerce::find()->all();
    	if($ecommerces)
    	{
    		$file=fopen($filename, 'w');
    		if(!$file) return false;
    		foreach ($ecommerces as $ecommerce)
    		{
    			$url=parse_url($ecommerce->website);
    			if($url) //fwrite($file, self::NUTCH_PATTERN.self::getDomain($url['host']).$url['path']."\r\n");
    				fwrite($file, self::NUTCH_PATTERN.str_replace('www.','',$url['host']).$url['path']."\r\n");
    		}
    		fclose($file);
    	}
    	return true;
    }
    
    public static function  getDomain($url) {
    	$host = strtolower ( $url );
    	if (strpos ( $host, '/' ) !== false) {
    		$parse = @parse_url ( $host );
    		$host = $parse ['host'];
    	}
    	$topleveldomaindb = array ('jd.com','tmall.com','com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me' );
    	$str = '';
    	foreach ( $topleveldomaindb as $v ) {
    		$str .= ($str ? '|' : '') . $v;
    	}
    
    	$matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
    	if (preg_match ( "/" . $matchstr . "/ies", $host, $matchs )) {
    		$domain = $matchs ['0'];
    	} else {
    		$domain = $host;
    	}
    	return $domain;
    }
    
    public static function get_domain($url)
    {
    	$pattern = "/[/w-]+/.(com|net|org|gov|biz|com.tw|com.hk|com.ru|net.tw|net.hk|net.ru|info|cn|com.cn|net.cn|org.cn|gov.cn|mobi|name|sh|ac|la|travel|tm|us|cc|tv|jobs|asia|hn|lc|hk|bz|com.hk|ws|tel|io|tw|ac.cn|bj.cn|sh.cn|tj.cn|cq.cn|he.cn|sx.cn|nm.cn|ln.cn|jl.cn|hl.cn|js.cn|zj.cn|ah.cn|fj.cn|jx.cn|sd.cn|ha.cn|hb.cn|hn.cn|gd.cn|gx.cn|hi.cn|sc.cn|gz.cn|yn.cn|xz.cn|sn.cn|gs.cn|qh.cn|nx.cn|xj.cn|tw.cn|hk.cn|mo.cn|org.hk|is|edu|mil|au|jp|int|kr|de|vc|ag|in|me|edu.cn|co.kr|gd|vg|co.uk|be|sg|it|ro|com.mo)(/.(cn|hk))*/";
    	preg_match($pattern, $url, $matches);
    	if(count($matches) > 0)
    	{
    		return $matches[0];
    	}else{
    		$rs = parse_url($url);
    		$main_url = $rs["host"];
    		if(!strcmp(long2ip(sprintf("%u",ip2long($main_url))),$main_url))
    		{
    			return $main_url;
    		}else{
    			$arr = explode(".",$main_url);
    			$count=count($arr);
    			$endArr = array("com","net","org");//com.cn net.cn 等情况
    			if (in_array($arr[$count-2],$endArr))
    			{
    				$domain = $arr[$count-3].".".$arr[$count-2].".".$arr[$count-1];
    			}else{
    				$domain = $arr[$count-2].".".$arr[$count-1];
    			}
    			return $domain;
    		}
    	}
    }
    
}
