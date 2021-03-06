<rn:meta title="#rn:msg:SHP_TITLE_HDG#" template="standard.php" clickstream="home"/>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">   <!-- Required by iPhone 5 -->

<!-- TagMan BootStrap -->
<script type="text/javascript">
   var webData = {
      pageName: "Contact Us",
      siteSection: 'Contact Us',
      servEnv: 'Oracle'
   }
   window.tmParam = {};
   (function(d,s){
      var client = 'virginamerica';
      var siteId = 20;
      //  do not edit
      var a=d.createElement(s),b=d.getElementsByTagName(s)[0];
      a.async=true;a.type='text/javascript';
      a.src='//sec.levexis.com/clients/'+client+'/'+siteId+'.js';
      a.tagman='st='+(+new Date())+'&c='+client+'&sid='+siteId;
      b.parentNode.insertBefore(a,b);
   })(document,'script');
</script>


<script type="text/javascript">

function go_ContactForm(id) {
  RightNow.Url.navigate("/app/ask/incidents.c$typeofquestion/"+id, false);
}

function go_Question(id) {
  RightNow.Url.navigate("/app/answers/detail/a_id/"+id, false);
}

function go_DirectUrl(url) {
  RightNow.Url.navigate(url, false);
}

function goto_EmailTopic() {

  var radios = document.getElementsByName('rn_Radio');
  var radio_value;
  for (var i = 0; i < radios.length; i++) {
     if (radios[i].checked) {
        radio_value = Number(radios[i].value);
        break;
     }
  }
  switch(radio_value) {
    case 1: go_DirectUrl('https://virginamericareservations.custhelp.com/app/elevate');
            break;
    case 2: go_ContactForm(1858);
            break;
    case 3: go_ContactForm(1859); 
            break;
    case 4: go_DirectUrl('https://virginamericareservations.custhelp.com/app/reservation'); 
            break;
    case 5: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/686');
            break;
    case 6: go_DirectUrl('https://virginamericareservations.custhelp.com/app/bestfare'); 
            break;
    case 7: go_Question(221); 
            break;
    case 8: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/665'); 
            break;
    case 9: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/140');
            break;
    case 10: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/153'); 
            break;
    case 11: go_ContactForm(1960); 
            break;
  }
}


function toggleLinks(id) {
  var e = document.getElementById(id);
  var body = document.getElementById('rn_Body');
  var ele = document.querySelector("#vx-wrapper");
  var border = document.querySelector("#rn_Header > header");
  var minus = document.querySelector("#rn_Header > header > div > div.vx-bars-container");
  if (e.style.display == 'block') {
    e.style.display = 'none';
    body.style.display = 'block';
    ele.style.backgroundColor = 'transparent';
    border.style.borderBottom = '0px';
    minus.style.borderBottom = '1px solid #FFF';
  }
  else {
    e.style.display = 'block';
    body.style.display = 'none';
    ele.style.backgroundColor = "#DF1A2D";
    border.style.borderBottom = '1px solid #5F2969';
    minus.style.borderBottom = '1px solid #DF1A2D';   /* Needs to be a few pixels longer */
  }
}

function closeModal(elem) {
	alert("in here");
	document.getElementById(elem).hide();
}
</script>

   <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />

    <div id="rn_PageTitle" class="rn_Home"></div>
  
    <div class="rn_Module">
	        
        <h1 style="text-align: center;">Contact Us </h1>
        <div>
          <rn:widget path="custom/display/CustomInfoButton" label_button="" is_link="false" target="myCallDiv" />
   <!-- Remove the comment surrounding the next line to display Chat -->
   <!--       <rn:widget path="custom/util/CustomInfoButton" label_button="Chat" target="/chat/chat_landing" is_link="true" /> -->
          <rn:widget path="custom/display/CustomInfoButton" label_button="" is_link="false" target="myEmailDiv" />
          <rn:widget path="custom/display/CustomInfoButton" label_button="" is_link="true" target="https://www.twitter.com/VirginAmerica" />
		  
          	<rn:widget path="custom/display/CustomInfoButton" label_button="" is_link="true" target="http://virginamericareservations.custhelp.com/app/chat/chat_invite" />
			 
		 
        </div>
    </div>

    <div id="rn_PageContent" class="rn_Home">
     
        <div id="rn_SideBar" role="navigation">
            <div class="rn_Padding">
                <div class="rn_Module">
                  <h2>Top 10 Questions</h2>
                    <rn:widget path="reports/Multiline2" report_id="194" per_page="10"/>
                </div>
            </div>
        </div>
          
      <rn:widget path="search/ProductCategoryList" report_page_url="/app/home" label_title="Frequently Asked Questions"   data_type="products" levels="1" />

      <div id="rn_SearchControls">
        <h1 class="rn_ScreenReaderOnly">#rn:msg:SEARCH_CMD#</h1>
        <form onsubmit="return false;">
            <rn:container report_id="176">
              <div class="rn_SearchInput">                                   
                <rn:widget path="search/KeywordText2" label_text="#rn:msg:FIND_THE_ANSWER_TO_YOUR_QUESTION_CMD#" initial_focus="false"/>
              </div>
              <rn:widget path="search/SearchButton2" />
              <rn:widget path="search/AdvancedSearchDialog" report_page_url="/app/answers/list" show_confirm_button_in_dialog="true"/>
            </rn:container>
        </form>
      </div>

      <div id="answerList" class="rn_AnswerList">
        <div class="rn_Padding">
           <rn:widget path="reports/Multiline2" report_id="176"/>
        </div>
      </div>
   
      <div id="myDiv" class="rn_Hidden">
        <div class="hd">Panel #1 from Markup</div> 
        <div class="bd">This is a Panel that was marked up in the document. 
          <rn:widget path="custom/util/CustomInfoButton" label_button="Google" target="http://www.google.com" is_link="true" />
        </div>
        <div class="ft">End of Panel #1</div>
      </div>

<div id="actionButtons">
<div id="myEmailDiv" class="rn_Hidden">
  <div class="hd"><a name="myEmailAnchor"></a></div> 
  <div class="bd">
    <h2>Email Us</h2>
    <h4>What type of questions do you have?</h4>
    <input type="radio" id="rn_1" name="rn_Radio" value="1" /><label for="rn_1">Elevate</label><br/>
    <input type="radio" id="rn_2" name="rn_Radio" value="2" /><label for="rn_2">Concern/Kudos</label><br/>
    <input type="radio" id="rn_3" name="rn_Radio" value="3" /><label for="rn_3">Idea/Suggestion</label><br/>
    <input type="radio" id="rn_4" name="rn_Radio" value="4" /><label for="rn_4">Reservations/General Info</label><br/>
    <input type="radio" id="rn_5" name="rn_Radio" value="5" /><label for="rn_5">Receipt</label><br/>
    <input type="radio" id="rn_6" name="rn_Radio" value="6" /><label for="rn_6">Best Fare Guarantee</label><br/>
    <input type="radio" id="rn_7" name="rn_Radio" value="7" /><label for="rn_7">Lost and Found</label><br/>
    <?/*<input type="radio" id="rn_7" name="rn_Radio" value="11" /><label for="rn_11">Accessibility Services</label><br/>*/?>
    <input type="radio" id="rn_8" name="rn_Radio" value="8" /><label for="rn_8">Charity/Donation Request</label><br/>
    <input type="radio" id="rn_9" name="rn_Radio" value="9" /><label for="rn_9">Sponsorship/Advertising Request</label><br/>
    <input type="radio" id="rn_10" name="rn_Radio" value="10" /><label for="rn_10">Career</label><br/>
    <div class="fd">
      <button class="EmailUs" onclick="goto_EmailTopic()">Continue</button>
    </div>
  </div>
  <a class="yui3-button-close container-close" href="#" >Close</a>
</div>



<div id="myCallDiv" class="rn_Hidden" >
    <div class="hd"><a name="myCallAnchor"></a></div> 
    <div class="bd">
      <div class="content">
        <h2 class="title">Call Us</h2>
        <h5 class="subtext">If you’re looking for help with a new or existing reservation, general
          information, or details on our Elevate program, don’t hesitate to call us, 
          24 hours a day.</h5>

        <h6 class="dest">FROM U.S AND CANADA</h6>
        <h1>1.877.FLY.VIRGIN</h1>
        <h6>(877.359.8474)</h6>

        <h6 class="dest">FROM MEXICO</h6>
        <h3>001.877.359.8474</h3>

        <h6 class="subDest">FROM OTHER COUNTRIES</h6>
        <h3>+1.650.762.7005</h2>


        <h5 class="subDest">If you're an Elevate Silver or Elevate Gold member, you can contact us by calling your exclusive reservation line, or send an email to your dedicated email address—available once you log into your Elevate account.</h5>

        <h5 class="subDest">Any guest calling from the United States has access to a complimentary telecommunication relay service by dialing 711. For more information, head to the <a href="http://www.nidcd.nih.gov/health/hearing/pages/telecomm.aspx">Telecommunications Relay Services</a></h5>

       <h5 class="subDest">If you're looking to get in touch with one of our airport baggage offices please visit us <a href="http://virginamerica.custhelp.com/app/answers/detail/a_id/221">here.</a></h5>
       <h5 class="subDest">If you are Media or Press please visit us <a href="https://www.virginamerica.com/cms/about-our-airline/press-contacts.html">here.</a></h5><br>
       </div>
    </div>
    <a class="yui3-button-close container-close" href="#">Close</a>
</div>


<div id="myAddressDiv" class="rn_Hidden">
   <div class="hd"><a name="myAddressAnchor"></a></div>
   <div class="bd" id= "chat_reactive">
	   <p style="text-align: center;">Have a question? We’re here to help. Please connect with our fabulous teammates in real time, 6am to 11pm PST, 7 days a week (including holidays!). If this is after hours, you may send us an email <a href="http://virginamerica.custhelp.com/app/ask/incidents.c$typeofquestion/1860">here</a></p>

  </div>
  <a class="yui3-button-close container-close" href="#"></a>
</div>
</div>
<?
$prod = intval(getUrlParm("p"));
if($prod > 0) {?>
    <script>
        location.hash = "#answerList";
    </script>
<? } ?>
<script>
    //document.body.scrollTop = document.documentElement.scrollTop = 0;
</script>