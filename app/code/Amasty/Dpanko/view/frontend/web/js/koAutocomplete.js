define(['uiComponent', 'jquery'], function (Component, $) {
    return Component.extend({
        defaults: {
            searchText: '',
            searchResult: [],
            minLength: 0

        },
        initObservable: function () {
            this._super();
            this.observe(['searchText', 'searchResult']);
            return this;
        },

        initialize: function () {
            this._super();
            this.searchText.subscribe(this.handleAutocomplete.bind(this));
            return this;
        },
        setMinLength: function () {
            this.minLength = 3;
        },
        handleAutocomplete: function (searchValue) {
            let len = 3;
            if (searchValue.length >= this.minLength) {
                let queryText;
                $.ajax('search/ajax/suggest', {

                    dataType: "json",
                    data: {sku: searchValue},
                    success: function (result){

                        this.searchResult(result);
                    }.bind(this)

                })
            }
            else{
                this.searchResult([]);


            }
        }
    })
})
