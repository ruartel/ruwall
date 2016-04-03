<!DOCTYPE html>
<html lang="en" ng-app="fjcApp" class="full">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>Yizkor Memorial Wall</title>
        <link rel="canonical" href="https://yizkorwall.org/" />
        <link rel="shortcut icon" href="favicon.png">
        <link rel="publisher" href="https://plus.google.com/110834021161254801277"/>
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Yizkor Memorial Wall" />
        <meta property="og:description" content="I decided to honor someone near and dear to my heart by creating a memorial plaque on the Yizkor Memorial Wall. Click here to view it." />
        <meta property="og:url" content="https://yizkorwall.org/" />
        <meta property="og:site_name" content="The Federation of Jewish Communties of the CIS" />
        <meta property="article:publisher" content="http://www.facebook.com/FJCofCIS" />
        <meta property="og:image" content="https://yizkorwall.org/images/star.png" />
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:description" content="Just like the Hebrew Yizkor prayer, our site offers a way to remember the ones we have lost,  to ask God to bless their spirits, and elevate their souls with an act of charity.  Continue reading &rarr;"/>
        <meta name="twitter:title" content="Yizkor Memorial Wall"/>
        <meta name="twitter:site" content="@FJCofCIS"/>
        <meta name="twitter:domain" content="The Federation of Jewish Communties of the CIS"/>
        <meta name="twitter:image:src" content="https://fjc.ru/wp-content/uploads/2014/09/site.jpg"/>
        <meta name="twitter:creator" content="@FJCofCIS"/>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="js/ngDialog/css/ngDialog.css">
        <link rel="stylesheet" href="js/ngDialog/css/ngDialog-theme-default.css">
	<link rel="stylesheet" href="js/ngDialog/css/ngDialog-theme-plain.css">
        <link rel="stylesheet" href="js/ngImgCrop-master/compile/minified/ng-img-crop.css">
        <link rel="stylesheet" href="js/jquery-ui-1.11.3.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="js/jquery-ui-1.11.3.custom/jquery-ui.theme.css">
<!--        <link rel="stylesheet" href="js/angular-datepicker/dist/index.css">-->
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <?php include_once("google-tracking.php") ?>
        <div id="fb-root"></div>
        <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '392707330890535',
            xfbml      : true,
            version    : 'v2.2'
          });
        };

        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "//connect.facebook.net/en_US/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
      </script>
        <header class="col-md-12">
            <div class="col-md-12 header_backwp">
                <div class="container">
                    <div class="col-md-12 header_logos">
                        <div class="col-md-3 logo"><a href="#/"><img src="images/logo3.png" class="img-responsive"></a></div>
                        <div class="col-md-9">
                            <div class="row header-top-row">
                                <div class="col-md-3 hbtnwp"><a href="#/add-loved-one" class="header_btn">Add a Loved One</a></div>
                                <div class="col-md-5">
                                    <div class="col-md-4 col-md-offset-2 hlinkwp"><a href="#/about" class="header_link">About FJC</a></div>
                                    <div class="col-md-1 linebtwa"></div>
                                    <div class="col-md-5 hlinkwp"><a href="#/donate" class="header_link">Donate to FJC</a></div>
                                </div>
                                <div class="col-md-4 hsearchwp">
                                    <input type="text" placeholder="search" class="search_input" ng-controller="CardController" ng-model="filters" ng-change="goFilter(filters);">
                                </div>
                            </div>
                            <div class="row header-bot-row">
                                <div class="col-md-10 header_about_txt">
                                    <div>Welcome to ‘Yizkor’! The FJC’s International online Memorial Wall – a place to commemorate our beloved ones,</div>
                                    <div>by easily creating and sharing a beautiful viral plaque in their memory. <a href="#/yizkor"class="continue-link">Continue reading ></a></div>
                                </div>
                                <div class="col-md-2 fbLike_wrap">
                                    <a href="https://www.facebook.com/FJCofCIS" class="fb_btn" target="_blank">
                                        <img src="images/facebook.png">
                                    </a>
                                </div>
                            </div> 
                        </div>                                       
                    </div>
                </div> 
            </div>
        </header>
        <div id="viewContainer" class="container view-slide-in" ng-view></div>
        <script type="text/ng-template" id="userCard">
            <div class="ngdialog-message" id="user_dialog">
                <div class="ud_wp">
                    <div class="dFlex ud_wp_in">
                        <div class="ud_left">
                            <div class="ud_entitle">{{card.first_name}} {{card.last_name}}</div>
                            <div class="ud_hebtitle">{{card.hname}}</div>
                            <hr class="ud_hr">
                            <div class="ud_txt">{{card.dtext}}</div>
                        </div>
                        <div class="ud_right">
                            <div class="ud_imgDV">
                                <img src="" data-ng-src="admin/imageView.php?image_id={{card.id}}" class="ud-img">
                            </div>
                        </div>
                    </div>
                    <div class="ud_bottom">
                        <div class="ud_date">{{card.american_greg_date}}</div>
                        <div class="ud_hebdate">{{card.hebrew_date}}</div>
                        <div class="ud_tn">ת.נ.צ.ב.ה</div>
                        <div class="ud_share shareToOpen">
                            <div>Share the memory</div>
                            <div class="dFlex social_wp">
                                <div class="social_icon fb_icon" ng-click="shareFB(card.id);"></div>
                                <div class="social_icon twitter_icon">
                                    <a href="https://twitter.com/share?url=https://yizkorwall.org/d/d.php?id={{card.id}}" target="_blank" class='tweet_link'>Tweet</a>
                                </div>
                                <div class="social_icon email_icon"><a href="mailto:me@me.com?subject=Yizkor-{{card.first_name}}%20{{card.last_name}}&body=Yizkor-{{card.first_name}}%20{{card.last_name}}%20http%3A%2F%2Fyizkorwall.com%2Fd%2Fd.php%3Fid%3D{{card.id}}">EMAil</a></div>
//                                <a href="whatsapp://send" data-text="Yizkor" data-href="" style="display:none;" class="wa_btn wa_btn_s">Share</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	</script>
        <div class="add-loved_float" ng-controller="left-plaquet">
            <div class="close-plaquet" ng-click="close_plaquet()">x</div>
            <div class="open-arrow-plaquet" ng-click="open_plaquet()">&#10096;</div>
            <a href="#/add-loved-one" class="add-loved_float_link">Click here NOW to create a plaque</a>
        </div>
        <footer>
            <div class="container">
                &copy; 2012-<?php echo date("Y");  ?> Yizkor Wall. All Rights Reserved. <div class="orAvnerCr"></div>
                <span><a href="http://www.gla-solutions.com/" target="_blank">GLA- Fundraising & System Information</a></span>
            </div>
	</footer>
        <div class="fixedBackground"></div>
        <div class="loaderBack"></div>
        <script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.11.3.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="js/angular.min.js" type="text/javascript"></script>
        <script src="js/angular-route.js" type="text/javascript"></script>
        <script src="js/angular-cookies.js" type="text/javascript"></script>
        <script src="js/ngDialog/js/ngDialog.min.js" type="text/javascript"></script>
        <!--<script src="js/ngFlowGrid-master/src/ngFlowGrid.js"></script>-->
        <script src="js/angular-deckgrid/angular-deckgrid.js"></script>
        <script src="js/ngImgCrop-master/compile/minified/ng-img-crop.js"></script>
        <script src="js/angular-file-upload-master/dist/angular-file-upload-shim.min.js"></script>
        <script src="js/angular-file-upload-master/dist/angular-file-upload.min.js"></script>
        <script src="js/ui-date/src/date.js"></script>
        <script src="js/routing.js" type="text/javascript"></script>
        <script src="js/controllers.js" type="text/javascript"></script>
        <!--<script src="js/whatsapp-sharing-1.2.3/dist/whatsapp-button.js" type="text/javascript"></script>-->
        <!--<script type="text/javascript">if(typeof wabtn4fg==="undefined"){wabtn4fg=1;h=document.head||document.getElementsByTagName("head")[0],s=document.createElement("script");s.type="text/javascript";s.src="js/whatsapp-sharing-1.2.3/dist/whatsapp-button.js";h.appendChild(s);}</script>-->
    </body>
</html>
