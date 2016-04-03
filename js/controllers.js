fjcApp.controller('HomeController', ['$scope','$sce','$window','UserService',function($scope,$sce,$window,UserService){
    init();
    function init(){
//        sHeight = $window.innerHeight - 100;
//        $("div#viewContainer").css('min-height', sHeight);
        $(".hsearchwp").removeClass('hidden-search');
        UserService.getAllUsers($scope);
        setTimeout(function(){ 
            $scope.openPlque();
        }, 3000);        
    }   
    $scope.openPlque = function(){
        $( ".add-loved_float" ).animate({
            width: '200px'
        }, 250, function() {
            // Animation complete.
            $( ".add-loved_float_link" ).show();
            $( ".close-plaquet" ).show();
            $( ".open-arrow-plaquet" ).hide();
        });
    };
//    $scope.filters =  {};
    
}]);

fjcApp.controller('left-plaquet', ['$scope',function($scope){
    $scope.close_plaquet = function(){
        $( ".add-loved_float_link" ).hide();
        $( ".add-loved_float" ).animate({
            width: '40px'
        }, 250, function() {
            $( ".close-plaquet" ).hide();
            $( ".open-arrow-plaquet" ).show();
        });
    };
    
    $scope.open_plaquet = function(){
        $( ".add-loved_float" ).animate({
            width: '200px'
        }, 250, function() {
            // Animation complete.
            $( ".add-loved_float_link" ).show();
            $( ".close-plaquet" ).show();
            $( ".open-arrow-plaquet" ).hide();
        });
    };
}]);

fjcApp.controller('aboutController', ['$scope','$http', function($scope,$http){
    $(".hsearchwp").addClass('hidden-search');
    
    $scope.submitAbout = function(){
        allValid = $('.ng-valid-required');
        $.each(allValid, function(){
            if(this.type == 'text' || this.type == 'email'){
                $parDv = $(this).parent();
                console.log($parDv);
                $parDv.css('background-color', '#FFF');
            }else if(this.type == 'radio'){
                $parDv = $(this).parent();
                $parDv.css('background-color', 'transparent');
            }
        });
        
        doSub=true;
        allInvalid = $('.ng-invalid-required, .ng-invalid-email');
        $.each(allInvalid, function(){
            if(this.type == 'text' || this.type == 'email'){
                $parDv = $(this).parent();
//                console.log($parDv);
                $parDv.css('background-color', '#F4C9C9');
            }else if(this.type == 'radio'){
                $parDv = $(this).parent();
                $parDv.css('background-color', '#F4C9C9');
            }
            doSub = false;
        });
        if (doSub) {
            var params = {
                lead:$scope.lead
            };
            
            $http.post('contact.php', {p:params}).
            success(function(data, status, headers, config) {
                $('.mailSendAlert').show();
                setTimeout(function(){ $('.mailSendAlert').fadeOut(); }, 2000);
                $scope.lead.email='';
                $scope.lead.fname='';
                $scope.lead.lname='';
                $scope.lead.message='';
            }).
            error(function(data, status, headers, config) {

            });
        }
        
    };
}]);

fjcApp.controller('ThanksPageController', ['$scope','UserService', function($scope,UserService){
        
}]);

fjcApp.controller('UserPageController', ['$scope','UserService', function($scope,UserService){
    init();
    function init(){
        $(".hsearchwp").addClass('hidden-search');
        UserService.getUser($scope);        
    }
        
}]);

fjcApp.controller('userCardController', ['$scope','ngDialog',function($scope,ngDialog){
//    console.log($scope.cardId);    
//    $rootScope.$on('ngDialog.opened', function (e, $dialog) {
//        enc_url = encodeURIComponent('https://www.facebook.com/sharer/sharer.php?u=https://yizkorwall.org/d/' + $scope.cardId);
//        $('.shareLink').attr('href', enc_url);
//    });
    
    $scope.share = function(card){
        window.open('https://www.facebook.com/sharer/sharer.php?u=https://yizkorwall.org/d/d.php?id=' + card.id, '_blank', 'height=300,width=600');
//        FB.ui({
//            method: 'share',
//            href: 'https://yizkorwall.org/d/d.php?id=' + card.id,
//        }, function(response){});
    };
}]);

fjcApp.controller('CardController', ['$scope','$sce','$http','$rootScope','ngDialog',function($scope,$sce,$http,$rootScope,ngDialog){
   $scope.openCard = function(cardId){
       $scope.cardId = cardId;
        //get user details!!
        ngDialog.open({ 
            template: 'userCard', 
            controller: 'userCardController',
            className: 'ngdialog-theme-plain',
            showClose: true,
            scope: $scope
        });
    }; 
    $rootScope.$on('ngDialog.opened', function (e, $dialog) {
//        theWaShBtn.crBtn();
    });        

    //$scope.getRandomSpan = function(){
    //    return Math.floor((Math.random()*5)+1);
    //};
    
    $scope.shareFB = function(cardId){ 
        window.open('https://www.facebook.com/sharer/sharer.php?u=https://yizkorwall.org/d/d.php?id=' + cardId, '_blank', 'height=300,width=600');
//        FB.ui({
//            method: 'share',
//            href: 'https://yizkorwall.org/d/d.php?id=' + cardId,
//        }, function(response){});
    };
    
    $scope.goFilter = function(value){
        $http.post('Controller/getUsers.php', {a:'search', s: value}).
        success(function(data, status, headers, config) {
//            console.log(data);
            $('.a-card').addClass('hide');
            $.each(data, function(){
                currId = this.id;
                $("#a-card_" + currId).removeClass('hide');
            });
        }).
        error(function(data, status, headers, config) {

        });
        //allNames = $('.card-name');
        //cVal = value.toLowerCase();
        //$.each(allNames, function(){
        //    cName = $(this).text().toLowerCase();
        //    $parTohide = $(this).parent().parent().parent();
        //    if(cName.indexOf(cVal) >= 0){//its ok
        //        $parTohide.removeClass('hide');
        //    }else{//hide this one
        //        $parTohide.addClass('hide');
        //    }
        //});
    };
}]);

fjcApp.controller('FormController', ['$scope','$http',function($scope,$http){
    $(".hsearchwp").addClass('hidden-search');    
    
    $scope.cc = [];
    $scope.cc_monthOptions = [
        {id:01, name:01},
        {id:02, name:02},
        {id:03, name:03},
        {id:04, name:04},
        {id:05, name:05},
        {id:06, name:06},
        {id:07, name:07},
        {id:08, name:08},
        {id:09, name:09},
        {id:10, name:10},
        {id:11, name:11},
        {id:12, name:12}
    ];
    $scope.cc.month = $scope.cc_monthOptions[1];
//    $scope.lovedForm = {cc_month : $scope.cc_monthOptions[0].id};
//    
    $scope.cc_yearsOptions= [];
    curr_year = new Date().getFullYear();
    min = parseInt(curr_year); //Make string input int
    max = parseInt(min + 10);
    countYe=0;
    for (var i=min; i<max; i++){
        $scope.cc_yearsOptions[countYe]={id:i,name:i};
        countYe++;
    }
    $scope.cc.year = $scope.cc_yearsOptions[1];
    
    $scope.donationsType = [
        {id:1, name:"Paypal"},
        {id:2, name:'Credit Card'}
    ];
        
    $scope.donTypeChange = function(elm){
        if(elm == 2){
            $('#ccdet').fadeIn();
            $('input[name=cc_number],input[name=cc_month],input[name=cc_year],input[name=cc_name],input[name=cc_code]').attr('required',true);
        }else{
            $('#ccdet').hide();
        }
    };
    
    $scope.submitLoved = function(){
        //check form before submit it
        allValid = $('.ng-valid-required');
        $.each(allValid, function(){
            if(this.type == 'text' || this.type == 'email'){
                $parDv = $(this).parent();
//                console.log($parDv);
                $parDv.css('background-color', '#FFF');
            }else if(this.type == 'radio'){
                $parDv = $(this).parent();
                $parDv.css('background-color', 'transparent');
            }
        });
        
        doSub=true;
        allInvalid = $('.ng-invalid-required, .ng-invalid-email');
        $.each(allInvalid, function(){
            if(this.type == 'text' || this.type == 'email'){
                $parDv = $(this).parent();
//                console.log($parDv);
                $parDv.css('background-color', '#F4C9C9');
            }else if(this.type == 'radio'){
                $parDv = $(this).parent();
                $parDv.css('background-color', '#F4C9C9');
            }
            doSub = false;
        });
        
        if (doSub) {
//            $scope.users[0].image = $scope.users[0].image
            var params = {
                lead: $scope.lead,
                donationsType:$scope.donT,
                cck:{
                    name:$scope.cc.name,
                    month:$scope.cc.month.id,
                    year:$scope.cc.year.id,
                    code:$scope.cc.secCode,
                    number:$scope.cc.number,
                    address1:$scope.cc.address1,
                    address2:$scope.cc.address2,
                    city:$scope.cc.city,
                    state:$scope.cc.state,
                    country:$scope.cc.country,
                    zip:$scope.cc.zip
                }
            };
            $(".loaderBack").fadeIn();
            $http.post('saveDonate.php', {p:params}).
            success(function(data, status, headers, config) {
//                console.log(data);
                if($scope.donT == 1){
                    alert("Thank you for your donation!");
                    window.location=data;
                }else{
                    alert("Something was wrong with the credit card. Check the credit card details again.");
                }
                $(".loaderBack").fadeOut();
            }).
            error(function(data, status, headers, config) {
                alert('OOOps, sorry but something goes wrong. Please try again.'); 
            });
        }
    }; 
}]);

fjcApp.filter('rangeYear', function() {
  return function(input) {
        curr_year = new Date().getFullYear();
        min = parseInt(curr_year); //Make string input int
        max = parseInt(min + 10);
        for (var i=min; i<max; i++)
          input.push(i);
        return input;
  };
});

fjcApp.filter('range', function() {
  return function(input, min, max) {
        min = parseInt(min); //Make string input int
        max = parseInt(max);
        for (var i=min; i<max; i++)
          input.push(i);
        return input;
  };
});

fjcApp.controller('FormLoveController', ['$scope','$filter','$sce','$compile','$http','$upload','ngDialog',function($scope,$filter,$sce,$compile,$http,$upload,ngDialog){
    $(".hsearchwp").addClass('hidden-search');
    $scope.myImage='';
    $scope.myCroppedImage='';
    $scope.file = '';
    $scope.dateOptions = {
        changeYear: true,
        changeMonth: true,
        yearRange: '1800:-0',
        dateFormat: 'mm/dd/yy',
        onSelect: function(dateText) {
            $scope.trustedGregDate = $sce.trustAsHtml(dateText);
            //check if the date is not today!
            var curdate = new Date();
            var userdate = new Date(dateText);
            
            var cday = curdate.getDate();
            var cmonth = curdate.getMonth();
            var cyear = curdate.getYear();
            
            var uday = userdate.getDate();
            var umonth = userdate.getMonth();
            var uyear = userdate.getYear();
            
            var getHebDate=true;
            if(uday == cday && umonth == cmonth && cyear == uyear){
                if (confirm('You choose today date. This is the right passing date?')) {
                    // right date ....
                } else {
                    // wrong date
                    getHebDate = false;
                    $scope.users[0].greg_date = '';
                }
            }
            if(userdate > curdate){
                alert('Passing date is wrong.');
                getHebDate = false;
                $scope.users[0].greg_date = '';
            }
            
            if(getHebDate){
                dateArr = dateText.split('/');
                //go get the hebrew date!!
                $http.get('getHebrewDate.php?cfg=json&gy=' + dateArr[2] + '&gm=' + dateArr[0] + '&gd=' + dateArr[1] + '&g2h=1').
                success(function(data, status, headers, config) {
                    arrayKey = $scope.users.length-1;
                    $scope.users[arrayKey].hebrew_date = data.hebrew;
    //                console.log($scope.users.length);
    //                console.log(data.events);
                }).
                error(function(data, status, headers, config) {

                });
            }
        }
    };
    
    $scope.submitLoved = function(){
        //check form before submit it
        allValid = $('.ng-valid-required');
        $.each(allValid, function(){
            if(this.type == 'text' || this.type == 'email'){
                parDv = $(this).parent();
                $(parDv).css('background-color', '#FFF');
            }else if(this.type == 'radio'){
                parDv = $(this).parent();
                $(parDv).css('background-color', 'transparent');
            }
        });
        
        doSub=true;
        allInvalid = $('.ng-invalid-required, .ng-invalid-email');
        $.each(allInvalid, function(){
            if(this.type == 'text' || this.type == 'email'){
                parDv = $(this).parent();
                $(parDv).css('background-color', '#F4C9C9');
            }else if(this.type == 'radio'){
                parDv = $(this).parent();
                $(parDv).css('background-color', '#F4C9C9');
            }
            doSub = false;
        });

        dateText = $scope.users[0].greg_date;

        //$scope.trustedGregDate = $sce.trustAsHtml(dateText);
        //check if the date is not today!
        var curdate = new Date();
        var userdate = new Date(dateText);

        var cday = curdate.getDate();
        var cmonth = curdate.getMonth();
        var cyear = curdate.getYear();

        var uday = userdate.getDate();
        var umonth = userdate.getMonth();
        var uyear = userdate.getYear();

        var getHebDate=true;
        if(uday == cday && umonth == cmonth && cyear == uyear){
            if (confirm('You choose today date. This is the right passing date?')) {
                // right date ....
            } else {
                // wrong date
                getHebDate = false;
                $scope.users[0].greg_date = '';

                doSub = false;
            }
        }
        
        if (doSub) {
//            $scope.users[0].image = $scope.users[0].image
            var params = {
                lead: $scope.lead,
                user:$scope.users,
                donationsTo:$scope.donationTo,
                donationsV:$scope.donationV,
                donationsType:$scope.donT,
                donationOther:$scope.donationOther,
                cck:{
                    name:$scope.cc.name,
                    month:$scope.cc.month.id,
                    year:$scope.cc.year.id,
                    code:$scope.cc.secCode,
                    number:$scope.cc.number,
                    address1:$scope.cc.address1,
                    address2:$scope.cc.address2,
                    city:$scope.cc.city,
                    state:$scope.cc.state,
                    country:$scope.cc.country,
                    zip:$scope.cc.zip
                }
            };
            $(".loaderBack").fadeIn();
            $http.post('saveLoved.php', {p:params}).
            success(function(data, status, headers, config) {
                //console.log(data);
                var dataURItoBlob = function(dataURI) {
                    var binary = atob(dataURI.split(',')[1]);
                    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
                    var array = [];
                    for(var i = 0; i < binary.length; i++) {
                      array.push(binary.charCodeAt(i));
                    }
                    return new Blob([new Uint8Array(array)], {type: mimeString});
                };
                //console.log($scope.myImage);
                //console.log($("#user_image").attr('src'));
                //console.log($("#user_image").attr('ng-src'));
                if($scope.myImage)
                    var file = dataURItoBlob($scope.myImage);
                //var file = $scope.file;
//                console.log(file);
                
                if($scope.donT == 1){
                    dataArr = data.split('-----');
                    uId = dataArr[0];
                    dataLocation = dataArr[1];
                    //window.location=data;
                }else{
                    if (data > 0) {
                        uId = data;
                        dataLocation = "/d/d.php?id=" + data;
                        //console.log($scope.donationV);
                        if($scope.donationV > 0){
                            alert("Thank you for your donation! You will be redirect to your Loved One page");
                        }else{
                            alert("Thank you for sharing your Loved One! You will be redirect to your Loved One page");
                        }
                    }else{
                        alert("Something was wrong with the credit card. Check the credit card details again.");
                    }
                    
                }
                if (file){
                    urlImg = 'uploadImg.php?id=' + uId;
                    $upload.upload({
                        url: urlImg,
                        file: file
                    }).progress(function (evt) {
                        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                        //console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                    }).success(function (data, status, headers, config) {                        
                        //console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
                        window.location=dataLocation;
                    });
                }else{
                    window.location=dataLocation;
                }
                $(".loaderBack").fadeOut();
            }).
            error(function(data, status, headers, config) {
                alert('OOOps, sorry but something goes wrong. Please try again.');    
            });
        }
    }; 
    $scope.cc = [];
    $scope.cc_monthOptions = [
        {id:01, name:01},
        {id:02, name:02},
        {id:03, name:03},
        {id:04, name:04},
        {id:05, name:05},
        {id:06, name:06},
        {id:07, name:07},
        {id:08, name:08},
        {id:09, name:09},
        {id:10, name:10},
        {id:11, name:11},
        {id:12, name:12}
    ];
    $scope.cc.month = $scope.cc_monthOptions[1];
//    $scope.lovedForm = {cc_month : $scope.cc_monthOptions[0].id};
//    
    $scope.cc_yearsOptions= [];
    curr_year = new Date().getFullYear();
    min = parseInt(curr_year); //Make string input int
    max = parseInt(min + 10);
    countYe=0;
    for (var i=min; i<max; i++){
        $scope.cc_yearsOptions[countYe]={id:i,name:i};
        countYe++;
    }
    $scope.cc.year = $scope.cc_yearsOptions[1];
//    $scope.lovedForm = {cc_year : $scope.cc_yearsOptions[0].value};
    
    $scope.users = [{
        fname: '',
        lname: '',
        hebrew_name: '',
        description: '',
        greg_date: '',
        hebrew_date: '',
        fileInput: '',
        image: ''
    }];

    $scope.donationsTo = [
        {id:1,name:"Where ever it's needed most"},
        {id:2,name:'Jewish Education'},
        {id:3,name:'Humanitarian Aid'},
        {id:4,name:'Children Homes'}
    ];
    
    $scope.donationsV = [
        {id:0,name:'Not now, thanks'},
        {id:18,name:"$18"},
        {id:36,name:'$36'},
        {id:100,name:'$100'},
        {id:9999,name:'Other',value:''}
    ];
    
    $scope.donationsType = [
        {id:1, name:"Paypal"},
        {id:2, name:'Credit Card'}
    ];
    
    $scope.donVChanged = function(elm){
        if(elm == 9999){
            $('#donV_other9999').show();
        }else{
            $('#donV_other9999').hide();
        }
    };
    
    $scope.donTypeChange = function(elm){
        if(elm == 2){
            $('#ccdet').fadeIn();
            $('input[name=cc_number],input[name=cc_month],input[name=cc_year],input[name=cc_name],input[name=cc_code]').attr('required',true);
        }else{
            $('#ccdet').hide();
        }
    };
    
    $scope.closeDropDialog=function(){
        $('.cropImageWP, .cropBackDialog').fadeOut();
        // so this is a blob image
        //save it as a blob long file in the db
        //maybe just call the ajax bellow to save the image....
        //console.log($scope.myImage);
    };
    
    $scope.upload = function (files) {
        if (files && files.length) {
            $('.cropImageWP, .cropBackDialog').show();
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                $upload.upload({
                    url: 'uploadImg.php',
                    file: file
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
//                    console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                }).success(function (data, status, headers, config) {
//                    console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
                });
            }
        }
    };
    
    $scope.fileNameChanged=function(elem, evt){
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            $('.cropImageWP, .cropBackDialog').show();
            
            $scope.file=evt.currentTarget.files[0];
            var reader = new FileReader();
            reader.onload = function (evt) {
              $scope.$apply(function($scope){
    //                    arrayKey = $scope.users.length-1;
//                        console.log(evt.target.result);
                    $scope.myImage=evt.target.result;
              });
            };
            reader.readAsDataURL($scope.file);
        } else {
            alert('The File APIs are not fully supported in this browser.');
        }
    };

    $scope.addFields = function () {
        $('.cropImageWP').hide();
        $scope.myImage='';
        $scope.myCroppedImage='';
    
        var newItemNo = $scope.users.length+1;
//        console.log(newItemNo);
        $imgC = $('img-crop');
//        console.log($imgC);
        $imgC.attr('result-image', 'myCroppedImage' + newItemNo);
        $scope.users.push({});
    };
    
//    $scope.close_plaquet = function(){
        $( ".add-loved_float_link" ).hide();
        $( ".add-loved_float" ).animate({
            width: '40px'
        }, 250, function() {
            $( ".close-plaquet" ).hide();
            $( ".open-arrow-plaquet" ).show();
        });
//    };
    
}]);

fjcApp.controller('EditController', ['$scope','$http','$routeParams','$sce','$upload','AdminService',function($scope,$http,$routeParams,$sce,$upload,AdminService){
    $scope.myImage='';
    $scope.myCroppedImage='';
    $scope.file = '';
      
    $scope.users = [{
        fname: '',
        lname: '',
        hebrew_name: '',
        description: '',
        greg_date: '',
        hebrew_date: '',
        fileInput: '',
        image: '',
        deleteImg: ''
    }];

    init();
    function init(){
        AdminService.checkLogIn($scope);
        user_id=$routeParams.id;
        $http.post('Controller/getUsers.php', {a:'getById', id: user_id}).
        success(function(data, status, headers, config) {
//            console.log(data);
//            consolconsolee.log(data[0].greg_date);
//            $scope.users[0] = data[0];
            $scope.users[0].fname = data[0].first_name;
            $scope.users[0].lname = data[0].last_name;
            $scope.users[0].hebrew_name = data[0].hname;
            $scope.users[0].description = data[0].dtext;
            $scope.users[0].greg_date = data[0].greg_date;
            $scope.users[0].hebrew_date = data[0].hebrew_date;
            $scope.users[0].image = data[0].dimg;
            $scope.myImage = data[0].dimg;
            $scope.myCroppedImage = data[0].dimg;
//            $scope.dUser = data[0];
        }).
        error(function(data, status, headers, config) {

        });
    }
    
    $scope.dateOptions = {
        changeYear: true,
        changeMonth: true,
        yearRange: '1800:-0',
        dateFormat: 'dd/mm/yy',
        onSelect: function(dateText) {
            $scope.trustedGregDate = $sce.trustAsHtml(dateText);
            dateArr = dateText.split('/');
            //go get the hebrew date!!
            $http.get('getHebrewDate.php?cfg=json&gy=' + dateArr[2] + '&gm=' + dateArr[1] + '&gd=' + dateArr[0] + '&g2h=1').
            success(function(data, status, headers, config) {
                arrayKey = $scope.users.length-1;
                $scope.users[arrayKey].hebrew_date = data.hebrew;
//                console.log($scope.users.length);
//                console.log(data.events);
            }).
            error(function(data, status, headers, config) {

            });
        }
    };
    
    $scope.submitLoved = function(){
        //check form before submit it
        allValid = $('.ng-valid-required');
        $.each(allValid, function(){
            if(this.type == 'text' || this.type == 'email'){
                parDv = $(this).parent();
                $(parDv).css('background-color', '#FFF');
            }else if(this.type == 'radio'){
                parDv = $(this).parent();
                $(parDv).css('background-color', 'transparent');
            }
        });
        
        doSub=true;
        allInvalid = $('.ng-invalid-required, .ng-invalid-email');
        $.each(allInvalid, function(){
            if(this.type == 'text' || this.type == 'email'){
                parDv = $(this).parent();
                $(parDv).css('background-color', '#F4C9C9');
            }else if(this.type == 'radio'){
                parDv = $(this).parent();
                $(parDv).css('background-color', '#F4C9C9');
            }
            doSub = false;
        });
        
        if (doSub) {
//            $scope.users[0].image = $scope.users[0].image
            var params = {
                user:$scope.users
            };
            //console.log(params);
            //return;
            $http.post('editLoved.php', {p:params, user_id: $routeParams.id}).
            success(function(data, status, headers, config) {
                if(params.user[0].deleteImg){
                    //just remove the img from the view
                    $scope.user.image = '';
                }

                var dataURItoBlob = function(dataURI) {
                    var binary = atob(dataURI.split(',')[1]);
                    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
                    var array = [];
                    for(var i = 0; i < binary.length; i++) {
                      array.push(binary.charCodeAt(i));
                    }
                    return new Blob([new Uint8Array(array)], {type: mimeString});
                };
//                console.log($scope.myImage);
                if($scope.myImage){
                    var file = dataURItoBlob($scope.myImage);
                    //var file = $scope.file;
                    if (data > 0) {
                        uId = $routeParams.id;
                        dataLocation = "/d/d.php?id=" + data;
                    }else{
                        alert("Something was wrong");
                    }    

                    if (data > 0 && file){
                        urlImg = 'uploadImg.php?id=' + uId;
                        $upload.upload({
                            url: urlImg,
                            file: file
                        }).progress(function (evt) {
                            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
//                            console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                        }).success(function (data, status, headers, config) {                        
//                            console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
//                            window.location=dataLocation;
                            alert("The changes were saved succesfuly");
                        });
                    }
                }else{
                    alert("The changes were saved succesfuly");
                }
            }).
            error(function(data, status, headers, config) {
                alert('OOOPS, sorry but something goes wrong. Please try again.');    
            });
        }
    }; 

    $scope.closeDropDialog=function(){
        $('.cropImageWP, .cropBackDialog').fadeOut();
        // so this is a blob image
        //save it as a blob long file in the db
        //maybe just call the ajax bellow to save the image....
//        console.log($scope.myImage);
    };
    
    $scope.upload = function (files) {
        if (files && files.length) {
            $('.cropImageWP, .cropBackDialog').show();
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                $upload.upload({
                    url: 'uploadImg.php',
                    file: file
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
//                    console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                }).success(function (data, status, headers, config) {
//                    console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
                });
            }
        }
    };
    
    $scope.fileNameChanged=function(elem, evt){
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            $('.cropImageWP, .cropBackDialog').show();
            
            $scope.file=evt.currentTarget.files[0];
            var reader = new FileReader();
            reader.onload = function (evt) {
              $scope.$apply(function($scope){
    //                    arrayKey = $scope.users.length-1;
//                        console.log(evt.target.result);
                    $scope.myImage=evt.target.result;
              });
            };
            reader.readAsDataURL($scope.file);
        } else {
            alert('The File APIs are not fully supported in this browser.');
        }
    };  
}]);

fjcApp.service('AdminService', ['$cookieStore','$cookies','$http','$sce','$routeParams', function($cookieStore,$cookies,$http,$sce,$routeParams){
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
    return service;
}]);

fjcApp.service('UserService', ['$cookieStore','$cookies','$http','$sce','$routeParams' ,'ngDialog', function($cookieStore,$cookies,$http,$sce,$routeParams,ngDialog){
    var service = {};
    
    service.getAllUsers = function($scope){
        $http.post('Controller/getUsers.php', {a:'getAll'}).
        success(function(data, status, headers, config) {
//            console.log(data);
            $scope.AllUsers = data;
        }).
        error(function(data, status, headers, config) {

        });
    };
    
    id=$routeParams.id;
    service.getUser = function($scope){
        $http.post('Controller/getUsers.php', {a:'getById', id: id}).
        success(function(data, status, headers, config) {
//            console.log(data);
            $scope.dUser = data[0];
            $("meta[property='og\\:title']").attr("content", 'Yizkor - ' + $scope.dUser.first_name);
            $("meta[property='og\\:url']").attr("content", 'https://www.facebook.com/sharer/sharer.php?u=https://yizkorwall.org/%23/d/' + $scope.dUser.id);
            $("meta[property='og\\:image']").attr("content", $scope.dUser.dimg);
        }).
        error(function(data, status, headers, config) {

        });
    };
    return service;
}]);
 