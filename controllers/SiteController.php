<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Order;
use app\models\OrderItem;
use app\models\Product;
use app\models\User;
use yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rbac\Role;
use yii\web\Controller;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrder()
    {
        $order = new Order([
//            'user_id' => Yii::$app->getUser()->getId(),
        ]);
        $order->saveOrError();

        $orderItem = new OrderItem([
            'product_id' => Product::find()->one()->id,
            'order_id' => $order->id,
            'amount' => 17,
        ]);
        $orderItem->saveOrError();

        $orderItem = new OrderItem([
            'product_id' => Product::findOne(2)->id,
            'order_id' => $order->id,
            'amount' => 16,
        ]);
        $orderItem->saveOrError();

        Yii::$app->getSession()->set('order', $order);

        /** @var Order $order */
        if (!$order = Yii::$app->getSession()->get('order')) {
            throw new yii\base\UserException('Корзина пуста');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $order->getItems()->with(['order']),
        ]);
        
        return $this->render('order', ['order' => $order, 'dataProvider' => $dataProvider]);
    }

    public function actionLogin()
    {
        $user = Yii::$app->user;
        if (!$user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /** @var Role $userRole */
            $userRoles = Yii::$app->getAuthManager()->getRolesByUser($user->id);
            if (isset($userRoles[User::ROLE_ADMIN])) {
                return $this->redirect('/admin');
            }
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
