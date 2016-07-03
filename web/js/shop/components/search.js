define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function () {
            var self = this;

            self.inputTimer = null;
            self.container = $('.shop-search');
            self.input = $('#shop-search-input');

            self.input.keyup(function () {
                clearTimeout(self.inputTimer);
                self.inputTimer = setTimeout(function () {
                    self.search();
                }, 500);

            });
         },
        search: function () {
            var self = this;

            $('[name="ProductFilter[title]"]').val(self.input.val());
            $('[name="ProductFilter[group_id]"]').val('');
            $('[name="ProductFilter[brand_id]"]').val('');
            $('[name="ProductFilter[price_dealer]"]').val('');
            $('[name="ProductFilter[stock]"]').val('');
            $('[name="ProductFilter[delivery]"]').val('');
            $("#products-grid").yiiGridView("applyFilter");
        }
    });
});
