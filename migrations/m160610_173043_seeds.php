<?php

use app\models\Page;
use app\models\User;
use yii\db\Schema;
use app\components\Migration;
use yii\rbac\Role;

class m160610_173043_seeds extends Migration
{
    public function init()
    {
        $this->operations = [
            [
                'up' => function (){
                    $adminRole = new Role([
                        'name' => User::ROLE_ADMIN,
                    ]);
                    Yii::$app->getAuthManager()->add($adminRole);

                    $admin = new User([
                        'first_name' => 'Иван',
                        'second_name' => 'Иванович',
                        'email' => 'feaman@mail.ru',
                        'phone' => '9092910252',
                        'password' => '1',
                    ]);
                    $admin->setPassword();
                    $admin->save(false);
                    Yii::$app->getAuthManager()->assign($adminRole, $admin->id);

                    $admin = new User([
                        'first_name' => 'Пётр',
                        'second_name' => 'Кирсанов',
                        'email' => 'test@mail.ru',
                        'phone' => '9991234567',
                        'password' => '1',
                    ]);
                    $admin->setPassword();
                    $admin->save(false);

                    $page = new Page([
                        'title' => 'Заглавная',
                        'name' => 'main',
                        'text' => 'main',
                    ]);
                    $page->save(false);

                    $page = new Page([
                        'title' => 'О компании',
                        'name' => 'about',
                        'text' => '
                            <p style="text-align: justify;"><span style="font-size: 14pt; color: #333333;">Компания ООО «Юнит-НН» поставляет расходные материалы для ремонта оргтехники и заправки картриджей.</span></p>
                            <p><span style="font-size: 14pt; color: #333333;"><strong>Список услуг:</strong></span><br><span style="font-size: 14pt; color: #333333;">- продажа расходных материалов;</span><br><span style="font-size: 14pt; color: #333333;">- ремонт оргтехники;</span><br><span style="font-size: 14pt; color: #333333;">- заправка картриджей.</span></p>
                            <p><span style="font-size: 14pt;">&nbsp;<span style="color: #333333;"><strong>Мы поставляем:</strong></span></span><br><span style="font-size: 14pt; color: #333333;">- фотовалы (Mitsubishi, DUC, SC, Samsung);</span><br><span style="font-size: 14pt; color: #333333;">- ракеля (Kuroki);</span><br><span style="font-size: 14pt; color: #333333;">- тонеры (IMEX, Mitsubishi, TOMOEGAWA);</span><br><span style="font-size: 14pt; color: #333333;">- чипы (JT, ApexMIC);</span><br><span style="font-size: 14pt; color: #333333;">- СНПЧ и ПЗК (IST, UNIJET);</span><br><span style="font-size: 14pt; color: #333333;">- чернила (InkTec, Unijet, Ink-Mate);</span><br><span style="font-size: 14pt; color: #333333;">- совместимые струйные картриджи HP, Canon, Epson (MyInk, Unijet, InkTec);</span><br><span style="font-size: 14pt; color: #333333;">- совместимые лазерные картриджи (UNITON).</span></p>
                            <p><span style="font-size: 14pt; color: #333333;"><strong>Бесплатная доставка, поиск запчастей под заказ.</strong></span></p>'
                    ]);
                    $page->save(false);

                    $page = new Page([
                        'title' => 'Доставка',
                        'name' => 'delivery',
                        'text' => '<p><span style="color: #000000;"><strong><span style="font-size: 14pt;">Доставка:</span></strong></span><br><span style="font-size: 14pt; color: #000000;">- по г. Нижний Новгород - бесплатная</span><br><span style="font-size: 14pt; color: #000000;">- по г. Дзержинск четверг, пятница - бесплатная</span><br><span style="font-size: 14pt; color: #000000;">- по Нижегородской области и России при заказе от 7000 руб. - бесплатная, при заказее меньше 7000 руб., доставка от 250 руб.</span></p><p><span style="color: #000000;"><strong><span style="font-size: 14pt;">Сотрудничаем с транспортными компаниями:</span></strong></span><br><span style="font-size: 14pt; color: #000000;">- Деловые линии</span><br><span style="font-size: 14pt; color: #000000;">- DPD</span><br><span style="font-size: 14pt; color: #000000;">- Пэк</span></p>',
                    ]);
                    $page->save(false);

                    $page = new Page([
                        'title' => 'Контакты',
                        'name' => 'contacts',
                        'text' => '<p> <span style="font-size: 14pt; color: #333333;"> <strong>Адрес:</strong> Н.Новгород, ул. Юбилейная, д.2, оф.№9 </span> <br> <span style="font-size: 14pt; color: #333333;"> <strong>Телефон:</strong> +7 (831) 220-94-33, 220-94-34 </span> <br> <span style="font-size: 14pt; color: #333333;"> <strong>Время работы:</strong> с 9.00 до 18.00</span> <br> <span style="font-size: 14pt; color: #333333;"> <strong>Руководитель:</strong> Лысенко Дмитрий Леонидович</span> <br> <span style="font-size: 14pt; color: #333333;"> <img src="http://wwp.icq.com/scripts/online.dll?icq=261664508&amp;img=5" alt="" border="0">ICQ: 261-664-508 </span> <br> <span style="font-size: 14pt; color: #333333;"> e-mail: <span id="cloak13224"><a href="mailto:d.lysenko@unit-nn.su">d.lysenko@unit-nn.su</a></span> </span> <br> <span style="font-size: 14pt; color: #333333;"> <strong>Руководитель отдела продаж:</strong> Сигаев Максим Сергеевич</span><br><span style="font-size: 14pt; color: #333333;"> <img src="http://wwp.icq.com/scripts/online.dll?icq=355687694&amp;img=5" alt="" border="0">ICQ: 355-687-694 </span> <br> <span style="font-size: 14pt; color: #333333;">e-mail: <span id="cloak56949"><a href="mailto:m.sigaev@unit-nn.su">m.sigaev@unit-nn.su</a></span>',
                    ]);
                    $page->save(false);

                    $page = new Page([
                        'title' => 'Распродажа',
                        'name' => 'sale',
                        'text' => 'Надо делать опять ту таблицу с кучей ссылок',
                    ]);
                    $page->save(false);
                },
                'down' => function (){
                    Yii::$app->getAuthManager()->removeAll();
                    User::find()->one()->delete();
                },
                'transactional' => true,
            ],
        ];
    }
}
