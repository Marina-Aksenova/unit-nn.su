<?php

use yii\db\Schema;
use app\components\Migration;

class m160610_042126_init extends Migration
{
    public function init()
    {
        $this->operations = [
            [
                'up' => function() {
                    $this->createTable('page', [
                        'id' => $this->primaryKey()->unsigned()->comment('Идентификатор записи'),
                        'title' => $this->string(255)->comment('Название страницы'),
                        'name' => $this->string(50)->comment('Название страницы (alias)'),
                        'text' => $this->text()->comment('Содержимое страницы'),
                        'date_created' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "Дата добавления записи"',
                        'date_updated' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "Дата изменения записи"',
                        'date_deleted' => Schema::TYPE_TIMESTAMP . ' COMMENT "Дата удаления записи"',
                    ]);
                },
                'down' => function() {
                    $this->dropTable('page');
                },
                'transactional' => false,
            ],
            [
                'up' => function() {
                    $this->createTable('brand', [
                        'id' => $this->primaryKey()->unsigned()->comment('Идентификатор записи'),
                        'title' => $this->string(255)->comment('Название брэнда'),
                        'date_created' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "Дата добавления записи"',
                        'date_updated' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "Дата изменения записи"',
                        'date_deleted' => Schema::TYPE_TIMESTAMP . ' COMMENT "Дата удаления записи"',
                    ]);
                },
                'down' => function() {
                    $this->dropTable('brand');
                },
                'transactional' => false,
            ],
            [
                'up' => function() {
                    $this->createTable('product', [
                        'id' => $this->primaryKey()->unsigned()->comment('Идентификатор записи'),
                        'title' => $this->string(255)->comment('Название'),
                        'article' => $this->string(50)->comment('Артикул'),
                        'brand_id' => $this->integer()->unsigned()->comment('Брэнд'),
                        'catalog_number' => $this->string(50)->comment('Каталожный номер'),
                        'price_dealer' => $this->decimal(20, 2)->comment('Дилерская цена'),
                        'delivery' => $this->integer(11)->comment('Доставка'),
                        'stock' => $this->integer(11)->comment('Наличие'),
                        'description' => $this->text()->comment('Описание'),
                        'date_created' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "Дата добавления записи"',
                        'date_updated' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "Дата изменения записи"',
                        'date_deleted' => Schema::TYPE_TIMESTAMP . ' COMMENT "Дата удаления записи"',
                        'FOREIGN KEY product_2_brand (brand_id) REFERENCES brand (id) ON DELETE CASCADE ON UPDATE CASCADE',
                    ]);
                },
                'down' => function() {
                    $this->dropTable('product');
                },
                'transactional' => false,
            ],
            [
                'up' => function() {
                    $this->createTable('user', [
                        'id' => $this->primaryKey()->unsigned()->comment('Идентификатор записи'),
                        'first_name' => $this->string(50)->comment('Имя'),
                        'second_name' => $this->string(50)->comment('Фамилия'),
                        'third_name' => $this->string(50)->comment('Отчество'),
                        'phone' => $this->string(20)->comment('Номер телефона'),
                        'email' => $this->string()->comment('Электронная почта пользователя'),
                        'address' => $this->string()->comment('Адрес пользователя в произвольной форме'),
                        'auth_key' => $this->string(32)->notNull(),
                        'password_hash' => $this->string()->notNull(),
                        'password_reset_token' => $this->string(),
                        'date_created' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "Дата добавления записи"',
                        'date_updated' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "Дата изменения записи"',
                        'date_deleted' => Schema::TYPE_TIMESTAMP . ' COMMENT "Дата удаления записи"',
                    ]);
                },
                'down' => function() {
                    $this->dropTable('user');
                },
                'transactional' => false,
            ],
            [
                'up' => function() {
                    $this->createTable('order', [
                        'id' => $this->primaryKey()->unsigned()->comment('Идентификатор записи'),
                        'user_id' => $this->integer()->unsigned()->comment('Идентификатор пользователя'),
                        'date_created' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "Дата добавления записи"',
                        'date_updated' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "Дата изменения записи"',
                        'date_deleted' => Schema::TYPE_TIMESTAMP . ' COMMENT "Дата удаления записи"',
                        'FOREIGN KEY basket_2_user (user_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE',
                    ]);
                },
                'down' => function() {
                    $this->dropTable('order');
                },
                'transactional' => false,
            ],
            [
                'up' => function() {
                    $this->createTable('order_item', [
                        'id' => $this->primaryKey()->unsigned()->comment('Идентификатор записи'),
                        'order_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL COMMENT "Идентификатор заказа"',
                        'product_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL COMMENT "Идентификатор продукта"',
                        'amount' => $this->integer()->notNull()->comment('Количество данного товара'),
                        'date_created' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "Дата добавления записи"',
                        'date_updated' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "Дата изменения записи"',
                        'date_deleted' => Schema::TYPE_TIMESTAMP . ' COMMENT "Дата удаления записи"',
                        'FOREIGN KEY basket_2_product (product_id) REFERENCES `product` (id) ON DELETE CASCADE ON UPDATE CASCADE',
                        'FOREIGN KEY basket_2_order (order_id) REFERENCES `order` (id) ON DELETE CASCADE ON UPDATE CASCADE',
                    ]);
                },
                'down' => function() {
                    $this->dropTable('order_item');
                },
                'transactional' => false,
            ],
        ];
    }
}
