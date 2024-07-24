/**
 * @api
 */
define([
    'Magento_Ui/js/form/element/select',
    'Razoyo_CarProfile/js/model/make-selected-value',
    'Razoyo_CarProfile/js/action/get-car-list'
], function (Select, makeSelectedValue, GetCarListAction) {
    'use strict';

    return Select.extend({
        defaults: {
            customName: '${ $.parentName }.${ $.index }_input',
            elementTmpl: 'Magento_Ui/form/element/select',
            caption: 'Select Your Car',
            options: []
        },

        initialize: function() {
            this._super();
            let self = this;
            makeSelectedValue.subscribe(function (selectedValue) {
                GetCarListAction(selectedValue).then(
                    function (response) {
                        self._updateOptions(response);
                    }
                );
            });
            /*let carList = GetCarListAction('honda').then(
                function (response) {
                    console.log('car list response has come', response);
                }
            );*/
            //console.log('car list', carList);
            /*let self = this;
            setTimeout(function () {
                self.options([{
                    'value': '1',
                    'label': 'option'
                }])
            }, 3600);*/

        },

        _updateOptions: function (response) {
            if (response.cars !== undefined && response.cars.length) {
                //this.options(response.cars);
            }
        }
    });
});
