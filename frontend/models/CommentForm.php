<?php
namespace frontend\models;

use common\models\Comment;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class CommentForm extends Model
{
 
    public $content;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            ['content', 'required'],
            ['content', 'string', 'min' => 10],

      ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function saveComment()
    {
        if ($this->validate()) {
            $comment = new Comment();
            $comment->model_type='';
            $comment->model_id=null;
            $comment->userid=yii::$app->user->id;            
            $comment->content=$this->content;
            $comment->created_date=date("Y-m-d H:i:s");
            $comment->updated_date=date("Y-m-d H:i:s");
            if ($comment->save()) {
                return $comment;
            }
        }

        return null;
    }
}
