<?php

namespace app\modules\admin\controllers;

use app\models\Page;
use app\models\User;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii;

class IndexController extends Controller
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
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate($id)
    {
        if (!$page = Page::findOne($id)) {
            throw new UserException('Страница не найдена');
        }

        if ($page->load(Yii::$app->getRequest()->post()) && $page->save()) {
            return $this->redirect('/admin/');
        }

        return $this->render('update', [
            'page' => $page,
        ]);
    }
}