<?php
namespace common\models\base;

use common\models\Comment;
use common\models\Tagmap;
use common\models\Tag;
use common\models\Album;
use common\models\CategoryMap;
use common\models\Category;
use common\models\Company;
use common\models\Brand;
use common\models\Country;
use common\models\Links;
use backend\models\PostsSearch;
use yii\helpers\StringHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii;
use common\models\User;
use common\models\Relationships;
use common\models\RelationshipsMap;
use backend\models\CommentSearch;
use yii\helpers\ArrayHelper;
use common\models\helper\TimeHelper;
use common\models\Goods;
use common\models\Posts;


class ActiveRecord extends \yii\db\ActiveRecord
{
		
	public $tag_string; //String of the tags together
	public $comment;    //Obj of the comment model
	public $categories; //Array of the model categories. including category_id category_name. 
		
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
				[
				'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'created_date',
				'updatedAtAttribute' => 'updated_date',
				'value' => new Expression('NOW()'),
				],
				[
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'userid',
				'updatedByAttribute' => 'userid',
				],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['tag_string'], 'string'],
				[['tag_string'], 'default','value'=>''],
				[['categories'],'safe'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function delete()
	{
		try
		{
			$this->deleteComments();
			$this->deleteAlbum();
			$this->deleteAllTagMaps();
			//Delete the category_map records
			$this->deleteAllCategoryMap();
			//Delete the relationships_map records
			$this->deleteAllRelationshipsMap();

		}
		catch (\Exception $e)
		{
			throw $e;
		}
		
		parent::delete();
	}

	/**
	 * @inheritdoc
	 */
	public function save($runValidation = true, $attributeNames = null)
	{
		if(parent::save($runValidation,$attributeNames))
		{
			return  $this->setTags();
		}
		return false;
	}
	
	/**
	 * This function is to get the model name string.
	 * 返回子类的类名，类名为一个字符串
	 * 
	 * @return string the name of the model class.
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function modelType()
	{
		return strtolower(StringHelper::basename(get_called_class()));
	}
	
	/**
	 * This function is to get the all top comments of this brand.
	 * That is meaning the comment parent id equal to 0.
	 * 得到该数据模型的所有评论记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getComments()
	{
// 		return $this->hasMany(Comment::className(), ['model_id'=>'id'])
// 		->where(['model_type'=>$this->modelType(),'parent_id'=>0]);
		
		$searchModel=new CommentSearch();
		$dataProvider = $searchModel->search(['CommentSearch'=>['model_id'=>$this->id,'parent_id'=>0,'model_type'=>$this->modelType()]]);
		$dataProvider->pagination->pageSize=10;
		 
		return $dataProvider;
	}
	
	/**
	 * This function is to delete all the comments records related to the model.
	 * 删除该数据模型的所有相关评论
	 * 
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function deleteComments()
	{
		return Comment::deleteAll(['model_id'=>$this->id,'model_type'=>$this->modelType()]);
	}
	
	
	/**
	 * This function is to get the all tags map records of this model.
	 * 得到数据模型的所有标签映射记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getTagMaps()
	{
		return $this->hasMany(Tagmap::className(), ['model_id'=>'id'])
		->where(['model_type'=>$this->modelType()]);
		//->all();
	}
	
	/**
	 * This function is to get all the relationships map records of this model.
	 * 得到数据模型的所有用户关系映射记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getRelationshipsMap()
	{
		return $this->hasMany(RelationshipsMap::className(), ['model_id'=>'id'])
		->where(['model_type'=>$this->modelType()]);
		//->all();
	}
	
	/**
	 * This function is to increase tagmap records of this model.
	 * if there is same name tag, the tag count will be increased one.
	 * if there is same tapmap record,this will do nothing.
	 * 将以空格为分隔符的一个字符串分解为单个的标签名，若该名称在标签表已经存在则增加该标签的引用数量
	 * 然后增加一条tagmap记录，若该模型的该tagmap记录已经存在，则不增加，若没有则新增
	 * 主要通过tagmap数据模型的字段联合唯一性‘unique’进行数据验证
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function setTags()
	{
		//self::deleteAllTagMaps();
		//echo $this->tag_string;
		if(empty($this->tag_string)) return true;
		$tagWords=StringHelper::explode($this->tag_string,' ',true,true);
		//var_dump($tagWords);
		//die();
		if($tagWords)
		{
			foreach ($tagWords as $tagWord)
			{
				//Find the tag by the name
				$tag= new Tag();
				$tag->name=$tagWord;
				$tag->model_type=$this->modelType();
				if($tag->validate())
				{
					$tag->save();
				}
				else if($tag->hasErrors('name'))
				{
					$tag=Tag::findOne(['name'=>$tagWord,'model_type'=>$this->modelType()]);
				}
				 
				$tagMap = new Tagmap();
				$tagMap->tagid=$tag->id;
				$tagMap->model_id=$this->id;
				$tagMap->model_type=$this->modelType();
				//var_dump($tagMap);
				if($tagMap->validate())
				{
					//$tag->updateCounters(['count'=>1]);
					$tagMap->save();
				}
			}
	
			return true;
		}
		 
		return false;
	}
	
	/**
	 * This function is to delete  all tagmap records of this model.
	 * In the mean while reduce the tag count.
	 * 删除数据模型所有的标签映射记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function deleteAllCategoryMap()
	{
		//DeleteAll 不触发afterDelete和befroreDelete事件,所以改为逐条记录删除触发删除事件
		$categoryMaps=$this->getCategoryMap()->all();
		if($categoryMaps)
		{
			foreach ($categoryMaps as $categoryMap)
			{
				$categoryMap->delete();
			}
		}
	}
	
	/**
	 * This function is to delete  all relationmaps records of this model.
	 * In the mean while reduce the relationship count.
	 * 删除数据模型所有的标签映射记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	private function deleteAllRelationshipsMap()
	{
		//DeleteAll 不触发afterDelete和befroreDelete事件,所以改为逐条记录删除触发删除事件
		$maps=$this->getRelationshipsMap()->all();
		if($maps)
		{
			foreach ($maps as $map)
			{
				$map->delete();
			}
		}
	}

	/**
	 * This function is to delete  all tagmap records of this model.
	 * In the mean while reduce the tag count.
	 * 删除数据模型所有的标签映射记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function deleteAllTagMaps()
	{
		//DeleteAll 不触发afterDelete和befroreDelete事件,所以改为逐条记录删除触发删除事件
		$tagMaps=$this->getTagMaps()->all();
		if($tagMaps)
		{
			foreach ($tagMaps as $tagMap)
			{
				$tagMap->delete();
			}
		}
		
		//return Tagmap::deleteAll(['model_type'=>$this->modelType(),'model_id'=>$this->id]);
	}
	
	/**
	 * This function is to create a string according the tagmaps and the tag name.
	 * All the tag names will be put together seprated by the space.
	 * 将该模型数据的标签合并成一个字串返回
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getTagString()
	{
		$tagMaps=$this->getTagMaps();
		//var_dump($tagMaps);
		if($tagMaps);
		{
			foreach ($tagMaps as $tagMap)
			{
				$this->tag_string=$this->tag_string.$tagMap->getTag()->One()->name.' ';
			}
		}
		$this->tag_string=trim($this->tag_string,', ');
	
	}
	
	/**
	 * This function is to get all the album records related to the model.
	 * 得到数据模型相关的相册对象列表
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getAlbum()
	{
		return Album::findAll(['model_id'=>$this->id,'model_type'=>$this->modelType()]);
	}
	
	/**
	 * This function is to get  the default album image records related to the model.
	 * 得到数据模型相关的相册对象列表
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getAlbumDefaultImg()
	{
		return Album::findOne(['model_id'=>$this->id,'model_type'=>$this->modelType(),'is_default'=>1]);
	}
	
	/**
	 * This function is to delete all the album records related to the model.
	 * 删除相册表中所有与该数据模型相关的记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function deleteAlbum()
	{
		$pics=$this->getAlbum();
		if($pics)
		{
			foreach ($pics as $pic)
			{
				$pic->delete();
			}
		}
		//return Album::deleteAll(['model_id'=>$this->id,'model_type'=>$this->modelType()]);
	}
	
	/**
	 * This function is to save one upload file to the upload files folder and increase one record to the album table.
	 * 将模型相关的长传图片存储到相应的目录中，同时将名称信息存储到相册表中
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function saveToAlbum($file,$is_defaut=0)
	{
		$fileName='uploads/'.$this->modelType() .'/'. uniqid() . '.' . $file->extension;
		$file->saveAs($fileName);
		$album = new Album();
		$album->model_id=$this->id;
		$album->model_type=$this->modelType();
		$album->filename='/'.$fileName;
		$album->is_default=$is_defaut;
		$album->save();
	}
	
	/**
	 * This function is to add one comment to the related to the model.
	 * 用户对相应的数据模型发表一条评论
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function submitComment()
	{
		if($this->comment)
		{
			/* $this->comment->model_type=self::modelType();
			$this->comment->model_id=$this->id;
			if(yii::$app->user->isGuest)
			{
				$this->comment->userid=0;
				$this->comment->author='匿名用户';
			}
			else
			{
				$this->comment->userid=yii::$app->user->id;
				$this->comment->author=User::findIdentity(yii::$app->user->id)->username;				
			}
			$this->comment->save();
			$this->updateCounters(['comment_count'=>1]);
			$this->comment->content='';
			return true; */
			if($this->comment->addComment($this))
			{
				$this->comment->content='';
				//unset($this->comment);
				return true;
			}
			
		}
		return false;
	}

	/**
	 * This function is to get the model categories through the category map table .
	 * 通过分类映射表得到数据模型的分类信息
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getCategories()
	{
		return $this->hasMany(Category::className(), ['id' => 'category_id','model_type'=>'model_type'])
		->viaTable('category_map', ['model_id' => 'id'])->where(['model_type'=>$this->modelType()]);
	}
	
	/**
	 * This function is to set the model categories .
	 * 给数据模型增加分类
	 *
	 * 
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function setCategories()
	{
		//Compare the difference of the categories to get the deleted categories;
		$oldCategories = ArrayHelper::map($this->getCategories()->all(),'name','id');
		if(empty($this->categories))
		{
			$deletedCategories = array_diff($oldCategories,[]);
		}
		else
		{
			$deletedCategories = array_diff($oldCategories,$this->categories);
		}
		if(!empty($deletedCategories)){
			//CategoryMap::deleteAll(['category_id'=>$deletedCategories,'model_id'=>$this->id,'model_type'=>$this->modelType()]);
			$models=CategoryMap::findAll(['category_id'=>$deletedCategories,'model_id'=>$this->id,'model_type'=>$this->modelType()]);
			foreach ($models as $model)
			{
				$model->delete();
			}
		}
// 		var_dump($oldCategories);
// 		var_dump($this->categories);
		if($this->categories)
		{
			foreach ($this->categories as $category)
			{
				$categoryMap =new CategoryMap();
				$categoryMap->category_id=$category;
				$categoryMap->model_id=$this->id;
				$categoryMap->model_type=$this->modelType();
				if($categoryMap->validate())
				{
					$categoryMap->save();
					
				}
			}
		}
	}
	
	
	/**
	 * This function is to get the category map to the related to the model.
	 * 得到数据模型的分类映射
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getCategoryMap()
	{
		return $this->hasMany(CategoryMap::className(),['model_id'=>'id'])
		->where(['model_type'=> $this->modelType()]);
		//return CategoryMap::findAll(['model_id'=>$this->id,'model_type'=>$this->modelType()]);
	
	}

	/**
	 * This function is to add one star to the related to the model.
	 * 用户收藏相应的数据模型
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	
	public function addStar()
	{
	
		if(yii::$app->user->isGuest)
		{
			// 匿名用户不能收藏
		}
		else
		{
			$relationshipMap= new RelationshipsMap();
			$relationshipMap->model_type=$this->modelType();
			$relationshipMap->model_id=$this->id;
			$relationshipMap->relationship_id=Relationships::RELATIONSHIP_STAR;
			$relationshipMap->userid=yii::$app->user->id;
			if($relationshipMap->validate())
			{
				$relationshipMap->save();
				$this->updateCounters(['star_count'=>1]);
			}
		}
	}
	
	/**
	 * This function is to remove one star to the related to the model.
	 * 用户收藏相应的数据模型
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	
	public function removeStar()
	{
	
		if(yii::$app->user->isGuest)
		{
			// 匿名用户不能收藏
		}
		else
		{
			$relationshipMap=RelationshipsMap::findOne(['model_id'=>$this->id,'model_type'=>$this->modelType(),'relationship_id'=>Relationships::RELATIONSHIP_STAR,'userid'=>yii::$app->user->id]);
			if($relationshipMap)
			{
				$relationshipMap->delete();
				$this->updateCounters(['star_count'=>-1]);
			}
			
		}
	}
	
	/**
	 * This function is to check if the model is stared by the current user.
	 * 
	 * @return bool
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	
	public function isStared()
	{
	
		if(yii::$app->user->isGuest)
		{
			// 匿名用户不能收藏
			return false;
		}
		else
		{
			$relationshipMap=RelationshipsMap::findOne(['model_id'=>$this->id,'model_type'=>$this->modelType(),'relationship_id'=>Relationships::RELATIONSHIP_STAR,'userid'=>yii::$app->user->id]);
			if($relationshipMap)
			{
				return true;
			}
			return false;				
		}
	}
	
	/**
	 * This function is to get the user object of this model.
	 *
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(),['id'=>'userid']);
		//->where();
		//self::find()->where(['parent_id'=>$this->id])->count();
	}
	
	/**
	 * This function is to check if the model belongs to the category.
	 * 
	 * @param   integer category id.
	 * @return  bool 
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function isCategory($categoryID)
	{
		$categoryMaps=$this->categoryMap;
		if($categoryMaps)
		{
			foreach ($categoryMaps as $categoryMap)
			{
				if($categoryMap->category_id==$category_id)
				{
					return true;
				}
			}
		}
		
		return false;		
	
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
	public static function getDropDownListData($model,$modelType=null)
	{
		switch ($model)
		{
			case MODEL_TYPE_BRAND:
				return ArrayHelper::map(Brand::find()->all(),'id','en_name');
			case MODEL_TYPE_CATEGORY:
				return ArrayHelper::map(Category::find()->where(['model_type'=>$modelType])->all(),'id','name');
			case MODEL_TYPE_COMMENT_STATUS:
				return [
 					COMMENT_STATUS_CLOSE=>'禁止评论',
 					COMMENT_STATUS_OPEN=>'允许评论'
				];
			case MODEL_TYPE_POSTS_STATUS:
				return [
					POST_STATUS_PUBLISH=>'直接发布',
					POST_STATUS_DRAFT=>'保存为草稿',
				];
			case MODEL_TYPE_COUNTRY:
				return ArrayHelper::map(Country::find()->all(),'code','cn_name');
			case MODEL_TYPE_COMPANY:
				return ArrayHelper::map(Company::find()->all(),'id','name');
			//put more fields need to be mapped.
				
			default:
				return [];
		}
	}
	
	/**
	 * This function is to get the related promotions posts of this model.
	 *
	 * @return ActiveDataProvider|null the Posts ActiveDataProvider
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getRelatedPosts()
	{
		/*     	$query=Posts::find();
		 $query->Where(['=','brand_id',$this->id])
		 ->orderBy(['view_count' => SORT_DESC, 'updated_date' => SORT_DESC])
		 ->limit($n);
		 return $query;
		 */
		$searchModel=new PostsSearch();
		switch ($this->modelType())
		{
			case MODEL_TYPE_BRAND:
				$brandid=$this->id;
				break;
			case MODEL_TYPE_GOODS:
				$brandid=$this->brand_id;
				break;
			case MODEL_TYPE_POSTS:
				$brandid=$this->brand_id;
				break;
			default:
				$brandid=-1;
		}
		
		$dataProvider = $searchModel->search(['PostsSearch'=>['brand_id'=>$brandid]]);
		$dataProvider->pagination->pageSize=5;
	
		return $dataProvider;
	}
	
	/**
	 * This function is to get all the links records related to the model.
	 * 得到数据模型相关的链接 例如：一个商品会对应网络上几个链接 有的指向官网 有的指向淘宝 有的指向京东等等
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getLinks()
	{
		return $this->hasMany(Links::className(),['model_id'=>'id'])
		->where(['model_type'=> $this->modelType()]);
	}
	
	/**
	 * This function is to get the statistic records count number to the model.
	 * 得到数据模型相关某一时间段内的新增数量
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function getNewAdded($days=1,$to=NULL,$from=NULL)
	{
		if($days)
		{
			$from = date('Y-m-d',time());
			$to = date('Y-m-d',time()-3600*24*$days);
		}
		else{
			if ($from ===NULL) $from = date('Y-m-d',time());
		}
		
		switch ($this->modelType())
		{
			case MODEL_TYPE_BRAND:
				return Brand::find()->where(['<','created_date',$from])->andWhere(['>','created_date',$to])->count();
			case MODEL_TYPE_GOODS:
				return Goods::find()->where(['<','created_date',$from])->andWhere(['>','created_date',$to])->count();
			case MODEL_TYPE_POSTS:
				return Posts::find()->where(['<','created_date',$from])->andWhere(['>','created_date',$to])->count();
			default:
				return 0;
		}
	}
}