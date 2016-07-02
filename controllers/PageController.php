<?php

namespace app\controllers;

use app\components\services\Excel;
use app\models\ProductFilter;
use yii;
use app\models\Brand;
use app\models\Page;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', ['page' => $this->getPage('main')]);
    }

    public function actionAbout()
    {
        return $this->render('page', ['page' => $this->getPage('about')]);
    }

    public function actionContacts()
    {
        return $this->render('page', ['page' => $this->getPage('contacts')]);
    }

    public function actionDelivery()
    {
        return $this->render('page', ['page' => $this->getPage('delivery')]);
    }

    public function actionShop()
    {
        $order = Yii::$app->getSession()->get('order');
        $filterModel = new ProductFilter();

        $dataProvider = $filterModel->search(Yii::$app->request->get());
        // ['ProductFilter' => ['brand_id' => 16]]

        return $this->render('shop', [
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
            'brands' => Brand::find()->all(),
            'order' => $order,
        ]);
    }

    public function actionSale()
    {
        return $this->render('page', ['page' => $this->getPage('sale')]);
    }

    private function getPage($name)
    {
        if (!$page = Page::findOne(['name' => $name])) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $page;
    }
}
