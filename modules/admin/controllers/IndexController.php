<?php

namespace app\modules\admin\controllers;

use app\models\Page;
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
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied by default
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
//            throw new UserException('Страница номер "' . $id . '" не найдена');
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