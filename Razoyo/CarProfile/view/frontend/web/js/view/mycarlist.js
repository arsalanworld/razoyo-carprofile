define([
    'uiComponent',
    'Razoyo_CarProfile/js/model/makes',
    'Razoyo_CarProfile/js/action/get-car-list',
    'ko'
], function (Component, makes, GetCarListAction, ko) {
    "use strict";

    return Component.extend({
        defaults: {
            template: 'Razoyo_CarProfile/ui/form/element/make-select',
        },
        makes: makes,
        selectedValue: ko.observable('Honda'),

        initialize: function () {
            this._super();
            let self = this;

            GetCarListAction('').then(function (response) {
                self.makes((response.makes !== undefined) ? response.makes : []);
                self.selectedValue('initial value');
            });
        },

        onOptionUpdate: function (e) {
            console.log('option update', e);
            console.log(this.value);
        }
    });
});
