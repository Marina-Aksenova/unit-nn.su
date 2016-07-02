<?php
namespace app\modules\admin\models;

use app\components\services\Excel;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . uniqid() . '_' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($filePath);
            Excel::importPrice($filePath);

            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Файл с прайс-листом',
        ];
    }
}