<?php
namespace common\models\base;

use common\models\Comment;
use common\models\Tagmap;
use common\models\Tag;
use common\models\Album;
use common\models\CategoryMap;
use common\models\Category;
use yii\helpers\StringHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii;
use common\models\User;
use common\models\Relationships;
use common\models\RelationshipsMap;
use backend\models\CommentSearch;

class ActiveRecord extends \yii\db\ActiveRecord
{
		
	public $tag_string;
	public $comment;
		
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
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['tag_string'], 'string'],
				[['tag_string'], 'default','value'=>'']
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
	public function deleteAllTagMaps()
	{
		$tagMaps=$this->getTagMaps();
		if($tagMaps)
		{
			foreach ($tagMaps as $tagMap)
			{
				$tagMap->delete();
			}
		}
		//DeleteAll 不触发afterDelete和befroreDelete事件
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
	 * This function is to delete all the album records related to the model.
	 * 删除相册表中所有与该数据模型相关的记录
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function deleteAlbum()
	{
		return Album::deleteAll(['model_id'=>$this->id,'model_type'=>$this->modelType()]);
	}
	
	/**
	 * This function is to save one upload file to the upload files folder and increase one record to the album table.
	 * 将模型相关的长传图片存储到相应的目录中，同时将名称信息存储到相册表中
	 *
	 * @author Wintermelon
	 * @since  1.0
	 */
	public function saveToAlbum($file)
	{
		$file->saveAs('uploads\\'.$this->modelType() .'\\'. $file->baseName . '.' . $file->extension);
		$album = new Album();
		$album->model_id=$this->id;
		$album->model_type=$this->modelType();
		$album->filename='uploads\\'.$this->modelType() .'\\'. $file->baseName . '.' . $file->extension;
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
		return $this->hasMany(Category::className(), ['id' => 'category_id'])
		->viaTable('category_map', ['model_id' => 'id']);
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
}