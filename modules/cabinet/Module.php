<?php

namespace app\modules\cabinet;

use app\models\User;
use yii;

class Module extends \yii\base\Module
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => yii\filters\AccessControl::className(),
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