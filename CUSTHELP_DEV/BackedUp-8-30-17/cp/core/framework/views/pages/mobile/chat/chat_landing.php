<rn:meta javascript_module="mobile" clickstream="chat_landing" include_chat="true" noindex="true"/>
<!DOCTYPE html>
<html lang="#rn:language_code#">
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
        <meta charset="utf-8"/>
        <title>#rn:msg:LIVE_ASSISTANCE_LBL#</title>
        <rn:theme path="/euf/assets/themes/mobile" css="site.css"/>
        <rn:head_content/>
        <link rel="icon" href="/euf/assets/images/favicon.png" type="image/png">
        <link rel="canonical" href="<?= \RightNow\Utils\Url::getShortEufAppUrl('sameAsCurrentPage', 'chat/chat_landing') ?>"/>
    </head>
    <body>
        <rn:widget path="utils/CapabilityDetector" pass_page_set="mobile"/>
        <header role="banner">
            <nav id="rn_Navigation" role="navigation">
                <span class="rn_FloatLeft">
                    <rn:widget path="navigation/MobileNavigationMenu" submenu="rn_MenuList"/>
                </span>
                <ul id="rn_MenuList" class="rn_Hidden">
                    <li>
                        <a href="/app/#rn:config:CP_HOME_URL##rn:session#">#rn:msg:HOME_LBL#</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu">#rn:msg:CONTACT_US_LBL#</a>
                        <ul class="rn_Submenu rn_Hidden">
                            <li><a href="/app/chat/chat_launch#rn:session#">#rn:msg:CHAT_LBL#</a></li>
                            <li><a href="/app/ask#rn:session#">#rn:msg:EMAIL_US_LBL#</a></li>
                            <li><a href="javascript:void(0);">#rn:msg:CALL_US_DIRECTLY_LBL#</a></li>
                            <rn:condition config_check="COMMUNITY_ENABLED == true">
                                <li><a href="javascript:void(0);">#rn:msg:ASK_THE_COMMUNITY_LBL#</a></li>
                            </rn:condition>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu">#rn:msg:YOUR_ACCOUNT_LBL#</a>
                        <ul class="rn_Submenu rn_Hidden">
                            <rn:condition logged_in="false">
                                <rn:condition config_check="PTA_ENABLED == true">
                                    <li><a href="javascript:void(0);">#rn:msg:SIGN_UP_LBL#</a></li>
                                    <li><a href="javascript:void(0);">#rn:msg:LOG_IN_LBL#</a></li>
                                <rn:condition_else>
                                    <li><a href="/app/utils/create_account#rn:session#">#rn:msg:SIGN_UP_LBL#</a></li>
                                    <li><a href="/app/#rn:config:CP_LOGIN_URL##rn:session#">#rn:msg:LOG_IN_LBL#</a></li>
                                </rn:condition>
                                <li><a href="/app/#rn:config:CP_ACCOUNT_ASSIST_URL##rn:session#">#rn:msg:ACCOUNT_ASSISTANCE_LBL#</a></li>
                            </rn:condition>
                            <li><a href="/app/account/questions/list#rn:session#">#rn:msg:VIEW_YOUR_SUPPORT_HISTORY_CMD#</a></li>
                            <li><a href="/app/account/profile#rn:session#">#rn:msg:CHANGE_YOUR_ACCOUNT_SETTINGS_CMD#</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="rn_FloatRight">
                    <rn:widget path="chat/ChatDisconnectButton"
                        close_icon_path=""
                        disconnect_icon_path=""
                        mobile_mode="true"/>
                </div>
                <div class="rn_FloatRight rn_Search">
                    <rn:widget path="chat/ChatCancelButton"/>
                </div>
            </nav>
        </header>
        
        <div id="rn_ChatContainer" role="main">
            <div id="rn_PageContent" class="rn_Live">
                <div id="rn_ChatDialogContainer">
                    <rn:widget path="chat/ChatServerConnect"/>
                    <rn:widget path="chat/ChatEngagementStatus"/>
                    <rn:widget path="chat/ChatQueueWaitTime"/>
                    <div id="rn_VirtualAssistantContainer">
                        <rn:widget path="chat/VirtualAssistantAvatar"/>
                        <rn:widget path="chat/VirtualAssistantBanner"/>
                    </div>
                    <rn:widget path="chat/ChatAgentStatus"/>
                    <rn:widget path="chat/ChatTranscript" mobile_mode="true"/>
                    <div id="rn_PreChatButtonContainer">
                        <rn:widget path="chat/ChatRequestEmailResponseButton"/>
                    </div>
                    <rn:widget path="chat/ChatPostMessage" label_send_instructions="#rn:msg:TYPE_YOUR_MESSAGE_AND_SEND_LBL#" mobile_mode="true"/>
                    <div id="rn_InChatButtonContainer">
                        <rn:widget path="chat/ChatSendButton"/>
                    </div>
                    <rn:widget path="chat/VirtualAssistantFeedback" options_count="5"/>
                    <rn:widget path="chat/VirtualAssistantSimilarMatches"/>
                </div>
            </div>
        </div>
        
        <footer role="contentinfo">
            <div>
                <rn:condition logged_in="true">
                    <rn:field name="Contact.Emails.PRIMARY.Address"/><rn:widget path="login/LogoutLink"/>
                <rn:condition_else />
                    <rn:condition config_check="PTA_ENABLED == true">
                        <a href="javascript:void(0);">#rn:msg:LOG_IN_LBL#</a>
                    <rn:condition_else/>
                        <a href="/app/#rn:config:CP_LOGIN_URL##rn:session#">#rn:msg:LOG_IN_LBL#</a>
                    </rn:condition>
                </rn:condition>
                <br/><br/>
            </div>
            <div class="rn_FloatLeft"><a href="javascript:window.scrollTo(0, 0);">#rn:msg:ARR_BACK_TO_TOP_LBL#</a></div>
            <div class="rn_FloatRight">Powered by <a href="#rn:config:rightnow_url#">Oracle</a></div>
            <br/><br/>
        </footer>
    </body>
</html>
