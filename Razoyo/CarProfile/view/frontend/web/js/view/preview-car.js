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
    });
});
