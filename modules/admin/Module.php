<?php

namespace app\modules\admin;

use app\models\User;
use yii;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN]
                    ]
                ],
            ]
        ];
    }

    public function init()
	{
		parent::init();


		$this->layout = 'main';
	}

}