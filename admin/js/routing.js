var adminApp = angular.module('adminApp', ['ngRoute','ngCookies','textAngular']);
        
adminApp.config(['$routeProvider',
    function($routeProvider){
        $routeProvider
        .when('/',
            {
                controller: 'DashController',
                templateUrl: 'Partials/dashboard.html'
            })
        .when('/all-cards',
            {
                controller: 'CardsController',
                templateUrl: 'Partials/cards.html'
            })
        .when('/all-donors',
            {
                controller: 'DonorsController',
                templateUrl: 'Partials/donors.html'
            }) 
        .when('/mails',
            {
                controller: 'MailController',
                templateUrl: 'Partials/mails.html'
            })   
        .when('/erased-cards',
            {
                controller: 'ErasedCardsController',
                templateUrl: 'Partials/erased-cards.html'
            })
        .when('/reports',
            {
                controller: 'ReportsController',
                templateUrl: 'Partials/reports.html'
            })
        .otherwise({redirect:'/'});
    }
]);