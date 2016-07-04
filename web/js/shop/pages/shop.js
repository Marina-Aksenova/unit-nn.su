requirejs([
    'components/search',
    'treeview'
], function (Search, TreeView) {
    var search = new Search();

    // Меню
    var tree = $('#tree');
    tree.treeview({
        data: treeData,
        onNodeSelected: function(event, node) {
            if (node.productBrandId) {
                search.clear();
                $('[name="ProductFilter[title]"]').val('');
                $('[name="ProductFilter[price_dealer]"]').val('');
                $('[name="ProductFilter[stock]"]').val('');
                $('[name="ProductFilter[delivery]"]').val('');
                $('[name="ProductFilter[brand_id]"]').val(node.productBrandId);
                $('[name="ProductFilter[group_id]"]').val(node.productGroupId);
                $('#products-grid').yiiGridView('applyFilter');
            } else {
                tree.treeview('unselectNode', [node.nodeId, {silent: true}]);
            }
        }
    });

    $(document).on('pjax:send', function() {
        $('#loading').show();

        // Убрать выделение у выбранного пункта
        var selectedNodes = tree.treeview('getSelected');
        _.each(selectedNodes, function (selectedNode) {
            tree.treeview('unselectNode', [selectedNode.nodeId, {silent: true}]);
        });
    });
    $(document).on('pjax:complete', function() {
        $('#loading').hide()
    });
});