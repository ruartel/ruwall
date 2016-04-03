<?php
require_once '../meekrodb.2.3.class.php';
require_once '../Controller/User.php';

if(isset($_GET['id'])){
    $cId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    if($cId){
        $user = new User();
        $uDetails = $user->getUserById($cId);
        $d = $uDetails[0];
    }    
}else{
    #404 error
    header('location');
}


?>
<!DOCTYPE html>
<html lang="en" ng-app="fjcApp" class="full">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.png">
        <title>Yizkor Memorial Wall - <?php echo $d['first_name'] . ' ' . $d['last_name']; ?> OBM</title>
        <link rel="canonical" href="https://yizkorwall.org" />
        <link rel="publisher" href="https://plus.google.com/110834021161254801277"/>
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?php echo $d['first_name'] . ' ' . $d['last_name']; ?> OBM" />
        <meta property="og:description" content="‘Yizkor’ International Memorial Wall - Easily commemorate your loved ones" />
        <meta property="og:url" content="https://yizkorwall.org/d/d.php?id=<?php echo $d['id']; ?>" />
        <meta property="og:site_name" content="The Federation of Jewish Communties of the CIS" />
        <meta property="article:publisher" content="http://www.facebook.com/FJCofCIS" />
        <meta property="og:image" content="<?php if($d['dimg']) echo $d['dimg']; else echo "/images/star.png"; ?>" />
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:description" content="Just like the Hebrew Yizkor prayer, our site offers a way to remember the ones we have lost,  to ask God to bless their spirits, and elevate their souls with an act of charity.  Continue reading &rarr;"/>
        <meta name="twitter:title" content="Yizkor Memorial Wall"/>
        <meta name="twitter:site" content="@FJCofCIS"/>
        <meta name="twitter:domain" content="The Federation of Jewish Communties of the CIS"/>
        <meta name="twitter:image:src" content="https://fjc.ru/wp-content/uploads/2014/09/site.jpg"/>
        <meta name="twitter:creator" content="@FJCofCIS"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../js/ngDialog/css/ngDialog.css">
        <link rel="stylesheet" href="../js/ngDialog/css/ngDialog-theme-default.css">
	<link rel="stylesheet" href="../js/ngDialog/css/ngDialog-theme-plain.css">
        <link rel="stylesheet" href="../js/ngImgCrop-master/compile/minified/ng-img-crop.css">
        <link rel="stylesheet" href="../js/jquery-ui-1.11.3.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="../js/jquery-ui-1.11.3.custom/jquery-ui.theme.css">
<!--        <link rel="stylesheet" href="js/angular-datepicker/dist/index.css">-->
        <link rel="stylesheet" href="../css/main.css">
    </head>
    <body>
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
                        <div class="col-md-3 logo"><a href="/#/"><img src="/images/logo3.png" class="img-responsive"></a></div>
                        <div class="col-md-9">
                            <div class="row header-top-row">
                                <div class="col-md-3 hbtnwp"><a href="/#/add-loved-one" class="header_btn">Add a Loved One</a></div>
                                <div class="col-md-5">
                                    <div class="col-md-4 col-md-offset-2 hlinkwp"><a href="/#/about" class="header_link">About FJC</a></div>
                                    <div class="col-md-1 linebtwa"></div>
                                    <div class="col-md-5 hlinkwp"><a href="/#/donate" class="header_link">Donate to FJC</a></div>
                                </div>
                                <div class="col-md-4 hsearchwp">
                                    <input type="text" placeholder="search" class="search_input" ng-controller="CardController" ng-model="filters" ng-change="goFilter(filters);">
                                </div>
                            </div>
                            <div class="row header-bot-row">
                                <div class="col-md-10 header_about_txt">
                                    <div>Welcome to ‘Yizkor’! The FJC’s International online Memorial Wall – a place to commemorate our beloved ones,</div>
                                    <div>by easily creating and sharing a beautiful viral plaque in their memory. <a href="/#/yizkor"class="continue-link">Continue reading ></a></div>
                                </div>
                                <div class="col-md-2 fbLike_wrap">
                                    <a href="https://www.facebook.com/FJCofCIS" class="fb_btn" target="_blank">
                                        <img src="/images/facebook.png">
                                    </a>
                                </div>
                            </div> 
                        </div>                                       
                    </div>
                </div> 
            </div>
        </header>
      <div class="container dContainer">
          <div class="col-md-12 right-page">
              <div class="ngdialog-content card-wp dpageCardWP" style="margin: 0 auto;">
                <div class="ngdialog-message card-wp">
                    <div class="ud_wp">                    
                        <div class="dFlex">
                            <div class="ud_left">
                                <div class="ud_entitle"><?php echo $d['first_name']; ?> <?php echo $d['last_name']; ?></div>
                                <div class="ud_hebtitle"><?php echo $d['hname']; ?></div>
                                <hr class="ud_hr">
                                <div class="ud_txt"><pre><?php echo $d['dtext']; ?></pre></div>
                            </div>
                            <div class="ud_right">
                                <div class="ud_imgDV">
                                    <img src="<?php echo $d['dimg']; ?>" class="ud-img">
                                </div>
                            </div>
                        </div>
                        <div class="ud_bottom">
                            <div class="ud_date"><?php echo $d['greg_date']; ?></div>
                            <div class="ud_hebdate"><?php echo $d['hebrew_date']; ?></div>
                            <div class="ud_tn">ת.נ.צ.ב.ה</div>
                            <div class="ud_share">
				<div>Share the memory</div>
				<div class="dFlex social_wp">
				    <div class="social_icon fb_icon" onclick="share(<?php echo $d['id']; ?>)"></div>
				    <div class="social_icon twitter_icon">
					<a href="https://twitter.com/share?url=https://yizkorwall.org/d/d.php?id=<?php echo $d['id']; ?>" target="_blank">Tweet</a>
				    </div>
				    <div class="social_icon email_icon"><a href="mailto:me@me.com?subject=Yzkor-<?php echo $d['first_name']; ?>+<?php echo $d['last_name']; ?>&body=https://yizkorwall.org/d/d.php?id%3D<?php echo $d['id']; ?>">EMAil</a></div>
				</div>    
			    </div>
                        </div>
                    </div>    
                </div>
            </div> 
        </div>
      </div>
      <footer></footer>
        <div class="fixedBackground"></div>
        <script src="../js/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../js/jquery-ui-1.11.3.custom/jquery-ui.min.js" type="text/javascript"></script>
    </body>
    <script type="text/javascript">
    function share(id){
        window.open('https://www.facebook.com/sharer/sharer.php?u=https://yizkorwall.org/d/d.php?id=' + id, '_blank', 'height=300,width=600');
//        FB.ui({
//            method: 'share',
//            href: 'https://yizkorwall.org/d/d.php?id=' + id,
//        }, function(response){});
    }
    </script>
</html>

