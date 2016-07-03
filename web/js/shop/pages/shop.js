requirejs([
    'components/search',
    'treeview'
], function (Search, TreeView) {
    // Меню
    var tree = $('#tree');
    tree.treeview({
        data: treeData,
        onNodeSelected: function(event, data) {
            if (data.productBrandId) {
                $('[name="ProductFilter[brand_id]"]').val(data.productBrandId);
                $('[name="ProductFilter[group_id]"]').val(data.productGroupId);
                $('#products-grid').yiiGridView('applyFilter');
            }
        }
    });
    
    var search = new Search();
});