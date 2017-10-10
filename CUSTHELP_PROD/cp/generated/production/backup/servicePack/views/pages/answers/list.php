<rn:meta title="#rn:msg:FIND_ANS_HDG#" template="standard.php" clickstream="answer_list" use_profile_defaults="true"/>

<rn:widget path="knowledgebase/RssIcon2" icon_path="" />
<div id="rn_PageTitle" class="rn_AnswerList">
    <rn:condition is_spider="false">
        <div id="rn_SearchControls">
            <h1 class="rn_ScreenReaderOnly">#rn:msg:SEARCH_CMD#</h1>
            <form method="post" action="" onsubmit="return false" >
                <div class="rn_SearchInput">
                    <rn:widget path="search/AdvancedSearchDialog" report_id="176"/>
                    <rn:widget path="search/KeywordText2" label_text="#rn:msg:FIND_THE_ANSWER_TO_YOUR_QUESTION_CMD#" initial_focus="true" report_id="176"/>
                </div>
                <rn:widget path="search/SearchButton2" report_id="176"/>
            </form>
            <rn:widget path="search/DisplaySearchFilters" report_id="176"/>
        </div>
    </rn:condition>
</div>
<div id="rn_PageContent" class="rn_AnswerList">
    <div class="rn_Padding">
        <h2 class="rn_ScreenReaderOnly">#rn:msg:SEARCH_RESULTS_CMD#</h2>
        <rn:widget path="reports/ResultInfo" report_id="176" add_params_to_url="p,c"/>
        <rn:widget path="knowledgebase/TopicWords2"/>
        <rn:widget path="reports/Multiline" report_id="176"/>
        <rn:widget path="reports/Paginator" report_id="176"/>
    </div>
</div>
