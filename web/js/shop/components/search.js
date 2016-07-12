define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function () {
            var self = this;

            self.titleTimer = null;
            self.priceFromTimer = null;
            self.priceToTimer = null;

            self.container = $('.shop-search');
            self.clearButtom = $('#shop-search-clear');
            self.title = $('#shop-search-title');
            self.priceFrom = $('#shop-search-price-from');
            self.priceTo = $('#shop-search-price-to');
            self.stock = $('#shop-search-stock');
            self.stockInput = $('#shop-search-stock-input');
            self.delivery = $('#shop-search-delivery');
            self.deliveryInput = $('#shop-search-delivery-input');

            self.clearButtom.click(function () {
                self.clear();
                self.search();
            });

            self.title.keyup(function () {
                clearTimeout(self.titleTimer);
                self.titleTimer = setTimeout(function () {
                    self.search();
                }, 500);
            });

            self.priceFrom.keyup(function () {
                clearTimeout(self.priceFromTimer);
                self.priceFromTimer = setTimeout(function () {
                    self.search();
                }, 1000);
            });

            self.priceTo.keyup(function () {
                clearTimeout(self.priceToTimer);
                self.priceToTimer = setTimeout(function () {
                    self.search();
                }, 1000);
            });

            self.stock.click(function () {
                self.search();
            });

            self.delivery.click(function () {
                self.search();
            });

            $('.search-clear').click(function () {
                $(this).parent().parent().find('input').val('').keyup();
            });
         },
        clear: function () {
            var self = this;
            self.title.val('');
            self.priceFrom.val('');
            self.priceTo.val('');

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
            $('[name="ProductFilter[price_from]"]').val(self.priceFrom.val());
            $('[name="ProductFilter[price_to]"]').val(self.priceTo.val());
            $('[name="ProductFilter[stock]"]').val(isStock);
            $('[name="ProductFilter[delivery]"]').val(isDelivery);
            $("#products-grid").yiiGridView("applyFilter");
        }
    });
});
