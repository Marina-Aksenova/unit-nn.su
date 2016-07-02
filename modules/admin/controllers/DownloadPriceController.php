<?php

namespace app\modules\admin\controllers;

use app\models\User;
use app\modules\admin\models\UploadForm;
use yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

class DownloadPriceController extends Controller
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
        $uploadForm = new UploadForm();

        if ($postData = Yii::$app->request->post()) {
            if (!$uploadedFile = UploadedFile::getInstance($uploadForm, 'file')) {
                throw new UserException('Не передан файл');
            }

            $uploadForm->file = $uploadedFile;
            if ($uploadForm->upload()) {
                Yii::$app->session->setFlash('success', 'Прайс-лист успешно загружен в систему');
            }
        }

        return $this->render('index', ['model' => $uploadForm]);
    }
}