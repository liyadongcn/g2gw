<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $cellphone;
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 30],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 6],

            // built-in "compare" validator
            //['password', 'compare', 'compareAttribute' => 'password2'],
            ['password','compare'],

            ['cellphone','string','max'=>11],

            ['cellphone','match','pattern'=>'/\d{11}/'],

            [['file'], 'file'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->cellphone = $this->cellphone;
            if($this->file!=null){
                 $user->face = 'uploads/' . $this->username . '.' . $this->file->extension;
             }           
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
}