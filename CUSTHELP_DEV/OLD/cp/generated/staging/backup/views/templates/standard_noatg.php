<!DOCTYPE html>
<html lang="#rn:language_code#">
<head class="no-js">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; user-scalable=no; minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <title>Contact Us | FAQs</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--[if lt IE 9]><script type="text/javascript" src="/euf/rightnow/html5.js"></script><![endif]-->
    <rn:widget path="search/BrowserSearchPlugin" pages="home, answers/list, answers/detail" />
    <rn:theme path="/euf/assets/themes/standard" css="
					{YUI}/widget-stack/assets/skins/sam/widget-stack.css,
					{YUI}/widget-modality/assets/skins/sam/widget-modality.css,
					{YUI}/overlay/assets/overlay-core.css,
					{YUI}/panel/assets/skins/sam/panel.css,
					site.css" />
    <rn:head_content/>
    <link rel="shortcut icon" href="https://www.virginamerica.com/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/euf/assets/themes/standard/header.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
       <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
       <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

</head>
<body class="yui-skin-sam yui3-skin-sam">

<script type="text/javascript">
  function toggleLinks(id) {
    var e = document.getElementById(id);
    var body = document.getElementById('rn_Body');
    var ele = document.querySelector("#vx-wrapper");
    if (e.style.display == 'block') {
      e.style.display = 'none';
      body.style.display = 'block';
      ele.style.backgroundColor = 'transparent';     
    }
    else {
      e.style.display = 'block';
      body.style.display = 'none';
      ele.style.backgroundColor = "#DF1A2D";
    }
  }
</script>

<div id="rn_Container" >
    <div id="rn_SkipNav"><a href="#rn_MainContent">#rn:msg:SKIP_NAVIGATION_CMD#</a></div>
    <div id="rn_Header" role="banner">
    <noscript><h1>#rn:msg:SCRIPTING_ENABLED_SITE_MSG#</h1></noscript>

    <!--    <div id="rn_Logo"><a href="/app/#rn:config:CP_HOME_URL##rn:session#"><span class="rn_LogoTitle">#rn:msg:SUPPORT_LBL# <span class="rn_LogoTitleMinor">#rn:msg:CENTER_LBL#</span></span></a></div> -->

        <header role="banner" class="banner">
            <h1 class="navbar__logo">
                <a href="https://www.virginamerica.com/">Virgin America</a>
            </h1>
            <nav class="navbar__main cf">
                <ul class="navlist--main cf">
                    <li><a href="https://www.virginamerica.com/cms/book-travel">Book</a></li>
                    <li><a href="https://www.virginamerica.com/flight-check-in">Check In</a></li>
                    <li><a href="https://www.virginamerica.com/manage-itinerary">Manage</a></li>
                </ul>
                <ul class="navlist--sub cf">
                    <li><a href="https://www.virginamerica.com/cms/travel-deals">Deals</a></li>
                    <li><a href="https://www.virginamerica.com/cms/fly-with-us">Flying With Us</a></li>
                    <li><a href="https://www.virginamerica.com/cms/airport-destinations">Where We Fly</a></li>
                    <li><a href="https://www.virginamerica.com/cms/vx-fees" target="">Fees</a></li>
                    <li><a href="https://www.virginamerica.com/check-flight-status">Flight Status</a></li>
                    <li><a href="https://www.virginamerica.com/get-flight-alerts">Flight Alerts</a></li>
                </ul>
            </nav>
            <div class="navbar__right cf">
                <div class="navbar__expand-nav">
                    <a href="#" class="expand-nav icon-nav-toggle">Nav</a>
                </div>
                <div class="navbar__elevate-nav">
                    <span class="elevate-nav--logged-out cf">
                        <a href="https://www.virginamerica.com/cms/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--about icon-elevate-small">About Elevate</a>
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--sign-in icon-elevate-small">Sign In</a>
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer/sign-up" class="elevate-nav__link" ng-show="header.breakpoint !== 'small'">Sign Up</a>
                    </span>
                </div>
                <div class="navbar__elevate-nav is-close">
                    <a href="#" class="elevate-nav--close icon-close-light-white"></a>
                </div>
            </div>
            <nav class="nav-dropdown is-hidden">
                <div class="nav-expanded">
                    <ul class="nav-expanded__list">
                        <li>
                            <a href="https://www.virginamerica.com/">Home</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/cms/book-travel">Book</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/flight-check-in">Check In</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/manage-itinerary">Manage</a>
                        </li>
                    </ul>
                    <ul class="nav-expanded__list--sub">
                        <li><a href="https://www.virginamerica.com/cms/travel-deals">Deals</a></li>
                        <li><a href="https://www.virginamerica.com/cms/fly-with-us">Flying With Us</a></li>
                        <li><a href="https://www.virginamerica.com/cms/airport-destinations">Where We Fly</a></li>
                        <li><a href="https://www.virginamerica.com/cms/vx-fees">Fees</a></li>
                        <li><a href="https://www.virginamerica.com/check-flight-status">Flight Status</a></li>
                        <li><a href="https://www.virginamerica.com/get-flight-alerts">Flight Alerts</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="rn_LoginStatus">
            <rn:condition logged_in="true">
                 #rn:msg:WELCOME_BACK_LBL#
                <strong>
                    <rn:field name="contacts.full_name"/>
                </strong>
                <div>
                    <rn:field name="contacts.organization_name"/>
                </div>
                <rn:widget path="login/LogoutLink2"/>
            <rn:condition_else />
                <rn:condition config_check="PTA_ENABLED == true">
                    <a href="javascript:void(0);" id="rn_LoginLink">#rn:msg:LOG_IN_LBL#</a>&nbsp;|&nbsp;<a href="javascript:void(0);">#rn:msg:SIGN_UP_LBL#</a>
                <rn:condition_else>
                    <a href="javascript:void(0);" id="rn_LoginLink">#rn:msg:LOG_IN_LBL#</a>&nbsp;|&nbsp;<a href="/app/utils/create_account#rn:session#">#rn:msg:SIGN_UP_LBL#</a>
                    <rn:condition hide_on_pages="utils/create_account, utils/login_form, utils/account_assistance">
                        <rn:widget path="login/LoginDialog2" trigger_element="rn_LoginLink" open_login_url="/app/#rn:config:CP_LOGIN_URL#" label_open_login_link="#rn:msg:LOG_EXISTING_ACCOUNTS_LBL# <span class='rn_ScreenReaderOnly'>(Facebook, Twitter, Google, OpenID) #rn:msg:CONTINUE_FOLLOWING_FORM_LOG_CMD#</span>"/>
                    </rn:condition>
                    <rn:condition show_on_pages="utils/create_account, utils/login_form, utils/account_assistance">
                        <rn:widget path="login/LoginDialog2" trigger_element="rn_LoginLink" redirect_url="/app/account/overview" open_login_url="/app/#rn:config:CP_LOGIN_URL#" label_open_login_link="#rn:msg:LOG_EXISTING_ACCOUNTS_LBL# <span class='rn_ScreenReaderOnly'>(Facebook, Twitter, Google, OpenID) #rn:msg:CONTINUE_FOLLOWING_FORM_LOG_CMD#</span>"/>
                    </rn:condition>
                </rn:condition>
            </rn:condition>
        </div>
    </div>
    <div id="rn_Body">
        <div id="rn_MainColumn" role="main">
            <a id="rn_MainContent"></a>
            <rn:page_content/>
        </div>
<!--
        <rn:condition hide_on_pages="app/ask">
        <div id="rn_SideBar" role="navigation">
            <div class="rn_Padding">
                <div class="rn_Module">
                  <h2>Top 10 Questions</h2>
                    <rn:widget path="reports/Multiline2" report_id="194" per_page="10"/>
                </div>
            </div>
        </div>
        </rn:condition>
-->

    </div>

    <div id="rn_Footer" role="contentinfo">
<!--
        <div id="rn_RightNowCredit">
            <div class="rn_FloatRight">
                <rn:widget path="utils/RightNowLogo"/>
            </div>
        </div> -->

        <footer class="vx-footer">
            <div class="vx-wrap desktop">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                </ul>
                <ul>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>

            <div class="vx-wrap tablet">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>        
                    
            <div class="vx-wrap mobile">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>

            <p class="copyright">© 2014 Virgin America</p>
        </footer>
    </div>
</div>

      <footer role="contentinfo">
            <div class="wrap">
                <div class="footer-wrap">
                    <nav class="footer-nav cf">
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/sitemap">Sitemap</a></li>
                            <li class="footer-nav__item"><a href="http://virginamerica.custhelp.com/">Contact Us/FAQs</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline">About Us</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline/press">Press</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/blog">Blog</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/airline-jobs">Careers</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel">Corporate &amp; Group Travel</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel/travel-agents">Travel Agents</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/guest-service-commitment">Guest Service Commitment</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/contract-of-carriage.pdf">Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/international-contract-of-carriage.pdf">Int’l Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-responsibility">Corporate Responsibility</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="http://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGmAt9ur9biu27Jh9e9uzfeDcCi8SonfVXMtX%3DWQpglLjHJlYQGruK1w1EzbazdUdEGG6gmlazdJwoNGDzbf&_ei_=EmSL9xUrhFrGHt6VuHz0Fpo">Email Unsubscribe</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/privacy-policy">Privacy Policy</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/travel-guard">Travel Insurance</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/news">All News &amp; Updates</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/elevate-frequent-flyer">What Is Elevate?</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/elevate-frequent-flyer/credit-card">Virgin America Credit Card</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/advertise-onboard">Advertise Onboard</a></li>
                            <li class="footer-nav__item"><a href="https://plus.google.com/+VirginAmerica/" target="_blank" rel="publisher">Google+</a></li>
                        </ul>
                        <ul class="footer-nav__list is-omega">
                            <li class="footer-nav__item"><a href="http://instagram.com/virginamerica" target="_blank" rel="me">Instagram</a></li>
                            <li class="footer-nav__item"><a href="https://twitter.com/VirginAmerica" target="_blank" rel="me">Twitter</a></li>
                            <li class="footer-nav__item"><a href="https://www.facebook.com/VirginAmerica" target="_blank" rel="me">Facebook</a></li>
                            <li class="footer-nav__item"><a href="https://www.youtube.com/user/VirginAmerica" target="_blank" rel="me">YouTube</a></li>
                        </ul>
                    </nav>
                    <div class="footer-copy">
                        &copy; 2014 Virgin America
                    </div>
                </div>
            </div>
        </footer>

        <script>
	        //document.body.scrollTop = document.documentElement.scrollTop = 0;
        /*  var $jq = jQuery.noConflict(true);

		  jQuery( document ).ready(function() {
                $dropdown = $('.nav-dropdown')
                $('.navbar__expand-nav').on('click', 'a', function (e) {
                    e.preventDefault();
                    $dropdown.toggleClass('is-hidden');
                    $('body').toggleClass('is-modal-open');
                    $('.banner').toggleClass('is-nav-expanded-active');
                });

                var getDeviceWindowHeight = function () {
                  var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
                  return window.innerHeight * zoomLevel;
                }

                var applyWinHeight = function () {
                  $dropdown.css(
                    'height',
                    (getDeviceWindowHeight() - 54) + 'px'
                  );
                };

                applyWinHeight();

                $(window).resize(function () {
                    applyWinHeight();
                });
            })(); */
        </script>
        
       
</body>
</html>
