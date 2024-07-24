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
            customName: '${ $.index }_select',
            elementTmpl: 'Magento_Ui/form/element/select',
            caption: 'Select Your Car',
            options: [],
            yourToken: ''
        },

        initialize: function() {
            this._super();
            componentSelf = this;
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
            if (typeof value === 'string') {
                $('[type="submit"]').removeAttr('disabled');
                FindCarByIdAction(value, componentSelf.yourToken).then(
                    function (response) {
                        selectedCar((response.car !== undefined) ? response.car : {});
                    }
                );
            } else if (typeof value === 'undefined') {
                $('[type="submit"]').attr('disabled', 'disabled');
            }
        },

        _updateOptions: function (response) {
            if (response.cars !== undefined && response.cars.length) {
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
