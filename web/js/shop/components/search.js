define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function () {
            var self = this;

            self.titleTimer = null;
            self.container = $('.shop-search');
            self.title = $('#shop-search-title');
            self.stock = $('#shop-search-stock');
            self.stockInput = $('#shop-search-stock-input');
            self.delivery = $('#shop-search-delivery');
            self.deliveryInput = $('#shop-search-delivery-input');

            self.title.keyup(function () {
                clearTimeout(self.titleTimer);
                self.titleTimer = setTimeout(function () {
                    self.search();
                }, 500);
            });

            self.stock.click(function () {
                self.search();
            });

            self.delivery.click(function () {
                self.search();
            });
         },
        clear: function () {
            var self = this;
            self.title.val('');

            // Отжатие кнопок фильтров
            if (self.stockInput.is(':checked')) {
                self.stock.click();
            }
            if (self.deliveryInput.is(':checked')) {
                self.delivery.click();
            }
        },
        search: function () {
            var self = this;
            var isStock = self.stockInput.is(':checked') ? 1 : '';
            var isDelivery = self.deliveryInput.is(':checked') ? 1 : '';

            $('[name="ProductFilter[title]"]').val(self.title.val());
            $('[name="ProductFilter[price_dealer]"]').val('');
            $('[name="ProductFilter[stock]"]').val(isStock);
            $('[name="ProductFilter[delivery]"]').val(isDelivery);
            $("#products-grid").yiiGridView("applyFilter");
        }
    });
});
