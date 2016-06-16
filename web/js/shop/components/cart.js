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
        recalculate: function () {
            var self = this;
            self.quantity = 0;
            //
            // $('.input-amount').each(function(index, value) {
            //
            // });
            // self.quantityElement.text(self.quantity);
            //
            // if (self.quantity > 0) {
            //     self.container.removeClass('hidden');
            //
            // } else {
            //     self.container.addClass('hidden');
            // }
        },
        increment: function () {
            var self = this;

            self.container.removeClass('hidden');
            self.quantity++;
            self.quantityElement.text(self.quantity);
        },
        decrement: function () {
            var self = this;

            self.quantity--;

            if (self.quantity === 0) {
                self.container.addClass('hidden');
            }

            self.quantityElement.text(self.quantity);
        }
    });
});
