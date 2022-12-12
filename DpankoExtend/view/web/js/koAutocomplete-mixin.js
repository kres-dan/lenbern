define(function () {

    'use strict';


    var mixin = {
        setMinLength: function(){
            this.minLength = 5;
        },
    };


    return function (target) {

        return target.extend(mixin);

    };

});