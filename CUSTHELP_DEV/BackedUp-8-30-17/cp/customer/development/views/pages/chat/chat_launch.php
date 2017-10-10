<link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />
<rn:meta title="#rn:msg:LIVE_CHAT_LBL#" template="standard.php" clickstream="chat_request"/>
<div id="rn_PageContent" class="rn_Live">
<div class="rn_Padding" >
  <rn:condition chat_available="true">
    <form id="rn_QuestionSubmit" method="post" action="/cc/ajaxCustom/chatInfo">
      <div id="rn_PageTitle" class="rn_LiveHelp">
        <rn:widget path="chat/ChatAgentCustomAvail" />
        <h2>#rn:msg:LIVE_HELP_HDG#</h2>
      </div>
      <div id="rn_chat_unavailable" >
        <h3>Sorry The Agents are currenly not available</h3>
      </div>
      <div id="rn_chatavailable">
      <span class="rn_ChatLaunchFormHeader">#rn:msg:CHAT_MEMBER_OUR_SUPPORT_TEAM_LBL#</span>
      <div id="rn_ErrorLocation"></div>
      <rn:condition logged_in="false">
        <rn:widget path="input/FormInput" name="Contact.Name.First" required="true"  label_input="First Name" initial_focus="true"/>
        <rn:widget path="input/FormInput" name="Contact.Name.Last" required="true" label_input="Last Name"/>
        <rn:widget path="input/FormInput" name="Incident.CustomFields.c.confirmationcode" required="true" label_input="Confirmation Code"/>
        <rn:widget path="input/FormInput" name="Incident.CustomFields.c.contactprimaryelevate" required="false" label_input="Elevate Number (If you have it handy) (11 digit number)"/>
        <rn:widget path="input/FormInput" name="Contact.Emails.PRIMARY.Address" required="true"  label_input="Email(Email linked to Elevate Account is preferred)" />
        <rn:widget path="input/FormInput" name="Incident.Subject" required="true" label_input="How can we help you today?"/>
      </rn:condition>
      <rn:widget path="chat/ChatEngagementStatus"/>
      <rn:widget path="input/FormSubmit" label_button="SUBMIT"  on_success_url="/app/chat/chat_landing" error_location="rn_ErrorLocation"/>
      </br>
      <rn:widget path="chat/ChatHours"/>
      <!--rn condition commented out to display smart assistance at all times-->
      <!-- <rn:condition answers_viewed="2" searches_done="1">
                <rn:condition_else/>-->
      <!--<rn:widget path="input/SmartAssistantDialog"/>-->
      <rn:widget path="custom/input/custom_smartAssist"/>
      <!-- </rn:condition></div>-->
    </form>
  </rn:condition>
  <rn:condition chat_available="false">
    <div id="rn_chat_status">
      <rn:widget path="chat/ChatStatus2"/>
      <rn:widget path="chat/ChatHours"/>
    </div>
  </rn:condition>
  <br />
  <br />
</div>
