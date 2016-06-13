<?php
use app\models\Order;
use app\models\OrderItem;

/* @var $this yii\web\View */
/* @var $orders array */
/* @var $order Order */
/* @var $item OrderItem */

$this->title = 'История заказов - Юнит-НН';
?>

<div class="margin-top-60 history">
    <h1>История заказов</h1>
    <div class="row history-orders">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php foreach ($orders as $order) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-<?= $order->id; ?>">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse-<?= $order->id; ?>" aria-expanded="false"
                               aria-controls="collapse-<?= $order->id; ?>">
                                <?= date('d.m.Y H:i', strtotime($order->date_created)); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-<?= $order->id; ?>" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading-<?= $order->id; ?>">
                        <div class="panel-body">
                            <table class="table">
                                <?php foreach ($order->items as $item) { ?>
                                <tr>
                                    <td><?= $item->product->title; ?></td>
                                    <td><?= $item->amount; ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
