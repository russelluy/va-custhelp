<!DOCTYPE html>
<html lang="#rn:language_code#" xml:lang="#rn:language_code#">
  <head>

<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
<rn:meta clickstream="chat_landing" include_chat="true" template="standard_chat_landing.php"/><!--by Niven 12/09/2015-->



    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />
    
    <title>#rn:msg:LIVE_ASSISTANCE_LBL#</title>
    <rn:theme path="/euf/assets/themes/standard" css="site.css,/rnt/rnw/yui_2.7/container/assets/skins/sam/container.css" />
    <rn:head_content/>

</head>
<style>

.rn_ChatQueueSearch {
    background: #efeff4 url("/euf/assets/themes/standard/images/layout/whitePixel.png") repeat-x scroll 0 0;
    border: 1px solid #bbbbbb;
    height: 50px;
    line-height: 1.25em;
    margin: 1em;
    padding: 5px;
    text-align: center;
}
.rn_SearchButton .rn_SubmitButton {
	background-color: #7b4397;
    color: #fff;
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-top: 2px;
    padding-top: 2px;
	margin-left: 250px;
	    height: 37px;
}

.rn_KeywordText input {
    font-size: 1.333em;
    height: 38px;
    margin-left: -355px;
}

#rn_ChatQueueSearchContainer .rn_KeywordText input {
    margin-left: 0;
    width: 100%;
}
.rn_SearchButton{
		float: right;
		margin-top: -40px;
		z-index: 99999;
		position: relative;
		right: -25px;
		padding: 0px;
}

@media screen and (min-width:100px) and (max-width:600px){
#rn_ChatQueueSearchContainer .rn_KeywordText input{
	margin-left:-71px;
	width:auto;
}
.rn_ChatCancelButton {
    float: right;
    width: 100%;
    text-align: center;
    position: absolute;
    margin: 0em 1em;
    bottom: 80px;
}

.rn_SearchButton .rn_SubmitButton {
/*    background-color: #7b4397;
    color: #fff;
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-top: 2px;
    padding-top: 2px;
	margin-left: 250px;*/
	
	    background-color: #7b4397;
    color: #fff;
    cursor: pointer;
    float: right;
    font-weight: bold;
    width: auto;
    margin-top: 2px;
    padding: 10px !important;
    margin-left: 195px;
    position: relative;
    z-index: 9999999;
    height: 38px;
}

}

/*.rn_SearchButton .rn_SubmitButton {

}*/







</style>

<body class="yui-skin-sam">
    <div id="rn_ChatContainer">
        <a name="rn_MainContent" id="rn_MainContent"></a>
        <div id="rn_PageContent" class="rn_Live">
            <div class="rn_Padding" >
                <div id="rn_ChatDialogContainer">
                    <rn:widget path="chat/ChatOffTheRecordDialog"/>
                    <div id="rn_ChatDialogHeaderContainer">
                        <div id="rn_ChatDialogTitle" class="rn_FloatLeft"><h3>#rn:msg:CHAT_LBL#</h3></div>
                        <div id="rn_ChatDialogHeaderButtonContainer">
                            <rn:widget path="chat/ChatDisconnectButton"/>
                            <rn:widget path="chat/ChatOffTheRecordButton"/>
                            <rn:widget path="chat/ChatPrintButton"/>
                        </div>
                    </div>
                    <rn:widget path="chat/ChatServerConnect"/>
                    <rn:widget path="chat/ChatEngagementStatus"/>
                    <rn:widget path="chat/ChatQueueWaitTime" type="all"
                            label_estimated_wait_time_not_available=""
                            label_average_wait_time_not_available=""/>
                    <rn:widget path="chat/ChatAgentStatus"/>
                    <rn:widget path="chat/ChatTranscript"/>
                    <div id="rn_PreChatButtonContainer">
                        <rn:widget path="chat/ChatCancelButton"/>
                        <rn:widget path="chat/ChatRequestEmailResponseButton"/>
                    </div>
                    <rn:widget path="chat/ChatPostMessage"/>
                    <div id="rn_InChatButtonContainer">
                        <rn:widget path="chat/ChatSendButton"/>
                        <rn:widget path="chat/ChatAttachFileButton"/>
                        <rn:widget path="chat/ChatCoBrowseButton"/>
                    </div>
                    <div id="rn_ChatQueueSearchContainer">
                        <rn:widget path="chat/ChatQueueSearch" popup_window="true"/>
                    </div>
                </div>
            </div>
        </div>
        <div id="rn_ChatFooter">
            <div class="rn_FloatLeft"><a href="javascript:Window.close()">Close</a></div>
            <div class="rn_FloatRight">
                <rn:widget path="utils/RightNowLogo"/>
            </div>
        </div>
    </div>
</body>
</html>
