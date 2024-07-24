define([], function() {
    'use strict';

    return {
        serviceUrl: 'https://exam.razoyo.com/api',

        getCarList: function (carMake) {
            return this.serviceUrl + '/cars?make=' + carMake;
        }
    }
});
