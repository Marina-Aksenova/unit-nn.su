<?php
namespace app\models;

use app\components\BaseActiveRecord;
use app\components\services\BaseService;
use libphonenumber\PhoneNumberUtil;
use yii;
use yii\base\UserException;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $first_name
 * @property string $second_name
 * @property string $third_name
 * @property string $phone
 * @property string $email
 * @property integer $image_id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $password write-only password
 */
class User extends BaseActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 'admin';
    
    public $password;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function beforeSave($insert)
    {
        $this->setPassword();

        return parent::beforeSave($insert);
    }

    public function rules()
    {
        return [
            ['first_name', 'required'],
            ['first_name', 'string', 'max' => 50,],
            ['first_name', 'trim'],

            ['second_name', 'string', 'max' => 50,],
            ['second_name', 'trim'],
            ['second_name', 'default', 'value' => null],

            ['third_name', 'string', 'max' => 50,],
            ['third_name', 'trim'],
            ['third_name', 'default', 'value' => null],

            ['address', 'string', 'max' => 255,],
            ['address', 'trim'],
            ['address', 'default', 'value' => null],

            ['phone', 'app\components\validators\Phone'],
            ['phone', 'trim'],

            ['email', 'string', 'max' => 255,],
            ['email', 'email'],
            ['email', 'trim'],
            ['email', 'checkMail'],

            ['password', 'string', 'min' => 5, 'max' => 25,],
        ];
    }

    public function checkMail()
    {
        if (!$this->phone && !$this->email) {
            $this->addError('phone', 'Необходимо указать электропочту или телефон');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'third_name' => 'Отчество',
            'phone' => 'Телефон',
            'address' => 'Адрес',
            'email' => 'Электропочта',
            'password' => 'Пароль',
        ];
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword()
    {
        if (!$this->password_hash && !$this->password) {
            $this->addError('Необходимо ввести пароль');
        }

        if ($this->password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
    }
    
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new UserException('Системная ошибка');
    }

    /**
     * @param $login
     * @return null|self
     */
    public static function findByEmailOrPhone($login)
    {
        return (new ActiveQuery(get_called_class()))
            ->where(['phone' => $login])
            ->orWhere(['email' => $login])
            ->one();
    }

    public function getFio()
    {
        $fio = $this->first_name;

        if (!empty($this->seco)) {
            $fio = $this->second_name . ' ' . $fio;
        }

        if (!empty($this->third_name)) {
            $fio = $fio . ' ' . $this->third_name;
        }
        return $fio;
    }
}