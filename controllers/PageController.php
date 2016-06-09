<?php

namespace app\controllers;

use app\components\services\Excel;
use app\models\Page;
use yii\web\NotFoundHttpException;

class PageController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $excel = Excel::import();

        return $this->render('index', ['page' => $this->getPage(1)]);
    }

    public function actionAbout()
    {
        return $this->render('page', ['page' => $this->getPage(2)]);
    }

    public function actionPromo()
    {
        return $this->render('page', ['page' => $this->getPage(3)]);
    }
    
    public function actionPrice()
    {
        return $this->render('page', ['page' => $this->getPage(4)]);
    }

    public function actionContacts()
    {
        return $this->render('page', ['page' => $this->getPage(5)]);
    }

    public function actionDelivery()
    {
        return $this->render('page', ['page' => $this->getPage(6)]);
    }

    public function actionConsultation()
    {
        return $this->render('page', ['page' => $this->getPage(7)]);
    }

    public function actionSale()
    {
        return $this->render('page', ['page' => $this->getPage(8)]);
    }

    private function getPage($id)
    {
        if (!$page = Page::findOne($id)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $page;
    }
}
