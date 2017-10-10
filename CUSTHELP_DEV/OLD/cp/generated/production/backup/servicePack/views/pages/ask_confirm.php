<rn:meta title="#rn:msg:ASK_QUESTION_HDG#" template="standard.php" clickstream="incident_confirm"/>

<div id="rn_PageTitle" class="rn_AskQuestion">
    <h1>#rn:msg:QUESTION_SUBMITTED_HDG#</h1>
</div>

<div id="rn_PageContent" class="rn_AskQuestion">
    <div class="rn_Padding">
        <p>
            #rn:msg:SUBMITTING_QUEST_REFERENCE_FOLLOW_LBL#
            <b>
                <rn:condition url_parameter_check="i_id == null">
                    ##rn:url_param_value:refno#
                <rn:condition_else/>
                    <a href="/app/account/questions/detail/i_id/#rn:url_param_value:i_id#">#<rn:field name="incidents.ref_no" /></a>
                </rn:condition>
            </b>
        </p>
        <p>
            #rn:msg:SUPPORT_TEAM_SOON_MSG#
        </p>
	</div>
</div>
