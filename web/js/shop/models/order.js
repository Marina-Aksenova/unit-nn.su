define([
    'backbone'
], function (Backbone) {
    return Backbone.Model.extend({
        className: 'order',
        defaults: {
            title: '',
            description: ''
        }
    });
});