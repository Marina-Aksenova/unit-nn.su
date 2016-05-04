<?php

namespace app\controllers;

use app\models\Page;
use yii\web\NotFoundHttpException;

class PageController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', ['page' => $this->getPage(1)]);
    }

    public function actionAbout()
    {
        return $this->render('about', ['page' => $this->getPage(2)]);
    }

    public function actionPromo()
    {
        return $this->render('promo', ['page' => $this->getPage(3)]);
    }
    
    public function actionPrice()
    {
        return $this->render('price', ['page' => $this->getPage(4)]);
    }

    public function actionContact()
    {
        return $this->render('contact', ['page' => $this->getPage(5)]);
    }

    public function actionDelivery()
    {
        return $this->render('delivery', ['page' => $this->getPage(6)]);
    }

    public function actionConsultation()
    {
        return $this->render('consultation', ['page' => $this->getPage(7)]);
    }

    public function actionSale()
    {
        return $this->render('sale', ['page' => $this->getPage(8)]);
    }

    private function getPage($id)
    {
        if (!$page = Page::findOne($id)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $page;
    }
}
