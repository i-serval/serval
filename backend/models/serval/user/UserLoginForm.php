<?php

namespace backend\models\serval\user;

use Yii;
use yii\base\Model;
use common\models\serval\user\AServalUser;


class UserLoginForm extends Model
{
    public $email;
    public $password;
    public $remember_me = false;

    private $_user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['remember_me', 'boolean'],
            ['password', 'validatePassword'],
            ['email', 'email'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {

            return Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600 * 24 * 30 : 0);

        } else {

            return false;

        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {

            $this->_user = AServalUser::findByEmail($this->email);

        }

        return $this->_user;
    }
}
