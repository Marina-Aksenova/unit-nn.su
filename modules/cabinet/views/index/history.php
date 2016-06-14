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
    <div class="row">
        <div class="panel-group content-padding" id="accordion" role="tablist" aria-multiselectable="true">
            <?php foreach ($orders as $order) {
                $total = 0;
                $items = '';
                foreach ($order->items as $orderItem) {
                    $total += $orderItem->price * $orderItem->amount;
                    $items .=
                        '<tr>'.
                            '<td>' . $orderItem->product_title . '</td>' .
                            '<td>' . $orderItem->price . '</td>' .
                            '<td>' . $orderItem->amount . '</td>' .
                            '<td>' . number_format($orderItem->price * $orderItem->amount, 2, ',', ' ') . '</td>' .
                        '</tr>';
                }
            ?>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-<?= $order->id; ?>">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse-<?= $order->id; ?>" aria-expanded="false"
                               aria-controls="collapse-<?= $order->id; ?>">
                                <div class="pull-left">
                                    <?= date('d.m.Y H:i', strtotime($order->date_created)); ?>
                                </div>
                                <div class="pull-right">
                                    <strong><?= number_format($total, 2, ',', ' '); ?></strong>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-<?= $order->id; ?>" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading-<?= $order->id; ?>">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th>Название</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                                <?= $items; ?>
                                <tr>
                                    <td colspan="3"><strong>Итого</strong></td>
                                    <td><strong><?= number_format($total, 2, ',', ' '); ?></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
