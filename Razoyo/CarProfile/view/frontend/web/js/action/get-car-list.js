/**
 * @api
 */
define(
    [
        'Razoyo_CarProfile/js/model/url-manager',
        'mage/storage',
        'jquery'
    ], function (urlManager, storage, $) {
        'use strict';

        return function (carMake) {
            return $.ajax({
                url: urlManager.getCarList(carMake),
                type: 'GET',
                dataType: 'json',
            });
        }
    }
);
