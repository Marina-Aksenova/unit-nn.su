requirejs([
    'components/search',
    'treeview',
    'checkbox'
], function (Search) {
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
                tree.treeview('toggleNodeExpanded', [node.nodeId, {silent: true}]);
            }
        }
    });

    $(document).on('pjax:send', function() {
        $('#loading').fadeIn();
    });
    $(document).on('pjax:complete', function() {
        $('#loading').fadeOut()
    });
});
