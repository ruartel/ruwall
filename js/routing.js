var fjcApp = angular.module('fjcApp', ['ngRoute','ngCookies','ngDialog','akoenig.deckgrid','ngImgCrop','ui.date','angularFileUpload']);
        
fjcApp.config(['$routeProvider',
    function($routeProvider){
        $routeProvider
        .when('/',
            {
                controller: 'HomeController',
                templateUrl: 'Partials/Home2.html'
            })
        .when('/donate',
            {
                controller: 'FormController',
                templateUrl: 'Partials/donate.html'
            })
        .when('/add-loved-one',
            {
                controller: 'FormLoveController',
                templateUrl: 'Partials/add-loved-one2.html'
            }) 
        .when('/about',
            {
                controller: 'aboutController',
                templateUrl: 'Partials/about.html'
            })
         .when('/yizkor',
            {
                controller: 'aboutController',
                templateUrl: 'Partials/yizkor.html'
            })
        .when('/d/:id',
            {
                controller: 'UserPageController',
                templateUrl: 'Partials/d.html'
            })  
        .when('/edit/:id',
            {
                controller: 'EditController',
                templateUrl: 'Partials/edit.html'
            })      
        .when('/thanks',
            {
                controller: 'ThanksPageController',
                templateUrl: 'Partials/Thanks.html'
            })    
        .otherwise({redirect:'/'});
    }
]);