adminApp.controller('DashController', ['$scope','$http','AdminService',function($scope,$http,AdminService){
    init();
    function init(){
        AdminService.checkLogIn($scope);
        AdminService.getWaitingAuth($scope);
        AdminService.lastDonations($scope);
    }
    
    $scope.sendMailToDonor = function(email){
        var link = "mailto:"+ email;
//             + "?subject=New%20email " + escape(subject)
//             + "&body=" + escape(body); 
        window.location.href = link;
    }
    
    $scope.authAllChk = function(){
        allOkChk = $('.okChk');
        strChk='';
        $.each(allOkChk, function(){
            if ($(this).prop('checked')) {
                //is checked authorize this one
                curId = $(this).attr('id');
                idArr = curId.split('_');
                if (strChk == '') {
                    strChk = idArr[1];
                }else{
                    strChk += ',' + idArr[1];
                }
            }
        });
        if (strChk != '') {
            $http.post('/admin/authChks.php', {chk:strChk}).
            success(function(data, status, headers, config) {
                strChk2 = strChk.split(",");
                $.each(strChk2, function(){
                    $("#tdWa_" + this).fadeOut();    
                });
            }).
            error(function(data, status, headers, config) {
    
            });
        }
    };
    
    $scope.removeCards = function(){
        allOkChk = $('.okChk');
        strChk='';
        $.each(allOkChk, function(){
            if ($(this).prop('checked')) {
                //is checked authorize this one
                curId = $(this).attr('id');
                idArr = curId.split('_');
                if (strChk == '') {
                    strChk = idArr[1];
                }else{
                    strChk += ',' + idArr[1];
                }
            }
        });
        if (strChk != '') {
            $http.post('/admin/removeChks.php', {chk:strChk}).
            success(function(data, status, headers, config) {
                strChk2 = strChk.split(",");
                $.each(strChk2, function(){
                    $("#tdWa_" + this).fadeOut();    
                });
            }).
            error(function(data, status, headers, config) {
    
            });
        }
    };
}]);

adminApp.controller('DonorsController', ['$scope','$http','AdminService',function($scope,$http,AdminService){
    init();
    function init(){
        AdminService.checkLogIn($scope);
        $http.post('/admin/getDonors.php').
        success(function(data, status, headers, config) {
            $scope.donors = data;
        }).
        error(function(data, status, headers, config) {

        });
    }
    
    $scope.sendMailToDonor = function(email){
        var link = "mailto:"+ email;
//             + "?subject=New%20email " + escape(subject)
//             + "&body=" + escape(body); 
        window.location.href = link;
    }
}]);
 
adminApp.controller('MailController', ['$scope','$http','AdminService',function($scope,$http,AdminService){
    init();
    function init(){
        AdminService.checkLogIn($scope);
        //get emails values
        $http.post('getEmais.php').
        success(function(data, status, headers, config) {
            $scope.subsMail_subject = data[0].email_subject;
            $scope.subsMail = data[0].email_content;
            $scope.authMail_subject = data[1].email_subject;
            $scope.authMail = data[1].email_content;
            $scope.yahMail_subject = data[2].email_subject;
            $scope.yahMail = data[2].email_content;
        }).
        error(function(data, status, headers, config) {
            alert('Connection problem, try again in a few minutes');
        });
    }
    $scope.saveEmail = function(){
        //get the email values
        
        var params = {
            subsMail_subject: $scope.subsMail_subject,
            subsMail: $scope.subsMail,
            authMail_subject: $scope.authMail_subject,
            authMail: $scope.authMail,
            yahMail_subject: $scope.yahMail_subject,
            yahMail: $scope.yahMail,
        };
        
        $http.post('saveEmais.php', {p: params}).
        success(function(data, status, headers, config) {
            alert('Emails saved');
        }).
        error(function(data, status, headers, config) {
            alert('Connection problem, try again in a few minutes');
        });
    };
}]);

adminApp.controller('ErasedCardsController', ['$scope','$http','AdminService',function($scope,$http,AdminService){
    init();
    function init(){
        AdminService.checkLogIn($scope);
        $http.post('/Controller/getUsers.php', {a: 'getErased'}).
        success(function(data, status, headers, config) {
            console.log(data);
            $scope.cards = data;
        }).
        error(function(data, status, headers, config) {

        });
    }
    
    $scope.resetAllChk = function(){
        allOkChk = $('.okChk');
        strChk='';
        $.each(allOkChk, function(){
            if ($(this).prop('checked')) {
                //is checked authorize this one
                curId = $(this).attr('id');
                idArr = curId.split('_');
                if (strChk == '') {
                    strChk = idArr[1];
                }else{
                    strChk += ',' + idArr[1];
                }
            }
        });
        if (strChk != '') {
            $http.post('/admin/resetChks.php', {chk:strChk}).
            success(function(data, status, headers, config) {
                strChk2 = strChk.split(",");
                $.each(strChk2, function(){
                    $("#tdCard_" + this).fadeOut();    
                });
            }).
            error(function(data, status, headers, config) {
    
            });
        }
    };
}]);

adminApp.controller('CardsController', ['$scope','$http','AdminService',function($scope,$http,AdminService){
    init();
    function init(){
        AdminService.checkLogIn($scope);
        $http.post('/Controller/getUsers.php', {a: 'getAll'}).
        success(function(data, status, headers, config) {
            console.log(data);
            $scope.cards = data;
        }).
        error(function(data, status, headers, config) {

        });
    }
    
    $scope.authAllChk = function(){
        allOkChk = $('.okChk');
        strChk='';
        $.each(allOkChk, function(){
            if ($(this).prop('checked')) {
                //is checked authorize this one
                curId = $(this).attr('id');
                idArr = curId.split('_');
                if (strChk == '') {
                    strChk = idArr[1];
                }else{
                    strChk += ',' + idArr[1];
                }
            }
        });
        if (strChk != '') {
            $http.post('/admin/authChks.php', {chk:strChk}).
            success(function(data, status, headers, config) {
                strChk2 = strChk.split(",");
                $.each(strChk2, function(){
                    $("#tdWa_" + this).fadeOut();    
                });
            }).
            error(function(data, status, headers, config) {
    
            });
        }
    };
    
    $scope.removeCards = function(){
        allOkChk = $('.okChk');
        strChk='';
        $.each(allOkChk, function(){
            if ($(this).prop('checked')) {
                //is checked authorize this one
                curId = $(this).attr('id');
                idArr = curId.split('_');
                if (strChk == '') {
                    strChk = idArr[1];
                }else{
                    strChk += ',' + idArr[1];
                }
            }
        });
        if (strChk != '') {
            $http.post('/admin/removeChks.php', {chk:strChk}).
            success(function(data, status, headers, config) {
                strChk2 = strChk.split(",");
                $.each(strChk2, function(){
                    $("#tdCard_" + this).fadeOut();    
                });
            }).
            error(function(data, status, headers, config) {
    
            });
        }
    };
}]);


adminApp.service('AdminService', ['$cookieStore','$cookies','$http','$sce','$routeParams', function($cookieStore,$cookies,$http,$sce,$routeParams){
    var service = {};
    
    service.checkLogIn = function($scope){
        $http.post('/admin/index2.php').
        success(function(data, status, headers, config) {
            if (!data) {
                window.location = "/admin/login.html";
            }
        }).
        error(function(data, status, headers, config) {

        });
    };
    
    service.getWaitingAuth = function($scope){
        $http.post('/admin/getWaitingAuth.php').
        success(function(data, status, headers, config) {
//            console.log(data);
            $scope.waitingAuth = data;
        }).
        error(function(data, status, headers, config) {

        });
    };
    
    service.lastDonations = function($scope){
        $http.post('/admin/lastDonations.php').
        success(function(data, status, headers, config) {
            $scope.lastDonations = data;
        }).
        error(function(data, status, headers, config) {

        });
    };
    
    return service;
}]);

adminApp.controller('ReportsController', ['$scope','$http','AdminService',function($scope,$http,AdminService){
    init();
    function init(){
        AdminService.checkLogIn($scope);
        $http.post('/admin/getReports.php').
            success(function(data, status, headers, config) {
                //console.log(data);
                $scope.report = data;
            }).
            error(function(data, status, headers, config) {

            });
    }
}]);
