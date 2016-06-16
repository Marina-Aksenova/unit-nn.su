define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function () {
            var self = this;

            self.container = $('.cart');
            self.quantityElement = $('.cart-quantity');
            self.quantity = parseInt(self.quantityElement.text()) || 0;
        },
        set: function (amount, productId) {
            var self = this;

            order[productId] = amount;
            self.quantity = 0;

            _.each(order, function (quantity) {
                quantity = parseInt(quantity) || 0;
                self.quantity += parseInt(quantity);
            });

            if (self.quantity) {
                self.container.removeClass('hidden');
            }
            
            self.quantityElement.text(self.quantity);
        }
    });
});
