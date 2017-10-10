
<link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />

<rn:meta title="#rn:msg:ASK_QUESTION_HDG#" template="standard.php" clickstream="incident_create"/>
<!-- <div id="rn_PageTitle" class="rn_AskQuestion">
    <h1>#rn:msg:SUBMIT_QUESTION_OUR_SUPPORT_TEAM_CMD#</h1>
</div> -->
<div id="rn_PageContent" class="rn_AskQuestion">
  <h1 id="rn_title">Contact Us</h1>
  <hr width="40%" style="margin: 0 auto">
  <div class="rn_Padding">
    <form id="rn_QuestionSubmit" onsubmit="return false;">
      <div id="rn_ErrorLocation"></div>

<?/*<rn:condition url_parameter_check="incidents.c$typeofquestion==1960" />
Disability Form
<rn:condition_else />
	Not Disability Form
	<rn:widget path="input/SmartAssistantDialog"/>
</rn:condition>*/?>

<!--
Elevate
-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1857">
  <h2>Elevate</h2>
  <h3>Need Elevate help?  Just fill out the form below and we'll respond within 24 hours.</h3>
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" required="false" label_input="Elevate Number (If you have it handy)"/> 
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" /> 
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="false" label_input="Phone Number" />

  <rn:widget path="custom/input/SelectionRadioInput" name="Incident.CustomFields.c.elevatesubject" required="true" label_input="Elevate Help Request" always_show="true" radio="true" /> <br>

    <!-- show fields when elevate subject is
       Missing Points id=1867  
    -->
    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.confirmationcode1" required="false" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1867" />
    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.confirmationcode2" required="false" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1867" />
    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.partnerairline" required="false" label_input="If missing points from one of our Elevate partners, which one?" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1867" >

    <!-- show fields when elevate subject is
       Merge Accounts id=1852  
    -->

    <!-- show fields when elevate subject is
       Redeem points with our Airline Partners id=1869  
    -->
    <rn:widget path="custom/input/ToggleVisibleArea" name="togg" label="<a target='_blank' href='http://www.virginamerica.com/cms/elevate-frequent-flyer/partners/airline-partners'>For more info click here</a>" display_value="Incident.CustomFields.c.elevatesubject=1869" /><br>
    <rn:widget path="custom/input/CustomSelectionInput" name="Incident.CustomFields.c.ffpburn" trigger_change_event="false" display_value="Incident.CustomFields.c.elevatesubject=1869" required="false" />
    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.ffpconfcode" required="false" label_input="Confirmation Code(If you have an existing booking)" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1869">

    <rn:widget path="custom/input/ToggleVisibleArea" name="togg2" label="<h4>Please give us a range of dates that you can depart (as availability is limited):</h4>" display_value="Incident.CustomFields.c.elevatesubject=1869" />
    <rn:widget path="custom/input/CustomDateInput" name="incidents.c$ffpdesiredstart" required="false" min_year="2015" max_year="2020" label_input="Start" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1869" /> 
    <rn:widget path="custom/input/CustomDateInput" name="incidents.c$ffpdesiredstart2" required="false" min_year="2015" max_year="2020" label_input="End" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1869" /> 
    <rn:widget path="custom/input/ToggleVisibleArea" name="togg3" label="<h4>Please give us a range of dates that you can return (as availability is limited):</h4>" display_value="Incident.CustomFields.c.elevatesubject=1869" />
    <rn:widget path="custom/input/CustomDateInput" name="incidents.c$ffpdesiredend" required="false" min_year="2015" max_year="2020" label_input="Start" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1869" />
    <rn:widget path="custom/input/CustomDateInput" name="incidents.c$ffpdesiredend2" required="false" min_year="2015" max_year="2020" label_input="End" always_show="false" display_value="Incident.CustomFields.c.elevatesubject=1869" /> 

    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.city_origin" required="false" always_show="false" label_input="Where are you flying from?" display_value="Incident.CustomFields.c.elevatesubject=1869" />
    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.city_destination" required="false" always_show="false" label_input="Where are you flying to?" display_value="Incident.CustomFields.c.elevatesubject=1869" />
    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.number_passengers" required="false" always_show="false" label_input="How many guests?" display_value="Incident.CustomFields.c.elevatesubject=1869" />

    <!-- show fields when elevate subject is
       Other id=1872 
    -->
    <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.altelevatenum1" required="false" always_show="false" label_input="Additional Elevate Number" display_value="Incident.CustomFields.c.elevatesubject=1872,Incident.CustomFields.c.elevatesubject=1868" />

  <rn:widget path="input/FormInput" name="incidents.subject" required="true" label_input="Subject"/>
  <rn:widget path="input/FormInput" name="incidents.thread" required="false" label_input="Let us know how we can help you?"/>

</rn:condition>


<!--

Concern/Kudos

-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1858">
  <h2>Concern/Kudos</h2>
  <h3>Something not quite right?  Have an idea for how we can do better? Contact us below regarding any post-flight questions and issues. While we always try to respond quickly, please note during busy travel periods email response time may range from 7 to 10 days.</h3>
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="custom/input/SelectionRadioInput" name="Incident.CustomFields.c.concern_or_kudos" always_show="true" radio="true" lbl="Comment Type"/><br/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" required="false" label_input="Elevate Number (If you have it handy)" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" />
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="false" label_input="Phone Number" />
  <rn:widget path="input/FormInput" name="incidents.subject" required="true" label_input="Subject"/>
  <rn:widget path="input/FormInput" name="incidents.thread" required="true" label_input="What would you like to tell us?"/>
  <rn:widget path="input/FileAttachmentUpload2" display_thumbnail="true" label_input="Have something to show us? Attach it here." />
  
</rn:condition>

<!--

Idea/Suggestion

-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1859">
  <h2>Idea/Suggestion</h2>
  <h3>Have an idea for how we can do better? Contact us below regarding any post-flight questions and issues. While we always try to respond quickly, please note during busy travel periods email response time may range from 7 to 10 days.</h3>
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" required="false" label_input="Elevate Number (If you have it handy)" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" />
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="false" label_input="Phone Number" />
  <rn:widget path="input/FormInput" name="incidents.subject" required="true" label_input="Subject"/>
  <rn:widget path="input/FormInput" name="incidents.thread" required="true" label_input="What would you like to tell us?"/>

</rn:condition>

<!--

Reservations/General Info

-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1860">
  <h2>Reservations/General Info</h2>
  <h3>Need help with a current reservation? This form is where you can write to us if you have questions about your reservation or are unable to find the answers in our FAQ.  Just fill out the form below and we will respond within 24 hours.</h3>
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" required="false"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" />
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="false" label_input="Phone Number" />
  <rn:widget path="input/FormInput" name="incidents.subject" required="true" label_input="Subject"/>
  <rn:widget path="input/FormInput" name="incidents.thread" required="false" label_input="What would you like to tell us?"/>

</rn:condition>

<!--

Receipt

-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1866">
  <h2>Receipt</h2>
  <h3>You expensing that? You can look up, print, or email your flight receipt <a href="https://www.virginamerica.com/manage-itinerary">here</a> to print a receipt. For a receipt on purchases made at 35,000 feet – fill out this form below. Be sure to include the date the charges posted to your bank account so we can look it up and get it to you faster. Please note: during busy travel periods or crazy weather events, email response time may take up to 7-10 business days. Cheers!</h3>
  <rn:widget path="custom/input/SelectionRadioInput" name="Incident.CustomFields.c.receipt_type" always_show="true" radio="true" lbl="Type of Receipt"/><br/>

  <rn:widget path="custom/input/ToggleVisibleArea" name="toggX" label="For any current reservation receipts please visit us <a target='_blank' href='https://www.virginamerica.com/manage-itinerary'>here.</a>" display_value="Incident.CustomFields.c.receipt_type=1901" />

  <rn:widget path="custom/input/CustomTextInput" name="contacts.first_name" always_show="true" required="true" hideon_value="Incident.CustomFields.c.receipt_type=1901"  label_input="First Name"/>

  <rn:widget path="custom/input/CustomTextInput" name="contacts.last_name" always_show="true" required="true" hideon_value="Incident.CustomFields.c.receipt_type=1901" label_input="Last Name"/>
  <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.contactprimaryelevate" always_show="true" required="false" hideon_value="Incident.CustomFields.c.receipt_type=1901"/>
  <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.confirmationcode" always_show="true" label_input="Virgin America Booking Confirmation Code" required="false" hideon_value="Incident.CustomFields.c.receipt_type=1901" />
  <rn:widget path="custom/input/CustomTextInput" name="contacts.email" always_show="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" required="true" hideon_value="Incident.CustomFields.c.receipt_type=1901" />
  <rn:widget path="custom/input/CustomTextInput" name="Incident.CustomFields.c.contactphone" always_show="true" label_input="Phone Number" required="false" hideon_value="Incident.CustomFields.c.receipt_type=1901" />
  <rn:widget path="custom/input/CustomTextInput" name="incidents.subject" always_show="true" required="true" label_input="Subject" hideon_value="Incident.CustomFields.c.receipt_type=1901"/>
  <rn:widget path="custom/input/CustomTextInput" name="incidents.thread" always_show="true" required="true" label_input="What would you like to tell us?" hideon_value="Incident.CustomFields.c.receipt_type=1901"/>

  <rn:widget path="custom/input/CustomFormSubmit" label_button="Fill the form to proceed" on_success_url="/app/ask_confirm" always_show="true" hideon_value="Incident.CustomFields.c.receipt_type=1901" error_location="rn_ErrorLocation" />
</rn:condition>

<!--

Best Fare Guarantee

-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1861">
  <h2>Best Fare Guarantee</h2>
  <h3>Think you found a better Virgin America fare on a website other than Virginamerica.com?   Our lowest fares are right here on <a href="http://www.virginamerica.com" target="_blank">virginamerica.com</a>, but if you've stumbled upon a lower fare on another site you can submit your claim no later than 11:59 pm CT on the same day you purchased Virgin America tickets. Please find the full Terms and Conditions <a href="http://www.virginamerica.com/cms/dam/vx-pdf/130905_best_fares_guarantee_tc.pdf" target="_blank">here</a>. We'll look into your claim and email you if we're able to honor the fare you found.</h3>
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" label_input="Elevate Number (If you have it handy)" required="false"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" />
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="true" label_input="Phone Number" />
  <rn:widget path="input/FormInput" name="incidents.subject" required="true" label_input="Subject"/>
  <rn:widget path="input/FormInput" name="incidents.thread" required="true" label_input="What would you like to tell us?"/>

  <rn:widget path="input/DateInput" name="Incident.CustomFields.c.bestfare_date" min_year="2015" max_year="2016" required="false" label_input="Date of Travel" initial_focus="false"/>
  <rn:widget path="input/SelectionInput" name="Incident.CustomFields.c.cabinofservice" required="false" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.competingfare" required="false" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.competingsite" required="false" label_input="Site where fare was found?" />
  <rn:widget path="input/FileAttachmentUpload2" label_input="Please upload screenshot of Fare" />
  <rn:widget path="input/SelectionInput" name="Incident.CustomFields.c.agreetofaxscreenshot" label_input="Agree to fax screenshot if requested?" required="false" />

</rn:condition>


<!--

Best Fare Guarantee 2

-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1868">
  <h2>Lowest Dallas Love Field Fare Guarantee</h2>
  <h3>Think you found a better Dallas Love Field Main Cabin fare on a website other than Virginamerica.com? Our lowest fares are right here on <a href="http://www.virginamerica.com" target="_blank">virginamerica.com</a>, but if you've stumbled upon a comparable Main Cabin fare that is lower than ours on a nonstop route that Virgin America serves from Dallas Love Field, show us and we'll match it. To get the match, tell us no later than 11:59 pm CT on the same day you purchased Virgin America tickets. For more details on how to request a match, check out the full Terms and Conditions <a href="https://www.virginamerica.com/cms/dam/vx-pdf/150116_Terms_and_Conditions_for_DAL_Fare_Guarantee.pdf" target="_blank">here</a>.</h3>
  
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" label_input="Elevate Number (If you have it handy)" required="false"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" />
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="true" label_input="Phone Number" />
  <rn:widget path="input/FormInput" name="incidents.subject" required="true" label_input="Subject"/>
  <rn:widget path="input/FormInput" name="incidents.thread" required="true" label_input="What would you like to tell us?"/>

  <rn:widget path="input/DateInput" name="Incident.CustomFields.c.bestfare_date" min_year="2015" max_year="2016" required="false" label_input="Date of Travel" initial_focus="false"/>
  <div style="display:none"><rn:widget path="input/SelectionInput" name="incidents.c$cabinofservice" required="false" /></div>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.competingfare" required="true" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.competingsite" required="true" label_input="Site where fare was found?" />
  <rn:widget path="input/FileAttachmentUpload2" label_input="Please upload screenshot of Fare" />
  <rn:widget path="input/SelectionInput" name="Incident.CustomFields.c.agreetofaxscreenshot" label_input="Agree to fax screenshot if requested?" required="false" />

</rn:condition>

<!--

Lost and Found

-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1865">
  <h2>Lost and Found</h2>
  <h3>While we're not responsible for items left on board, we will do our best to reunite you with your lost item.  Our stations hold all found property for 5 days.  After 5 days, our airport locations forward all items to Central Baggage at Corporate Headquarter (that's us).  We inventory lost and found once a week.</h3>  
<p>
<h3> We'll keep your information on file for 30 days while we search.  If we find a match, we will notify you immediately</h3>
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" label_input="Elevate Number (If you have it handy)" required="false"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" />
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="true" label_input="Phone Number" />

  <rn:widget path="input/DateInput" name="Incident.CustomFields.c.lost_object_date" min_year="2015" max_year="2020" required="false" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.lost_object_locationlastseen" required="true" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.flight_number" required="false" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.seat_number" required="false" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.city_origin" required="true" label_input="Where did you fly from?" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.city_destination" required="true" label_input="Where did you fly to?" />
  <rn:widget path="input/SelectionInput" name="Incident.CustomFields.c.lost_object" required="true" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.lost_object_brandnamemodel" required="false" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.lost_object_identifyingfeature" required="true" />
  <rn:widget path="input/FileAttachmentUpload2" display_thumbnail="true" label_input="If possible please provide a picture" />
</rn:condition>

<!--
Special Request (Disability Form)
-->
<rn:condition url_parameter_check="incidents.c$typeofquestion==1960">
	<style>
		.rn_SelectionInput legend, .rn_SelectionInput label
		{
			font-weight: normal !important;
			font-size: 1.167em !important;
		}
	</style>
  <h2>Accessibility Services</h2>
  <h3>Do you have an accessibility need? Just fill out the form below and we will respond with 72 hours. For immediate needs, please contact us at 1.877.FLY.VIRGIN (877.359.8474) and a teammate will be happy to assist you.</h3>
  <rn:widget path="input/FormInput" name="contacts.first_name" required="true" initial_focus="false" label_input="First Name"/>
  <rn:widget path="input/FormInput" name="contacts.last_name" required="true" label_input="Last Name"/>
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" required="false" label_input="Elevate Number (If you have it handy)"/> 
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" label_input="Virgin America Booking Confirmation Code" required="false" /> 
  <rn:widget path="input/FormInput" name="contacts.email" required="true" label_input="#rn:msg:EMAIL_ADDR_LBL#" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactphone" required="false" label_input="Phone Number" />
  <rn:widget path="custom/input/CustomDateInput" name="incidents.c$ffpdesiredstart" required="false" min_year="2015" max_year="2020" label_input="Departure Date" always_show="true" /> 
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.departureflightnum" label_input="Departure Flight Number" required="false" /> 
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.city_origin_menu" required="false" label_input="Where are you flying from?" />
  <rn:widget path="custom/input/CustomDateInput" name="incidents.c$ffpdesiredend" required="false" min_year="2015" max_year="2020" label_input="Return Date" always_show="true" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.returnflightnum" label_input="Return Flight Number" required="false" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.city_destination_menu" required="false" label_input="Where are you flying from (return trip)?" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.serviceanimal" required="false" label_input="Are you traveling with a service animal?" />
  
  <rn:widget path="custom/input/SelectionRadioInput" name="Incident.CustomFields.c.emotional_support_animal" required="false" label_input="Are you traveling with an emotional support animal?" />
  <rn:widget path="custom/input/ToggleVisibleArea" name="togg" label="Please visit <a href='http://virginamerica.custhelp.com/app/answers/detail/a_id/91' target='_blank'>here</a> for the documentation requirements." display_value="Incident.CustomFields.c.emotional_support_animal=2069" />
  
  <rn:widget path="custom/input/SelectionRadioInput" name="Incident.CustomFields.c.wheelchairassist" required="false" label_input="Do you require wheelchair assistance?" />
  <rn:widget path="custom/input/ToggleVisibleArea" name="togg" label="If you would like us to provide you with a wheelchair curbside, we ask that you or a person accompanying you contact a Virgin America teammate at the ticket counter, notifying them that you have arrived and that you would like the assistance of a wheelchair. A wheelchair will then be brought to you curbside." display_value="Incident.CustomFields.c.wheelchairassist=2066, Incident.CustomFields.c.wheelchairassist=2067, Incident.CustomFields.c.wheelchairassist=2068" />
 
  <rn:widget path="custom/input/SelectionRadioInput" name="Incident.CustomFields.c.oxygen_use" required="false" label_input="Will you be using a Respiratory Assistive Device during the flight?" />
  <rn:widget path="custom/input/ToggleVisibleArea" name="togg" label="<p>Please download the Respiratory Assistive Device Documentation Form <a href='http://virginamerica.custhelp.com/ci/fattach/get/59157/0/filename/Portable+Oxygen+Concentrator+Med+Form.pdf' target='_blank'>here</a>. Then fill out and attach below. If you do not have the Respiratory Assistive Device Documentation Form already filled out you will receive an automated email from us after clicking “Submit”. You can respond directly to this email with your completed form." display_value="Incident.CustomFields.c.oxygen_use=2071"/>
  <rn:widget path="custom/input/CustomFileAttachmentUpload" required="false" label_input="Please add any attachments here" display_value="Incident.CustomFields.c.oxygen_use=2071" />
  <rn:widget path="input/FormInput" name="Incident.CustomFields.c.oxygen_device_make_model" required="false" label_input="What is the make and model of the device?" />

  <rn:widget path="custom/input/SelectionRadioInput" name="Incident.CustomFields.c.special_assist_other" required="false" label_input="Do you require assistance not listed above?" />  
  <div class="rn_Hidden">
	<rn:widget path="input/FormInput" name="incidents.subject" required="true" label_input="Subject" default_value="Special Request" />
  </div>
  <rn:widget path="custom/input/CustomTextInput" name="incidents.thread" always_show="false" required="false" label_input="Let us know how we can help you?" display_value="Incident.CustomFields.c.special_assist_other=2073"/>

</rn:condition>

<div class="rn_Hidden">
  <rn:widget path="input/SelectionInput" name="incidents.c$typeofquestion" default_value="1846" required="false" />
</div>

<rn:widget path="input/SmartAssistantDialog" label_prompt="The following answers might help you immediately. Click the arrow to expand the answer."/>

<rn:condition url_parameter_check="incidents.c$typeofquestion!=1866">
  <rn:widget path="custom/input/CustomFormSubmit" label_button="Fill the form to proceed" on_success_url="/app/ask_confirm" always_show="true" display_value="" error_location="rn_ErrorLocation" />
</rn:condition>
    </form>
  </div>
</div>

