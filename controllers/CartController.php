<?php
namespace app\controllers;

use app\models\Order;
use app\models\OrderItem;
use app\models\Product;
use yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class CartController extends Controller
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

    public function actionIndex()
    {
        $orderItems = [];

        // Поиск товаров
        if ($order = Yii::$app->getSession()->get('order')) {
            foreach ($order as $productId => $amount) {
                if (!$product = Product::findOne($productId)) {
                    throw new yii\base\UserException('Не найден товар с идентификатором ' . $productId);
                }
                $orderItems[] = [
                    'product' => $product->title,
                    'amount' => $amount,
                ];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $orderItems,
            'pagination' => false,
        ]);

        return $this->render('index', ['order' => $order, 'dataProvider' => $dataProvider]);
    }

    public function actionSubmit()
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $orderData = Yii::$app->getSession()->get('order');
            $order = new Order();

            if ($userId = Yii::$app->getUser()->getId()) {
                $order->user_id = $userId;
            }
            $order->saveOrError();

            // Обработка заказа
            foreach ($orderData as $productId => $amount) {
                if (!$product = Product::findOne($productId)) {
                    throw new yii\base\UserException('Не найден товар с идентификатором ' . $productId);
                }
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'amount' => $amount,
                ]);
                $orderItem->saveOrError();
            }

            $transaction->commit();
            Yii::$app->getSession()->set('order', null);
            $this->redirect('/');
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    public function actionAdd()
    {
        if (!(($data = Yii::$app->getRequest()->post()) && Yii::$app->getRequest()->getIsAjax())) {
            throw new yii\base\UserException('Ошибка запроса на добавление товара в корзину');
        }

        if (!$productId = yii\helpers\ArrayHelper::getValue($data, 'product_id')) {
            throw new yii\base\UserException('Не передан идентификатор товара');
        }

        if (!$amount = yii\helpers\ArrayHelper::getValue($data, 'amount')) {
            throw new yii\base\UserException('Не передано количество товара');
        }

        if (!$product = Product::findOne($productId)) {
            throw new yii\base\UserException('Не найден товар с идентификатором ' . $productId);
        }

        $order = Yii::$app->getSession()->get('order');
        $order[$product->id] = $amount;
        Yii::$app->getSession()->set('order', $order);
    }
}
