define('shop', [
    'underscore',
    'backbone',
    'models/orderItem',
    'components/amount',
    'components/cart',
    'treeview'
], function (_, Backbone, OrderItemModel, AmountComponent, CartComponent, TreeView) {
    return Backbone.View.extend({
        render: function () {
            var self = this;
            var cart = new CartComponent();

            $('table tbody tr').each(function (index, row) {
                row = $(row);
                var productId = row.data('key');
                var price = row.data('price');

                // Обработка контейнера с количеством
                var amountComponent = new AmountComponent({
                    container: row.find('.component-amount')
                });
                amountComponent.on('increment', function () {
                    row.addClass('success');
                    cart.set(amountComponent.getAmount(), productId);
                    self.send(amountComponent.getAmount(), productId);
                });
                amountComponent.on('decrement', function () {
                    self.send(amountComponent.getAmount(), productId);
                    cart.set(amountComponent.getAmount(), productId);
                });
                amountComponent.on('zero', function () {
                    row.removeClass('success');
                });
                amountComponent.on('input', function () {
                    if (amountComponent.getAmount() > 0) {
                        row.addClass('success');
                    } else {
                        row.removeClass('success');
                    }
                    cart.set(amountComponent.getAmount(), productId);
                });
            });
            
            // Меню
            $('#tree').treeview({
                data: treeData,
                levels: 5,
                backColor: 'green',
                onNodeSelected: function(event, data) {

                    if (data.brandId) {
                        $('[name="ProductFilter[brand_id]"]').val(data.brandId)
                        $("#products-grid").yiiGridView("applyFilter");
                    }

                    return false;
                }
            });
        },
        send: function(amount, productId) {
            $.ajax({
                url: '/cart/add',
                type: 'post',
                data: {product_id: productId, amount: amount},
                error: function (jqXHR, status, error) {
                    var errorText = error;

                    if (jqXHR.responseText) {
                        errorText = jqXHR.responseText;
                    }

                    alert(errorText);
                }
            });

        }
    });
});