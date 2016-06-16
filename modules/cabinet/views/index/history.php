<?php
use app\components\services\BaseService;
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
                            '<td class="text-center">' . BaseService::getFormattedPrice($orderItem->price ) . '</td>' .
                            '<td class="text-center">' . $orderItem->amount . '</td>' .
                            '<td class="text-center">' . BaseService::getFormattedPrice($orderItem->price * $orderItem->amount) . '</td>' .
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
                                    <strong><?= BaseService::getFormattedPrice($total); ?></strong>
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
                                    <th class="text-center">Цена</th>
                                    <th class="text-center">Количество</th>
                                    <th class="text-center">Сумма</th>
                                </tr>
                                <?= $items; ?>
                                <tr>
                                    <td colspan="3"><strong>Итого</strong></td>
                                    <td class="text-center"><strong><?= BaseService::getFormattedPrice($total); ?></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
