<rn:meta title="#rn:msg:ACCOUNT_OVERVIEW_LBL#" template="standard.php" login_required="true" />

<div id="rn_PageTitle" class="rn_Account">
    <h1>#rn:msg:ACCOUNT_OVERVIEW_LBL#</h1>
</div>
<div id="rn_PageContent">
    <div class="rn_Overview">
            
            
            <h2><a class="rn_Profile" href="/app/account/profile#rn:session#">#rn:msg:SETTINGS_LBL#</a></h2>
            <div class="rn_Profile">
                <a href="/app/account/profile#rn:session#">#rn:msg:UPDATE_YOUR_ACCOUNT_SETTINGS_CMD#</a><br/>
                <rn:condition external_login_used="false">
                    <a href="/app/account/change_password#rn:session#">#rn:msg:CHANGE_YOUR_PASSWORD_CMD#</a>
                </rn:condition>
            </div>
            
            
            
            
    </div>
</div>
