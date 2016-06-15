define('shop', [
    'underscore',
    'backbone',
    'models/orderItem',
    'components/amount'
], function (_, Backbone, OrderItemModel, AmountComponent) {
    return Backbone.View.extend({
        render: function () {
            var products = [];

            $('table tbody tr').each(function (index, row) {
                row = $(row);

                // Обработка контейнера с количеством
                var amountComponent = new AmountComponent({
                    container: row.find('.component-amount'),
                    product_id: row.data('key')
                });
                amountComponent.on('increment', function () {
                    row.addClass('success');
                });
                amountComponent.on('zero', function () {
                    row.removeClass('success');
                });
            });
        }
    });
});