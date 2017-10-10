<rn:meta title="#rn:msg:SUPPORT_HISTORY_LBL#" template="mobile.php" clickstream="incident_list" login_required="true" force_https="true" />

<rn:container report_id="196">
<section id="rn_PageTitle" class="rn_QuestionList">
    <div id="rn_SearchControls">
        <h1>#rn:msg:SEARCH_YOUR_SUPPORT_HISTORY_CMD#</h1>
        <form onsubmit="return false;">
            <rn:widget path="search/KeywordText" label_text="<span class='rn_ScreenReaderOnly'>#rn:msg:SEARCH_YOUR_SUPPORT_HISTORY_CMD#</span>" initial_focus="true"/>
            <rn:widget path="search/SearchButton" icon_path="images/icons/search.png"/>
        </form>
        <rn:widget path="navigation/Accordion" toggle="rn_Advanced"/>
        <div class="rn_Padding">
            <a class="rn_AlignRight" href="javascript:void(0);" id="rn_Advanced">#rn:msg:PLUS_SEARCH_OPTIONS_LBL#</a>
            <div>
                <rn:widget path="search/MobileProductCategorySearchFilter" filter_type="products"/>
                <rn:widget path="search/MobileProductCategorySearchFilter" filter_type="categories"/>
            </div>
        </div>
    </div>
</section>
<section id="rn_PageContent" class="rn_QuestionList">
    <div class="rn_Padding">
        <rn:widget path="reports/ResultInfo"/>
        <rn:widget path="reports/MobileMultiline"/>
        <rn:widget path="reports/Paginator"/>
    </div>
</section>
</rn:container>
