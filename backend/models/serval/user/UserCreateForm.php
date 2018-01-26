<?php

namespace backend\models\serval\user;

use yii\base\Model;
use backend\models\serval\user\UserRecord;


class UserCreateForm extends Model
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $re_password;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\serval\user\UserRecord', 'message' => 'This username has already been taken.', 'on' => 'create'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\serval\user\UserRecord', 'message' => 'This email address has already been taken.', 'on' => 'create'],

            [
                ['password'], 'required', 'on' => 'create'
            ],
            [['password'], 'string', 'min' => 6],

            [
                ['re_password'], 'required', 'on' => 'create'
            ],
            ['re_password', 'string', 'min' => 6],
            ['re_password', 'validateRePassword'],
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new UserRecord();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;

    }

    public function update($user)
    {

        if (!$this->validate()) {

            return null;
        }

        if ($user->name != $this->name) {

            if (UserRecord::find()->where('id != :id AND name = :name', [':id' => $user->id, ':name' => $this->name])->one() !== null) {
                $this->addError('name', 'This name has already been taken.');
                return null;
            }
        }

        if ($user->email != $this->email) {

            if (UserRecord::find()->where('id != :id AND email = :email', [':id' => $user->id, ':status' => $this->email])->one() !== null) {
                $this->addError('name', 'This email address has already been taken.');
                return null;
            }

        }

        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->password !== '') {
            $user->setPassword($this->password);
            $user->generateAuthKey();
        }

        return $user->save() ? $user : null;

    }

    public function validateRePassword($attribute, $params)
    {

        if ($this->password != '') {

            if ($this->password != $this->re_password) {

                $this->addError('re_password', 'Passwords do not match');

            }

        }

    }

    public function attributeLabels()
    {
        return [
            're_password' => 'Retype password',
        ];
    }

    public function isNewRecord()
    {
        if ($this->id === null) {
            return true;
        }

        return false;
    }

}
