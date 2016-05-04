<?php

namespace app\controllers;

use app\models\Page;

class PageController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $page = Page::find()->where(['id' => 1])->one();

        return $this->render('index', ['page' => $page]);
    }

    public function actionAbout()
    {
        $page = Page::findOne(2);

        return $this->render('about', ['page' => $page]);
    }

    public function actionPromo()
    {
        $page = Page::find()->where(['id' => 3])->one();

        return $this->render('promo', ['page' => $page]);
    }
    
    public function actionPrice()
    {
        $page = Page::find()->where(['id' => 4])->one();

        return $this->render('price', ['page' => $page]);
    }

    public function actionContact()
    {
        $page = Page::find()->where(['id' => 5])->one();

        return $this->render('contact', ['page' => $page]);
    }

    public function actionTransportation()
    {
        $page = Page::find()->where(['id' => 6])->one();

        return $this->render('transportation', ['page' => $page]);
    }



}
