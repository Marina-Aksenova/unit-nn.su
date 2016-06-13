define([
    'backbone'
], function (Backbone) {
    return Backbone.Model.extend({
        className: 'product',
        defaults: {
            title: '',
            description: ''
        }
    });
});