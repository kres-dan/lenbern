define(function () {
    'use strict';
    var mixin = {


        handleAutocomplete: function (searchValue) {
            this._super();
            let len = 5;
        }
    };
    return function (target) {

        return target.extend(mixin);
    };

});