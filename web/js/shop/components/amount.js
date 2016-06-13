define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function (options) {
            var self = this;

            self.container = options.container;
            self.product_id = options.product_id;

            if (self.container) {
                self.buttonMinus = self.container.find('.button-minus');
                self.buttonPlus = self.container.find('.button-plus');
                self.input = self.container.find('.input-amount');
                var amount = self.getAmount();

                self.buttonMinus.on('click', function () {
                    var inputAmount = parseInt(self.getAmount()) || 0;

                    if (inputAmount > 0) {
                        if (inputAmount == 1) {
                            self.trigger('zero');
                        }

                        inputAmount -= 1;
                        self.input.val(inputAmount);
                        self.trigger('decrement');

                        self.send(self.product_id, inputAmount);
                    }
                });

                self.buttonPlus.on('click', function () {
                    var inputAmount = parseInt(self.getAmount()) || 0;
                    inputAmount += 1;
                    self.input.val(inputAmount);
                    self.trigger('increment');

                    self.send(self.product_id, inputAmount);
                });
            }
        },
        getAmount: function () {
            var self = this;
            var amount = null;
            
            if (self.input) {
                amount = self.input.val();
            }
            
            return amount;
        },
        send: function (productId, amount) {
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
