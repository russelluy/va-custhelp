<rn:meta title="#rn:msg:ACCOUNT_SETTINGS_LBL#" template="standard.php" login_required="true" />

<div id="rn_PageTitle" class="rn_Account">
    <h1>#rn:msg:ACCOUNT_SETTINGS_LBL#</h1>
</div>
<div id="rn_PageContent" class="rn_Profile">
    <div class="rn_Padding">
        <div class="rn_Required rn_LargeText">#rn:url_param_value:msg#</div>
        <form id="rn_CreateAccount" method="post" action="" onsubmit="return false;">
            <div id="rn_ErrorLocation"></div>
            <h2>#rn:msg:ACCT_HDG#</h2>
            <fieldset>
                <legend>#rn:msg:ACCT_HDG#</legend>
                <rn:widget path="input/FormInput" name="contacts.login" required="true" validate_on_blur="true" initial_focus="true"/>
            <rn:condition external_login_used="false">
                <a href="/app/account/change_password#rn:session#">#rn:msg:CHG_YOUR_PASSWORD_CMD#</a>
            </rn:condition>
            </fieldset>
            <h2>#rn:msg:CONTACT_INFO_LBL#</h2>
            <fieldset>
                <legend>#rn:msg:CONTACT_INFO_LBL#</legend>
                <rn:widget path="input/ContactNameInput" table="contacts" required = "true"/>
                <rn:widget path="input/FormInput" name="contacts.email" required="true" validate_on_blur="true"/>
            
                
                
                
                <rn:widget path="input/CustomAllInput" table="contacts" always_show_mask="true"/>
            </fieldset>
            <rn:widget path="input/FormSubmit" label_button="#rn:msg:SAVE_CHANGE_CMD#" on_success_url="/app/utils/submit/profile_updated" error_location="rn_ErrorLocation"/>
        </form>
    </div>
</div>
