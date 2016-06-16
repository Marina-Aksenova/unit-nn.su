define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function (options) {
            var self = this;

            self.container = options.container;
            self.buttonMinus = self.container.find('.button-minus');
            self.buttonPlus = self.container.find('.button-plus');
            self.input = self.container.find('.input-amount');
            self.amount = parseInt(self.input.val()) || 0;

            self.input.on('click', function () {
                $(this).select();
            });

            self.input.on('keyup', function () {
                self.amount = parseInt(self.input.val()) || 0;

                if (self.amount > 0) {
                    self.input.val(self.amount);
                    self.trigger('input');
                } else {
                    self.amount = 0;
                    self.input.val(self.amount);
                }
            });

            self.buttonMinus.on('click', function () {
                if (self.amount > 0) {
                    if (self.amount == 1) {
                        self.trigger('zero');
                    }

                    self.amount -= 1;
                    self.input.val(self.amount);
                    self.trigger('decrement');
                }
            });

            self.buttonPlus.on('click', function () {
                self.amount += 1;
                self.input.val(self.amount);
                self.trigger('increment');
            });
        },
        getAmount: function () {
            return this.amount;
        }
    });
});
