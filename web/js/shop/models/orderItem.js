define([
    'backbone'
], function (Backbone) {
    return Backbone.Model.extend({
        urlRoot: '/api/order-item',
        className: 'orderItem',
        defaults: {
            order_id: '',
            product_id: '',
            amount: 0
        }
    });
});