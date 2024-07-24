/**
 * @api
 */
define(
    [
        'Razoyo_CarProfile/js/model/url-manager',
        'jquery'
    ], function (urlManager, $) {
        'use strict';

        return function (id, yourToken) {
            let request = {
                url: urlManager.getCarById(id),
                type: 'GET',
                dataType: 'json',
                headers: {
                    'Authorization': `Bearer ${yourToken}`
                },
            };

            return $.ajax(request);
        }
    }
);
