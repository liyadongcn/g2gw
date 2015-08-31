<?php
namespace common\components;

use yii;
use yii\authclient\OAuth2;
use yii\base\Exception;
use yii\helpers\Json;
use common\models\User;
use common\models\Auth;
use yii\authclient\clients\GitHub;

/**
 *
 * ~~~
 * 'components' => [
 *     'authClientCollection' => [
 *         'class' => 'yii\authclient\Collection',
 *         'clients' => [
 *             'github' => [
 *                 'class' => 'common\components\GithubAuth',
 *                 'clientId' => 'client_id',
 *                 'clientSecret' => 'client_secret',
 *             ],
 *         ],
 *     ]
 *     ...
 * ]
 * ~~~
 *
 * @see 
 *
 * @author wintermelon
 * @since 2.0
 */
class GithubAuth extends GitHub
{
	public $defaultRole='author';
	
	public function login()
	{
		$attributes = $this->getUserAttributes();
			
		/* @var $auth Auth */
		$auth = Auth::find()->where([
				'source' => $this->getId(),
				'source_id' => $attributes['id'],
		])->one();
		
		if (Yii::$app->user->isGuest) {
			if ($auth) { // login
				$user = $auth->user;
				Yii::$app->user->login($user);
			} else { // signup
				if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
					Yii::$app->getSession()->setFlash('error', [
							Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->getTitle()]),
					]);
				} else {
					$password = Yii::$app->security->generateRandomString(6);
					$user = new User([
							'username' => $attributes['login'],
							'email' => $attributes['email'],
							'password' => $password,
					]);
					$user->face=$attributes['avatar_url'];
					$user->generateAuthKey();
					$user->generatePasswordResetToken();
					$transaction = $user->getDb()->beginTransaction();
					if ($user->save()) {
						$auth = new Auth([
								'user_id' => $user->id,
								'source' => $this->getId(),
								'source_id' => (string)$attributes['id'],
						]);
						if ($auth->save()) {
							$transaction->commit();
							// Assign default role to user.
							$authAPP = Yii::$app->authManager;
							$role=$authAPP->getRole($this->defaultRole);
							if($role) $authAPP->assign($role, $user->id);
							// Login
							Yii::$app->user->login($user);
						} else {
							print_r($auth->getErrors());
						}
					} else {
						print_r($user->getErrors());
					}
				}
			}
		} else { // user already logged in
			if (!$auth) { // add auth provider
				$auth = new Auth([
						'user_id' => Yii::$app->user->id,
						'source' => $this->getId(),
						'source_id' => $attributes['openid'],
				]);
				$auth->save();
			}
		}
	}

}