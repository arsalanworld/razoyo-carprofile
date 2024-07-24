define([
    'uiComponent',
    'Razoyo_CarProfile/js/model/selected-car',
    'ko'
], function (Component, selectedCar, ko) {
    "use strict";

    return Component.extend({
        defaults: {
            template : "Razoyo_CarProfile/preview"
        },

        selectedCar: selectedCar,

        stringify: function () {
            return JSON.stringify(this.selectedCar());
        },

        toArray: function (str) {
            return JSON.parse(str);
        }
    });
});
