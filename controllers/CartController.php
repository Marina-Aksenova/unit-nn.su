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
                    'price' => $product->price_dealer,
                ];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $orderItems,
            'pagination' => false,
        ]);

        return $this->render('index', ['order' => $order, 'dataProvider' => $dataProvider]);
    }

    public function actionOrder($id)
    {
        if (!Yii::$app->getSession()->hasFlash('success')) {
            $this->redirect('/');
        }

        if (!$order = Order::findOne($id)) {
            throw new yii\base\UserException('Не найден товар с идентификатором ' . $id);
        }

        $dataProvider = new yii\data\ActiveDataProvider([
            'query' => $order->getItems(),
            'pagination' => false,
        ]);

        return $this->render('order', ['order' => $order, 'dataProvider' => $dataProvider]);
    }

    public function actionSubmit()
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            if (!$orderData = Yii::$app->getSession()->get('order')) {
                throw new yii\base\UserException('Ваша корзина пуста');
            }
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
                    'product_title' => $product->title,
                    'price' => $product->price_dealer,
                    'amount' => $amount,
                ]);
                $orderItem->saveOrError();
            }

            $transaction->commit();
            Yii::$app->getSession()->setFlash('success', 'Ваш заказ успешно отправлен. Мы свяжемся с Вами в ближайшее время.');
            Yii::$app->getSession()->set('order', null);
            $this->redirect('/cart/order/' . $order->id);
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
