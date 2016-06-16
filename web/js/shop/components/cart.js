define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function (options) {
            var self = this;

            self.container = $('.cart');
            self.quantityElement = $('.cart-quantity');
            self.amountElement = $('.cart-amount');
        },
        quantity: 0,
        amount: 0,
        add: function () {
            var self = this;

            self.quantity++;
            self.quantityElement.text(self.quantity);
        }
    });
});
