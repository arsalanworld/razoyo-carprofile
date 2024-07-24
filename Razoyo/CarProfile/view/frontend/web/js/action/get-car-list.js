/**
 * @api
 */
define(
    [
        'Razoyo_CarProfile/js/model/url-manager',
        'jquery'
    ], function (urlManager, $) {
        'use strict';

        return function (carMake, headers = {}) {
            let request = {
                url: urlManager.getCarList(carMake),
                type: 'GET',
                dataType: 'json',
            };
            if (headers.length) {
                request.headers = headers;
            }

            return $.ajax(request);
        }
    }
);
