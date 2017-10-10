<rn:meta title="#rn:msg:SUPPORT_LOGIN_HDG#" template="mobile.php" login_required="false" />

<section id="rn_PageTitle" class="rn_LoginForm">
    <h1>#rn:msg:LOG_IN_UC_LBL#</h1>
</section>
<section id="rn_PageContent" class="rn_LoginForm">
    <div class="rn_Padding">
        <div>
            <p>#rn:msg:ACCOUNT_ENTER_USERNAME_PASSWORD_MSG#</p>
            <rn:widget path="login/LoginForm2" redirect_url="/app/account/questions/list" initial_focus="true"/>
            <a href="/app/utils/account_assistance#rn:session#">#rn:msg:FORGOT_YOUR_USERNAME_OR_PASSWORD_MSG#</a>
        </div>
        <br/><br/>
        <div>
            <h1>#rn:msg:NOT_REGISTERED_YET_MSG#</h1>
            <button type="button" onclick="window.location='/app/utils/create_account/redirect/<?=urlencode(getUrlParm('redirect'));?>#rn:session#';">#rn:msg:CREATE_NEW_ACCT_CMD#</button>
        </div>
    </div>
</section>
