<rn:meta title="#rn:php:SEO::getDynamicTitle('answer', getUrlParm('a_id'))#" template="standard.php" answer_details="true" clickstream="answer_view"/>

<div id="rn_PageTitle" class="rn_AnswerDetail"> 
   <rn:condition is_spider="false">
        <div id="rn_SearchControls" class="rn_AnswerSearchControls"> 
            <h1 class="rn_ScreenReaderOnly">#rn:msg:SEARCH_CMD#</h1>
            <form method="post" action="" onsubmit="return false" >
                <div class="rn_SearchInput">
                    <rn:widget path="search/AdvancedSearchDialog" report_page_url="/app/answers/list" report_id="176"/>
                    <rn:widget path="custom/search/CustomKeywordText" label_text="#rn:msg:FIND_THE_ANSWER_TO_YOUR_QUESTION_CMD#" placeholder="Search answers for..." initial_focus="true" report_id="176"/>
                </div>
                <rn:widget path="search/SearchButton2" report_page_url="/app/answers/list" report_id="176"/>
            </form>
        </div>
    </rn:condition>
    <h1 id="rn_Summary"><rn:field name="answers.summary" highlight="true"/></h1>
    <div id="rn_AnswerInfo">
        #rn:msg:PUBLISHED_LBL# <rn:field name="answers.created" />
        &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        #rn:msg:UPDATED_LBL# <rn:field name="answers.updated" />
    </div>
    <rn:field name="answers.description" highlight="true"/>
</div>
<div id="rn_PageContent" class="rn_AnswerDetail">
    <div id="rn_AnswerText">
        <rn:field name="answers.solution" highlight="true"/>
    </div>
    <rn:widget path="knowledgebase/GuidedAssistant" label_text_result=""/>
    <div id="rn_FileAttach">
        <rn:widget path="output/DataDisplay" name="answers.fattach" />
    </div>
    <rn:widget path="feedback/AnswerFeedback" dialog_threshold="2" options_descending="true" options_count="4" use_rank_labels="true" label_dialog_title="Rating Submitted" label_dialog_description="Please tell us how we can make this answer more useful. "/>
    <br/>
    <rn:widget path="knowledgebase/RelatedAnswers" />
    <rn:widget path="knowledgebase/PreviousAnswers" />
    <rn:condition is_spider="false">
        <div id="rn_DetailTools">
            <rn:widget path="utils/SocialBookmarkLink" />
            <rn:widget path="utils/PrintPageLink" />
            <rn:widget path="utils/EmailAnswerLink" />
            
        </div>
    </rn:condition>
</div>
