<?php

namespace app\modules\cabinet\controllers;

use app\models\Order;
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

    public function actionHistory()
    {
        $orders = Order::find()->where(['user_id' => Yii::$app->getUser()->getId()])->all();
        return $this->render('history', ['orders' => $orders]);
    }

    public function actionPersonal()
    {
        /** @var User $user */
        $user = Yii::$app->getUser()->getIdentity();

        if ($user->load(Yii::$app->getRequest()->post()) && $user->save()) {
            Yii::$app->getSession()->setFlash('user_saved', 'Данные успешно сохранены');
            $this->redirect('/cabinet/personal');
        }
        return $this->render('personal', ['user' => Yii::$app->getUser()->getIdentity()]);
    }
}