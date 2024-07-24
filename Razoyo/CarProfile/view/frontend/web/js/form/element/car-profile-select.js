/**
 * @api
 */
define([
    'Magento_Ui/js/form/element/select',
    'Razoyo_CarProfile/js/model/make-selected-value',
    'Razoyo_CarProfile/js/model/selected-car',
    'Razoyo_CarProfile/js/action/get-car-list',
    'Razoyo_CarProfile/js/action/find-car-by-id',
    'underscore',
    'jquery'
], function (
    Select,
    makeSelectedValue,
    selectedCar,
    GetCarListAction,
    FindCarByIdAction,
    _,
    $
) {
    'use strict';

    var componentSelf;
    return Select.extend({
        defaults: {
            customName: '${ $.parentName }.${ $.index }_input',
            elementTmpl: 'Magento_Ui/form/element/select',
            caption: 'Select Your Car',
            options: [],
            yourToken: ''
        },
        //yourToken: ko.observable(''),

        initialize: function() {
            this._super();
            console.log('init before', this.yourToken);
            componentSelf = this;
            console.log('init after');
            makeSelectedValue.subscribe(function (selectedValue) {
                GetCarListAction(selectedValue).then(
                    function (response, textStatus, xhr) {
                        componentSelf._updateOptions(response);
                        componentSelf.yourToken = xhr.getResponseHeader('your-token');
                    }
                );
            });
        },

        /**
         * Retrieve Car details on selection update
         *
         * @param value
         * @returns {*}
         */
        onUpdate: function (value) {
            this._super();

            if (typeof value === 'string') {
                $('[type="submit"]').removeAttr('disabled');
                console.log('componentSelf.yourToken', componentSelf.yourToken);
                FindCarByIdAction(value, componentSelf.yourToken).then(
                    function (response) {
                        selectedCar((response.car !== undefined) ? response.car : {});
                        console.log('selected car:', selectedCar());
                    }
                );
            } else if (typeof value === 'undefined') {
                $('[type="submit"]').attr('disabled', 'disabled');
            }

            return this;
        },

        _updateOptions: function (response) {
            if (response.cars !== undefined && response.cars.length) {
                console.log('update cars');
                this.options([]);
                _.each(response.cars, function (car) {
                    componentSelf.options.push({
                        'value': car.id,
                        'label': car.make + ' ' + car.model + ' ' + car.year
                    });
                });
            }
        }
    });
});
