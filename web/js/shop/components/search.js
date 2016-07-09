define([
    'underscore',
    'backbone'
], function (_, Backbone) {
    return Backbone.View.extend({
        initialize: function () {
            var self = this;

            self.inputTimer = null;
            self.container = $('.shop-search');
            self.input = $('#shop-search-title');

            self.input.keyup(function () {
                clearTimeout(self.inputTimer);
                self.inputTimer = setTimeout(function () {
                    self.search();
                }, 500);

            });
         },
        clear: function () {
            var self = this;
            self.input.val('');
        },
        search: function () {
            var self = this;

            $('[name="ProductFilter[title]"]').val(self.input.val());
            $('[name="ProductFilter[price_dealer]"]').val('');
            $('[name="ProductFilter[stock]"]').val('');
            $('[name="ProductFilter[delivery]"]').val('');
            $("#products-grid").yiiGridView("applyFilter");

            var tree = $('#tree');

            // Убрать выделение у выбранного пункта
            var selectedNodes = tree.treeview('getSelected');
            _.each(selectedNodes, function (selectedNode) {
                tree.treeview('unselectNode', [selectedNode.nodeId, {silent: true}]);
            });
        }
    });
});
