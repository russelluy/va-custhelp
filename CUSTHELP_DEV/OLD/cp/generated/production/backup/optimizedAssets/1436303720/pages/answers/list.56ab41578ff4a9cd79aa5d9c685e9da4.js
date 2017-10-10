
RightNow.EventProvider=RightNow.Widgets.extend({constructor:function(){this._events={};this._eventHandlers={};this._eventFilters={}},_addEventHandler:function(a,b){this._eventHandlers[a]=b;return this},_getEventHandlers:function(a){return this._eventHandlers[a]||{}},_addSubscribersFilter:function(a,b,d){if(!b||"function"!==typeof b)throw Error("Subscriber filters must be functions.");this._eventFilters[a]||(this._eventFilters[a]=[]);this._eventFilters[a].push({handler:b,context:d});return this},_getFilteredSubscriberIndices:function(a){var b=this._events[a];a=this._eventFilters[a];var d=[],c;if(a)for(var f=0;f<a.length;f++)c=a[f],c=c.handler.call(c.context,b),this.Y.Array.each(c,function(a){isNaN(a)||d.push(a)},this);return d},fire:function(a,b,d){var c=this._getEventHandlers(a),f=this._getFilteredSubscriberIndices(a),g=this._events[a],e=!0,k=[];c.pre&&(e=c.pre.call(this,b));if(!1!==e){if(g){d="undefined"!==typeof d?[b,d]:[b];for(var e=0,l=g.length,h,m;e<l;e++)-1===this.Y.Array.indexOf(f,e)&&(h=g[e],m=h.handler.call(h.context||window,a,d),h.once&&k.push(e),c.during&&c.during.call(this,m));if(l=k.length)for(e=0;e<l;e++)g.splice(k[e]-e,1)}c.post&&c.post.call(this,b)}return this},on:function(a,b,d,c){this._events[a]=this._events[a]||[];if(b&&"function"===typeof b)return this._events[a].push({handler:b,context:d,once:c}),this;throw Error("Handler specified isn't a callable function");},once:function(a,b,d){return this.on(a,b,d,!0)},detach:function(a,b,d){if(b&&"function"===typeof b){var c;if(c=this._events[a])for(a=c.length-1;0<=a;a--)c[a].handler!==b||d&&d!==c[a].context||c.splice(a,1);return this}throw Error("Handler specified isn't a callable function");}});
(function(){function r(f){function h(a,b){b=b?RightNow.Url.convertToSegment(RightNow.Url.convertToArray(1,b)):"";d.add({state:a},{url:p.getCurrentPage()+b})}function k(a){return function(){g||a.apply(this,arguments)}}var c={},e={},a={},b="",g=!1,d=new f.HistoryHTML5;d.on("change",function(a){var b;a.src===f.HistoryHTML5.SRC_POPSTATE&&(a=a.changed.state||a.changed[RightNow.Event.browserHistoryManagementKey],b=l.get(),g=!0,a?f.Object.each(a.newVal,function(a){q.ajaxCallback(a.response,a.data)}):f.Object.each(b,function(a){a.fire("reset").fire("send")}),g=!1)});return{enabled:!0,setCache:function(a,b,g){c[a]||(c[a]={});c[a][b]=g},checkCache:function(a,b){return c[a]?c[a][b]:null},restoreCache:k(function(c){f.Object.isEmpty(e)&&h(a,b+=c.friendly);b=""}),addRequest:k(function(c,g){f.Object.isEmpty(e)&&(q.searchesPerformed++,a={},b="");e[g]=c}),addResponse:k(function(c,g){var d=e[g];if(d){var k=b+=d.friendly,d=f.merge(d,c);a[g]=d;delete e[g];f.Object.isEmpty(e)&&h(a,k)}})}}var m,q,p,l;"pushState"in window.history?YUI().use("history-html5",function(f){m=r(f)}):m={enabled:!1};q=function(){function f(a,b,c){var d="undefined"===typeof c;a&&!d&&m.addResponse({response:a,data:b},c);m.setCache(b.searchSource,b.cacheKey,a);c=l.get(b.searchSource);d&&(c.once("send",function(){return!1}).fire("send",b.allFilters),a.fromHistoryManager=!0);c.fire("response",new RightNow.Event.EventObject(null,{data:a,filters:b.allFilters}))}function h(a,b,c,d){a=RightNow.Ajax.makeRequest(a,b,{successHandler:f,failureHandler:function(a){var b=RightNow.Interface.getMessage("ERROR_REQUEST_ACTION_COMPLETED_MSG");403===a.status&&void 0!==a.responseText&&(b=a.responseText);RightNow.UI.Dialog.messageDialog(b,{icon:"WARN",exitCallback:function(){window.location.reload(!0)}})},json:!0,data:c,timeout:1E4});m.addRequest(d,a.id+"")}function k(a,b,c,d){var f=["keyword"].concat(a.filters||[]),s=f.length,h,k,l={};c=RightNow.Lang.cloneObject(c);a.params&&(c=e.mix(c,a.params));if(b&&b.allFilters)for(a=0;a<s;a++)h=f[a],(k=b.allFilters[h])&&k.filters&&k.filters.data&&!c[h]&&("keyword"!==h||d||(h="kw"),l[h]=c[h]=k.filters.data);c.page&&!l.page&&(l.page=c.page);return{filtersToInclude:l,params:c}}function c(a,b){b&&1!==b||(a=RightNow.Url.addParameter(a,"search","1"));return a}var e=YUI();return{searchesPerformed:0,go:function(a,b,g,d,e){if("report"===d.type){if("undefined"===typeof b)throw Error("No search filters have been defined for report "+d.id);RightNow.Event.fire("evt_searchRequest",new RightNow.Event.EventObject(this,{filters:b}));if(!m.enabled||!0===a.newPage||a.reportPage&&!RightNow.Url.isSameUrl(a.reportPage))if(g=RightNow.Url,d=a.reportPage||p.getCurrentPage(),e=a.target||"_self",!a.page&&b.allFilters.page&&(a.page=1,b.allFilters.page=1),d=g.convertSearchFiltersToParms(d,b.allFilters,0),d=g.addParameter(d,"session",g.getSession()),d=c(d,b.allFilters.page),a.popupWindow){b=window.screenX||window.screenLeft;g=window.screenY||window.screenTop;var f;f=b+document.body.clientWidth;e=screen.width*a.width/100;a=screen.height*a.height/100;f=b>screen.width-f?b-e-15:f+15;var n=window.screenY?window.screenY:window.screenTop;0>f&&(f=b+100);0>n&&(n=g+100);window.open(d,"_blank","scrollbars=1,resizable=1,left="+f+",top="+n+",width="+e+"px,height="+a+"px")}else window.open(d,e);else a.page?delete b.allFilters.search:b.allFilters.page=1,a=d.id,d=d.type+d.id,g=p.buildReportRequestParameters(a,b.allFilters,b.format,b.token,0),e=RightNow.Url.convertSearchFiltersToParms("",b.allFilters,""),f=g.sf,1===f.page&&(f.search=1),f=RightNow.JSON.stringify(f),n=m.checkCache(d,f),e={key:d,friendly:e},n?(m.restoreCache(e),l.get(d).fire("response",new RightNow.Event.EventObject(null,{data:n,filters:b}))):h("/ci/ajaxRequest/getReportData",{filters:f,report_id:a,r_tok:g.token,format:RightNow.JSON.stringify(g.fmt)},{searchSource:d,allFilters:b,cacheKey:f},e)}else if(g&&"object"===typeof g&&d.id)if(RightNow.Event.fire("evt_searchRequest",new RightNow.Event.EventObject(this,{filters:b})),m.enabled&&!0!==a.newPage){a=e.endpoint;b=k(e,b,g,!0);g=b.filtersToInclude;b=b.params;if(!a)throw Error("An endpoint hasn't been specified");d=d.type+d.id;e=RightNow.JSON.stringify(b);f=m.checkCache(d,e);g={key:d,friendly:RightNow.Url.convertToSegment(g)};f?(m.restoreCache(g),l.get(d).fire("response",new RightNow.Event.EventObject(null,{data:f,filters:b}))):h(a,b,{searchSource:d,allFilters:b,cacheKey:e},g)}else a=RightNow.Url,d=p.getCurrentPage(),b=k(e,b,g,!1).filtersToInclude,d+=a.convertToSegment(b),d=a.addParameter(d,"session",a.getSession()),d=c(d,b.page),window.open(d,"_self")},ajaxCallback:f}}();p={buildReportRequestParameters:function(f,h,k,c,e){var a=RightNow.Lang.cloneObject(h),b;for(b in a)a.hasOwnProperty(b)&&(a[b].filters&&(a[b].filters.report_id=parseInt(f,10)),a[b].data&&delete a[b].data);k||(k={});k.urlParms=RightNow.Url.buildUrlLinkString(h,k.parmList);return{c:e,id:f,sf:a,fmt:k,token:c}},getCurrentPage:function(){var f=window.location,h=f.pathname,f=f.origin||f.protocol+"//"+f.host;return"/"===h||"/app"===h||"/app/"===h?f+"/app/"+RightNow.Interface.getConfig("CP_HOME_URL"):h.split("/").slice(0,RightNow.Url.getParameterSegment()-1).join("/")}};l=function(){function f(c){if(!c||!c.length||2>c.length)throw Error("You're doing it wrong");this.sources=c;this.multiple=!0}var h={},k=RightNow.EventProvider.extend({overrides:{constructor:function(c,e){this.parent();this.Y=c;delete this.data;delete this.baseDomID;delete this.baseSelector;this.searchSource=e;this.instanceID=e.id;this._addEventHandler("search",{pre:function(a){this._params||(this._params={});a instanceof RightNow.Event.EventObject&&(this._originalEventObject=RightNow.Lang.cloneObject(a),this._collectSearchFilters(a),this._params.newPage=a.filters.newPage)},during:function(a){a instanceof RightNow.Event.EventObject&&this._collectSearchFilters(a)},post:function(){var a,b;if(this._excludedFilters)for(a=0;a<this._excludedFilters.length;a++)b=this._excludedFilters[a],this._respondingFilters&&!this._respondingFilters[b]&&(b=this._filters.allFilters[b])&&b.filters&&(b.filters.data[0]?b.filters.data[0]=null:b.filters.data=null);this.fire("send",this._filters,this._params)}})._addEventHandler("send",{pre:function(a){this._originalEventObject||(this._originalEventObject={filters:{page:1,newPage:!1}});this._eventCancelled=!1},during:function(a){!1===a&&(this._eventCancelled=!0)},post:function(a){this._eventCancelled||(this._excludedFilters=[],q.go(this._originalEventObject.filters,this._filters,this._params,this.searchSource,this))}})._addEventHandler("setInitialFilters",{post:function(a){this._setInitialFilters(a)}})._addEventHandler("appendFilter",{post:function(a){this._originalEventObject||(this._originalEventObject=RightNow.Lang.cloneObject(a));this._mergeFilters(a)}})._addEventHandler("excludeFilterFromNextSearch",{post:function(a){this._excludedFilters||(this._excludedFilters=[]);this._excludedFilters.push(a.data.name)}})._addEventHandler("reset").on("reset",function(){var a=(this._filters=RightNow.Lang.cloneObject(this._initialFilters))?this._filters.allFilters:null;this._params&&a&&(this._initialParams&&(this._params=RightNow.Lang.cloneObject(this._initialParams)),this.Y.Object.each(this._params,function(b,c,d){a[c]&&a[c].filters&&"data"in a[c].filters&&(d[c]=a[c].filters.data)}))},this)}},_setFilters:function(c){this._filters=c},_setInitialFilters:function(c){c instanceof RightNow.Event.EventObject&&(this.Y.Object.isEmpty(c.filters)||(this._filters=c.filters,this._initialFilters=RightNow.Lang.cloneObject(c.filters)),this.Y.Object.isEmpty(c.data)||(this._params=c.data,this._initialParams=RightNow.Lang.cloneObject(c.data)))},_mergeFilters:function(c){this._filters.allFilters=this.Y.mix(this._filters.allFilters,c.filters,!0,null,0,!0)},_collectSearchFilters:function(c){c=new RightNow.Event.EventObject({instanceID:c.w_id},RightNow.Lang.cloneObject(c));c.filters.searchName?(this._respondingFilters||(this._respondingFilters={}),this._respondingFilters[c.filters.searchName]=!0,this._filters||(this._filters={}),this._filters.allFilters||(this._filters.allFilters={}),this._filters.allFilters[c.filters.searchName]=c):"generic"===this.searchSource.type&&(this._params=this.Y.mix(this._params||{},c.data,!0))}});f.prototype={_invoke:function(c,e,a,b){for(var f=0;f<this.sources.length;f++)this.sources[f][c](e,a,b);return this},on:function(c,e,a){return this._invoke("on",c,e,a)},fire:function(c,e,a){return this._invoke("fire",c,e,a)}};return{multipleSourcesWrapper:f,get:function(c){return"undefined"===typeof c?h:h[c]},add:function(c,e){if(c&&e instanceof k&&!h[c])return h[c]=e},getSearchSources:function(c,e){var a=c?(c+"").split(","):[],b=e?(e+"").split(","):[],f=[],d;for(d=0;d<a.length;d++)f.push({type:"report",id:a[d]});for(d=0;d<b.length;d++)f.push({type:"generic",id:b[d]});return{report:a,source:b,keys:f}},searchSource:k,findNamedSource:function(c,e){if(e){this.findNamedSource.findSource||(this.findNamedSource.findSource=function(a,b){if(b.multiple)for(var c=0;c<b.sources.length;c++){if(b.sources[c].instanceID===a)return b.sources[c]}else if(b.instanceID===a)return b});this.findNamedSource.warning||(this.findNamedSource.warning=function(a){RightNow.UI.DevelopmentHeader&&RightNow.UI.DevelopmentHeader.addJavascriptWarning(RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_D_SRCH_SRC_ID_RPT_ID_SRC_ID_LBL"),a))});var a=[],b=[];if("string"===typeof e||"number"===typeof e){e=(e+"").split(",");if(1<e.length){for(var g=0,d;g<e.length;g++)(d=this.findNamedSource.findSource(e[g],c))?a.push(d):b.push(e[g]);b.length&&this.findNamedSource.warning(b.join(", "));if(a.length)return 1<a.length?new f(a):a[0]}else if(a=this.findNamedSource.findSource(e[0],c))return a;!b.length&&this.findNamedSource.warning(e[0]);return c}if("object"===typeof e){for(g in e)e.hasOwnProperty(g)&&((d=this.findNamedSource.findSource(g,c))?(d=YUI().mix(d,e[g]),a.push(d)):b.push(g));b.length&&this.findNamedSource.warning(b.join(", "));if(a.length)return 1<a.length?new f(a):a[0]}}if(!c)throw Error("The widget extending from RightNow.SearchFilter doesn't have report_id or source_id attributes.");return c}}}();RightNow.SearchFilter=RightNow.Widgets.extend({constructor:function(){for(var f=l.getSearchSources(this.data.attrs.report_id,this.data.attrs.source_id),h=[],k=0,c,e;k<f.keys.length;k++)e=f.keys[k],c=l.get(e.type+e.id),c||(c=new l.searchSource(this.Y,e),l.add(e.type+e.id,c)),h.push(c);1<h.length&&(c=new l.multipleSourcesWrapper(h));this.searchSource=function(a){return l.findNamedSource(c,a)}}});RightNow.ResultsDisplay=RightNow.SearchFilter})();
RightNow.Widgets.AdvancedSearchDialog=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this.Y.one(this.baseSelector+"_TriggerLink").on("click",this._openDialog,this);}},_openDialog:function(evt){if(!this._dialog){var dialogDiv=this.Y.one(this.baseSelector+"_DialogContent");if(dialogDiv){var buttons=[{text:this.data.attrs.label_search_button,handler:{fn:this._performSearch,scope:this}},{text:this.data.attrs.label_cancel_button,handler:{fn:this._cancelFilters,scope:this}}];this._dialog=RightNow.UI.Dialog.actionDialog(this.data.attrs.label_dialog_title,dialogDiv,{buttons:buttons});this.Y.one("#"+this._dialog.get('id')).addClass("rn_AdvancedSearchDialog");RightNow.UI.show(dialogDiv);this._dialog.hideEvent.subscribe(function(){if(evt.target.focus){evt.target.focus();}},null,this);}}
this._dialogClosed=false;this._dialog.show();this._dialog.hideEvent.subscribe(this._cancelFilters,null,this);},_performSearch:function(){this._closeDialog();var searchPage=this.data.attrs.report_page_url;this.searchSource().fire("search",new RightNow.Event.EventObject(this,{filters:{report_id:this.data.attrs.report_id,reportPage:searchPage,newPage:top!==self||(searchPage!==""&&searchPage!=="{current_page}")||!RightNow.Url.isSameUrl(searchPage)}}));},_cancelFilters:function(){if(this._dialogClosed)return;this._closeDialog();this.searchSource().fire("reset",new RightNow.Event.EventObject(this,{data:{name:"all"},filters:{report_id:this.data.attrs.report_id}}));},_closeDialog:function(){this._dialogClosed=true;if(this._dialog)
this._dialog.hide();}});
RightNow.Widgets.KeywordText=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._textElement=this.Y.one(this.baseSelector+"_Text");this.data.js.initialValue=this._decoder(this.data.js.initialValue);if(this._textElement){this._searchedOn=this._textElement.get("value");if(this._searchedOn!==this.data.js.initialValue)
this._textElement.set("value",this.data.js.initialValue);this._setFilter();this._textElement.on("change",this._onChange,this);this.searchSource().on("keywordChanged",this._onChangedResponse,this).on("search",this._onGetFiltersRequest,this).on("reset",this._onResetRequest,this);this.searchSource(this.data.attrs.report_id).on("response",this._onChangedResponse,this);if(this.data.attrs.initial_focus)
this._textElement.focus();}}},_onChange:function(evt){this._eo.data=this._textElement.get("value");this._eo.filters.data=this._textElement.get("value");this.searchSource().fire("keywordChanged",this._eo);},_onGetFiltersRequest:function(type,args){this._eo.filters.data=this.Y.Lang.trim(this._textElement.get("value"));this._searchedOn=this._eo.filters.data;return this._eo;},_setFilter:function(){this._eo=new RightNow.Event.EventObject(this,{filters:{searchName:this.data.js.searchName,data:this.data.js.initialValue,rnSearchType:this.data.js.rnSearchType,report_id:this.data.attrs.report_id}});},_onChangedResponse:function(type,args){var data=RightNow.Event.getDataFromFiltersEventResponse(args,this.data.js.searchName),newValue=(data===null)?this.data.js.initialValue:data;newValue=this._decoder(newValue);if(this._textElement.get("value")!==newValue)
this._textElement.set("value",newValue);},_onResetRequest:function(type,args){if(!args[0]||args[0].data.name===this.data.js.searchName){this._textElement.set('value',this.data.js.initialValue);}
else if(args[0].data.name==='all'){this._textElement.set('value',this._searchedOn);}},_decoder:function(value){if(value)
return value.replace(/&gt;/g,'>').replace(/&lt;/g,'<').replace(/&#039;/g,"'").replace(/&quot;/g,'"');return value;}});
RightNow.Widgets.SearchButton=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._requestInProgress=false;this._searchButton=this.Y.one(this.baseSelector+"_SubmitButton");if(this._searchButton){this._enableClickListener();this.searchSource().on("response",this._enableClickListener,this);}}},_startSearch:function(evt){if(this._requestInProgress)return;if(!this.data.attrs.popup_window&&(!this.data.attrs.report_page_url&&(this.data.attrs.target==='_self')))
this._disableClickListener();if(this.Y.UA.ie){this._parentForm=this._parentForm||this.Y.one(this.baseSelector).ancestor("form");if(this._parentForm&&window.external&&"AutoCompleteSaveForm"in window.external){window.external.AutoCompleteSaveForm(this.Y.Node.getDOMNode(this._parentForm));}}
var searchPage=this.data.attrs.report_page_url;this.searchSource().fire("search",new RightNow.Event.EventObject(this,{filters:{report_id:this.data.attrs.report_id,source_id:this.data.attrs.source_id,reportPage:searchPage,newPage:top!==self||(searchPage!==""&&searchPage!=="{current_page}"&&!RightNow.Url.isSameUrl(searchPage)),target:this.data.attrs.target,popupWindow:this.data.attrs.popup_window,width:this.data.attrs.popup_window_width_percent,height:this.data.attrs.popup_window_height_percent}}));},_enableClickListener:function(){this._requestInProgress=false;this._searchButton.on("click",this._startSearch,this);},_disableClickListener:function(){this._requestInProgress=true;this._searchButton.detach("click",this._startSearch);}});
RightNow.Widgets.DisplaySearchFilters=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._filterCache={};this._currentDomID=0;this.searchSource().on('response',this._onReportResponse,this);this.Y.Array.each(this.data.js.filters,function(filter,index){var filterData=[],filterValue=filter.data[filter.data.length-1].id,templateData;this.Y.Array.each(filter.data,function(dataElement){filterData.push(this.buildFilterData(dataElement.id,filter.urlParameter,dataElement.label));},this);templateData=this.addFilterToCache(filter.urlParameter,filter.label,filterValue,filterData);this.Y.one('#'+templateData.removeLinkID).on('click',this._onFilterRemove,this,templateData.divID,filter.urlParameter);},this);}},_escapeHtml:function(string){var entityMap={'&amp;':'&','&lt;':'<','&gt;':'>','&quot;':'"','&#x27;':"'",'&#x2F;':'/','&#x60;':'`'};return this.Y.Escape.html((string+'').replace(/&[^;]+;/g,function(s){return entityMap[s]||s;}));},_onFilterRemove:function(evt,filterDomID,filterUrlParameter){var canonicalFilterName=(filterUrlParameter==='st')?'searchType':filterUrlParameter;eo=new RightNow.Event.EventObject(this,{filters:{report_id:this.data.attrs.report_id},data:{name:canonicalFilterName}});this.Y.one('#'+filterDomID).remove(true);this.searchSource().fire('reset',eo);this.searchSource().fire('excludeFilterFromNextSearch',eo);this.searchSource().fire('search',eo);},_onReportResponse:function(evt,args){var reportFilters=args[0].filters.allFilters,filterContainer=this.Y.one(this.baseSelector+'_FilterContainer'),hasFilters=false,filterValue,filterType,filterLabel,filter,Y=this.Y;Y.one(this.baseSelector).removeClass('rn_Hidden');filterContainer.get('childNodes').remove(true);for(filterType in reportFilters){if(Y.Array.indexOf(['p','c','searchType','org'],filterType)!==-1){if((filter=reportFilters[filterType])&&(filter=reportFilters[filterType].filters)&&filter.data){if(filterType==='p'||filterType==='c'){filterValue=(filter.data[0])?filter.data[0][filter.data[0].length-1]:null;}
else if(filterType==='searchType'){filterType='st';filterValue=(Y.Lang.isObject(filter.data))?filter.data.val:filter.data;}
else if(filterType==='org'){filterValue=(Y.Lang.isObject(filter.data))?filter.data.selected:filter.data;}
if(Y.Lang.isValue(filterValue)&&!Y.Lang.isObject(filterValue,true)&&!this.isDefaultFilter(filterType,filterValue)){if(!(templateData=this.getFilterFromCache(filterType,filterValue))){var filterData=[];if(filterType==='p'||filterType==='c'){filterLabel=(filterType==='p')?RightNow.Interface.getMessage('PRODUCT_LBL'):RightNow.Interface.getMessage('CATEGORY_LBL');Y.Array.each(filter.data.reconstructData,function(element,index){var prodcatValue=element.hierList.split(',');filterData.push(this.buildFilterData(prodcatValue[prodcatValue.length-1],filterType,element.label));},this);}
else if(filterType==='st'){filterLabel=RightNow.Interface.getMessage('SEARCH_TYPE_LBL');filterData.push(this.buildFilterData(filterValue,filterType,filter.data.label));}
else if(filterType==='org'){filterLabel=RightNow.Interface.getMessage('ORGANIZATION_LBL');filterData.push(this.buildFilterData(filterValue,filterType,filter.data.label));}
templateData=this.addFilterToCache(filterType,filterLabel,filterValue,filterData);}
filterContainer.append(new EJS({text:this.getStatic().templates.view}).render(templateData));filterContainer.one('#'+templateData.removeLinkID).on('click',this._onFilterRemove,this,templateData.divID,filterType);filterContainer.one('#'+templateData.filterData[templateData.filterData.length-1].linkID).set('href','javascript:void(0)');hasFilters=true;}}}}
if(!hasFilters){this.Y.one(this.baseSelector).addClass('rn_Hidden');}},isDefaultFilter:function(filterType,filterValue){var defaultFilters=this.data.js.defaultFilters,i;for(i=0;i<defaultFilters.length;i++){if(defaultFilters[i].name===filterType&&defaultFilters[i].defaultValue===filterValue){return true;}}
return false;},buildFilterData:function(filterValue,filterType,filterName){return{'linkID':this.baseDomID+'_Filter'+filterValue,'linkUrl':this.data.js.searchPage+filterType+'/'+filterValue,'label':this._escapeHtml(filterName)};},addFilterToCache:function(filterType,filterLabel,filterValue,filterData){if(!this._filterCache[filterType]){this._filterCache[filterType]={};this._filterCache[filterType].domID=this._currentDomID;this._currentDomID++;}
var domID=this._filterCache[filterType].domID;return(this._filterCache[filterType][filterValue]={'divID':this.baseDomID+'_Filter_'+domID,'label':filterLabel,'removeLinkID':this.baseDomID+'_Remove_'+domID,'labelFilterRemove':this.data.attrs.label_filter_remove,'removeIconPath':this.data.attrs.remove_icon_path,'filterData':filterData});},getFilterFromCache:function(filterType,filterValue){if(this._filterCache[filterType]&&this._filterCache[filterType][filterValue]){return this._filterCache[filterType][filterValue];}
return null;}});
RightNow.Widgets.ResultInfo=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._searchSources=0;if(this.data.attrs.display_knowledgebase_results){this.searchSource(this.data.attrs.report_id).on('response',this._onReportChanged,this);}
if(this.data.attrs.combined_results){this._searchTerm=this.data.js.searchTerm;if(this.data.js.social){if(this.data.js.social){this._searchSources++;}
this.searchSource(this.data.attrs.source_id).on('response',this._reportCombinedResults,this);}
this.searchSource().on('appendFilter',function(evt,args){if(args[0].filters.page&&args[0].data){this._page=args[0].data.page;}},this);this.searchSource(this.data.attrs.report_id).on('send',this._watchSearchFilterChange,this);}
if(this.data.js.error){RightNow.UI.Dialog.messageDialog(this.data.js.error,{"icon":"WARN"});}}},_onReportChanged:function(type,args)
{var newData=args[0].data,resultQuery="",parameterList=(this.data.attrs.add_params_to_url)?RightNow.Url.buildUrlLinkString(args[0].filters.allFilters,this.data.attrs.add_params_to_url):'';this._determineNewResults(args[0]);if(!this.data.attrs.combined_results&&this.data.attrs.display_results&&newData.search_term)
{var stopWords=newData.stopword,noDictWords=newData.not_dict,searchTerms=newData.search_term.split(" "),displayedNoResultsMsg=false;for(var i=0,word,strippedWord;i<searchTerms.length;i++)
{word=searchTerms[i];strippedWord=word.replace(/\W/,"");if(stopWords&&strippedWord&&stopWords.indexOf(strippedWord)!==-1)
word="<span class='rn_Strike' title='"+this.data.attrs.label_common+"'>"+word+"</span>";else if(noDictWords&&strippedWord&&noDictWords.indexOf(strippedWord)!==-1)
word="<span class='rn_Strike' title='"+this.data.attrs.label_dictionary+"'>"+word+"</span>";else
word="<a href='"+RightNow.Url.addParameter(this.data.js.linkUrl+encodeURIComponent(word.replace(/\&amp;/g,"&"))+parameterList+"/search/1","session",RightNow.Url.getSession())+"'>"+word+"</a>";resultQuery+=word+" ";}
resultQuery=this.Y.Lang.trim(resultQuery);}
var suggestedDiv=this.Y.one(this.baseSelector+"_Suggestion");if(suggestedDiv)
{if(newData.ss_data)
{var links=this.data.attrs.label_suggestion+" ";for(var i=0;i<newData.ss_data.length;i++)
links+='<a href="'+this.data.js.linkUrl+newData.ss_data[i]+'/suggested/1'+parameterList+'">'+newData.ss_data[i]+'</a>&nbsp;';suggestedDiv.set('innerHTML',links).removeClass('rn_Hidden');}
else
{RightNow.UI.hide(suggestedDiv);}}
var spellingDiv=this.Y.one(this.baseSelector+"_Spell");if(spellingDiv)
{if(newData.spelling)
{spellingDiv.set('innerHTML',this.data.attrs.label_spell+' <a href="'+this.data.js.linkUrl+newData.spelling+'/dym/1/'+parameterList+'">'+newData.spelling+' </a>').removeClass('rn_Hidden');}
else
{RightNow.UI.hide(spellingDiv);}}
this._updateSearchResults({searchTermToDisplay:resultQuery,userSearchedOn:newData.search_term,topics:newData.topics,truncated:newData.truncated});if(!this.data.attrs.combined_results)
{this.data.js.totalResults=0;this.data.js.firstResult=0;this.data.js.lastResult=0;}},_updateSearchResults:function(options)
{options=options||{};var noResultsDiv=this.Y.one(this.baseSelector+"_NoResults"),resultsDiv=this.Y.one(this.baseSelector+"_Results"),searchTermToDisplay=options.searchTermToDisplay,displayedNoResultsMsg=false;if(noResultsDiv)
{if(this.data.js.totalResults===0&&options.userSearchedOn&&(!options.topics||options.topics.length===0))
{noResultsDiv.set('innerHTML',this.data.attrs.label_no_results+"<br/><br/>"+this.data.attrs.label_no_results_suggestions).removeClass('rn_Hidden');displayedNoResultsMsg=true;}
else
{RightNow.UI.hide(noResultsDiv);}}
if(resultsDiv)
{if(!displayedNoResultsMsg&&!options.truncated)
{resultsDiv.set('innerHTML',(searchTermToDisplay&&searchTermToDisplay.length>0)?RightNow.Text.sprintf(this.data.attrs.label_results_search_query,this.data.js.firstResult,this.data.js.lastResult,this.data.js.totalResults,searchTermToDisplay):RightNow.Text.sprintf(this.data.attrs.label_results,this.data.js.firstResult,this.data.js.lastResult,this.data.js.totalResults));RightNow.UI.show(resultsDiv);}
else
{RightNow.UI.hide(resultsDiv);}}},_determineNewResults:function(eventObject){var reportData=eventObject.data;if(this.data.attrs.combined_results){if(this.data.js.totalResults===0||this.data.js.totalResults===this.data.js.combinedResults){this.data.js.totalResults+=reportData.total_num;}
if(typeof reportData.pruned==="number"){this.data.js.totalResults-=reportData.pruned;}
if(typeof this.data.js.prunedAnswers==="number"&&!reportData.pruned){reportData.start_num-=this.data.js.prunedAnswers;reportData.end_num-=this.data.js.prunedAnswers;reportData.pruned=true;}}
else{this.data.js.totalResults=reportData.total_num;}
this.data.js.firstResult=reportData.start_num;if(reportData.page!==1){this.data.js.firstResult+=this.data.js.combinedResults;}
if(this.data.js.firstResult===0&&this.data.js.combinedResults!==0){this.data.js.firstResult=1;}
this.data.js.lastResult=reportData.end_num+this.data.js.combinedResults;this._page=reportData.page;if(reportData.pruned&&eventObject.w_id&&eventObject.w_id.indexOf("CombinedSearchResults")>-1){this.data.js.prunedAnswers=(this.data.js.prunedAnswers===reportData.pruned)?false:reportData.pruned;}},_reportCombinedResults:function(evt,args){args=args[0];if(!args.data)return;var newTotal=0,argData=args.data,jsData=this.data.js;if(jsData.social&&argData.social){newTotal+=Math.min(argData.social.data.totalResults,20)||0;}
if(!this._page||this._page<2){jsData.combinedResults+=newTotal;jsData.lastResult+=newTotal;jsData.totalResults+=newTotal;jsData.firstResult=((jsData.combinedResults)?1:0);if(jsData.totalResults===0||this.data.js.combinedResults>0){this._updateSearchResults({userSearchedOn:true});}}},_watchSearchFilterChange:function(evt,args){args=args[0];if(!args)return;var filters=args.allFilters;if(filters&&((filters.keyword&&filters.keyword.filters.data!==this._searchTerm)||(filters.page===1))){this._page=1;this._searchTerm=filters.keyword.filters.data;this.data.js.totalResults=0;this.data.js.combinedResults=0;this.data.js.lastResult=0;this.data.js.firstResult=0;this.data.js.prunedAnswers=false;}}});
RightNow.Widgets.TopicWords=RightNow.ResultsDisplay.extend({overrides:{constructor:function(){this.parent();this.searchSource().on('response',this._onTopicWordsUpdate,this);}},_onTopicWordsUpdate:function(type,args)
{var eventObject=args[0],topicWordsDomList=this.Y.one(this.baseSelector+"_List"),root=this.Y.one(this.baseSelector),topicWordItems,linkString;if(!topicWordsDomList&&root)
{topicWordsDomList=this.Y.Node.create("<dl/>").set('id',this.baseDomID+"_List");root.appendChild(topicWordsDomList);}
if(topicWordsDomList)
{if(eventObject&&eventObject.data&&eventObject.data.topic_words&&eventObject.data.topic_words.length)
{topicWordItems=eventObject.data.topic_words;if(this.data.attrs.add_params_to_url)
{linkString=RightNow.Url.buildUrlLinkString(eventObject.filters.allFilters,this.data.attrs.add_params_to_url);}
topicWordsDomList.set('innerHTML',new EJS({text:this.getStatic().templates.view}).render({attrs:this.data.attrs,topicWordItems:topicWordItems,linkString:linkString||''}));RightNow.UI.show(root);}
else
{topicWordsDomList.set('innerHTML',"");RightNow.UI.hide(root);}}}});
RightNow.Widgets.Multiline=RightNow.ResultsDisplay.extend({overrides:{constructor:function(){this.parent();this._contentDiv=this.Y.one(this.baseSelector+"_Content");this._loadingDiv=this.Y.one(this.baseSelector+"_Loading");(RightNow.Event.isHistoryManagerFragment()&&this._setLoading(true));this.searchSource(this.data.attrs.report_id).on("response",this._onReportChanged,this).on("send",this._searchInProgress,this);this._setFilter();this._displayDialogIfError(this.data.js.error);}},_setFilter:function(){var eo=new RightNow.Event.EventObject(this,{filters:{token:this.data.js.r_tok,format:this.data.js.format,report_id:this.data.attrs.report_id,allFilters:this.data.js.filters}});eo.filters.format.parmList=this.data.attrs.add_params_to_url;this.searchSource().fire("setInitialFilters",eo);},_searchInProgress:function(evt,args){var params=args[1];if(!params||!params.newPage)
this._setLoading(true);},_setLoading:function(loading){if(this._contentDiv&&this._loadingDiv){var method,toOpacity,ariaBusy;if(loading){ariaBusy=true;method="addClass";toOpacity=0;this._contentDiv.setStyle("height",this._contentDiv.get("offsetHeight")+"px");}
else{ariaBusy=false;method="removeClass";toOpacity=1;this._contentDiv.setStyle("height","auto");}
document.body.setAttribute("aria-busy",ariaBusy+"");if(this.Y.UA.ie){this._contentDiv[method]("rn_Hidden");}
else{this._contentDiv.transition({opacity:toOpacity,duration:0.4});}
this._loadingDiv[method]("rn_Loading");}},_onReportChanged:function(type,args){var newdata=args[0].data,ariaLabel,firstLink,newContent="";this._displayDialogIfError(newdata.error);if(!this._contentDiv)return;if(newdata.total_num>0){ariaLabel=this.data.attrs.label_screen_reader_search_success_alert;newdata.hide_empty_columns=this.data.attrs.hide_empty_columns;newContent=new EJS({text:this.getStatic().templates.view}).render(newdata);}
else{ariaLabel=this.data.attrs.label_screen_reader_search_no_results_alert;}
this._updateAriaAlert(ariaLabel);this._contentDiv.set("innerHTML",newContent);if(this.data.attrs.hide_when_no_results){this.Y.one(this.baseSelector)[((newContent)?'removeClass':'addClass')]('rn_Hidden');}
this._setLoading(false);RightNow.Url.transformLinks(this._contentDiv);if(newdata.total_num&&(firstLink=this._contentDiv.one('a'))){firstLink.focus();}},_displayDialogIfError:function(error){if(error){RightNow.UI.Dialog.messageDialog(error,{"icon":"WARN"});}},_updateAriaAlert:function(text){if(!text)return;this._ariaAlert=this._ariaAlert||this.Y.one(this.baseSelector+"_Alert");if(this._ariaAlert){this._ariaAlert.set("innerHTML",text);}}});
RightNow.Widgets.Paginator=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._currentPage=this.data.js.currentPage;for(var i=this.data.js.startPage;i<=this.data.js.endPage;i++)
{var pageLinkID=this.baseSelector+"_PageLink_"+i;if(this.Y.one(pageLinkID))
this.Y.one(pageLinkID).on("click",this._onPageChange,this,i);}
this._instanceElement=this.Y.one(this.baseSelector);this._forwardButton=this.Y.one(this.baseSelector+"_Forward");this._forwardButton.on("click",this._onDirection,this,true);this._backButton=this.Y.one(this.baseSelector+"_Back");this._backButton.on("click",this._onDirection,this,false);this._eo=new RightNow.Event.EventObject(this,{filters:{report_id:this.data.attrs.report_id,per_page:this.data.attrs.per_page,page:this._currentPage}});this.searchSource(this.data.attrs.report_id).on("response",this._onReportChanged,this);}},_onPageChange:function(evt,pageNumber)
{evt.preventDefault();if(this._currentlyChangingPage||!pageNumber||pageNumber===this._currentPage)
return;this._currentlyChangingPage=true;pageNumber=(pageNumber<1)?1:pageNumber;this._eo.filters.page=this._currentPage=pageNumber;if(RightNow.Event.fire("evt_switchPagesRequest",this._eo)){this.searchSource().fire("appendFilter",this._eo).fire("search",this._eo);}},_onDirection:function(evt,isForward)
{evt.preventDefault();if(this._currentlyChangingPage)
return;this._currentlyChangingPage=true;if(isForward)
this._currentPage++;else
this._currentPage--;this._eo.filters.page=this._currentPage;if(RightNow.Event.fire("evt_switchPagesRequest",this._eo)){this.searchSource().fire("appendFilter",this._eo).fire("search",this._eo);}},_onReportChanged:function(type,args)
{var newData=args[0];newData=newData.data;if(args[0].filters.report_id==this.data.attrs.report_id)
{this._currentPage=newData.page;var totalPages=newData.total_pages;if(totalPages<2||newData.truncated)
{RightNow.UI.hide(this._instanceElement);}
else
{var pagesContainer=this.Y.one(this.baseSelector+"_Pages");if(pagesContainer)
{pagesContainer.set('innerHTML',"");var startPage,endPage;if(this.data.attrs.maximum_page_links===0)
startPage=endPage=this._currentPage;else if(totalPages>this.data.attrs.maximum_page_links)
{var split=Math.round(this.data.attrs.maximum_page_links/2);if(this._currentPage<=split)
{startPage=1;endPage=this.data.attrs.maximum_page_links;}
else
{var offsetFromMiddle=this._currentPage-split;var maxOffset=offsetFromMiddle+this.data.attrs.maximum_page_links;if(maxOffset<=newData.total_pages)
{startPage=1+offsetFromMiddle;endPage=maxOffset;}
else
{startPage=newData.total_pages-(this.data.attrs.maximum_page_links-1);endPage=newData.total_pages;}}}
else
{startPage=1;endPage=totalPages;}
for(var i=startPage,link,titleString;i<=endPage;i++)
{if(i===this._currentPage)
{link=this.Y.Node.create("<span/>").addClass("rn_CurrentPage").set('innerHTML',i);}
else
{link=this.Y.Node.create("<a/>").set('id',this.baseSelector+"_PageLink_"+i).set('href',this.data.js.pageUrl+i).set('innerHTML',i+'<span class="rn_ScreenReaderOnly">'+RightNow.Text.sprintf(this.data.attrs.label_page,i,totalPages)+'</span>');titleString=this.data.attrs.label_page;if(titleString)
{titleString=titleString.replace(/%s/,i).replace(/%s/,newData.total_pages);link.set('title',titleString);}}
pagesContainer.appendChild(link);link.on("click",this._onPageChange,this,i);}
RightNow.UI.show(this._instanceElement);}}
if(this._forwardButton)
{if(newData.total_pages>newData.page)
this._forwardButton.removeClass("rn_Hidden").set('href',this.data.js.pageUrl+(this._currentPage+1));else
RightNow.UI.hide(this._forwardButton);}
if(this._backButton)
{if(newData.page>1)
this._backButton.removeClass("rn_Hidden").set('href',this.data.js.pageUrl+(this._currentPage-1));else
RightNow.UI.hide(this._backButton);}}
this._currentlyChangingPage=false;}});
RightNow.Widgets.SearchTypeList=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._selectBox=this.Y.one(this.baseSelector+"_Options");if(!this._selectBox)
return;this._eo=new RightNow.Event.EventObject(this);this._selectBox.on("change",this._onSelectChange,this);this.searchSource().on("searchTypeChanged",this._onChangedResponse,this).on("search",function(){return this._eo;},this).on("reset",this._onResetRequest,this);this.searchSource(this.data.attrs.report_id).on("response",this._onChangedResponse,this);this._setFilter();this._setSelectedDropdownItem(this.data.js.defaultFilter);}},_onSelectChange:function()
{this._setSelected();this.searchSource().fire("searchTypeChanged",this._eo);if(this.data.attrs.search_on_select)
{this._eo.filters.reportPage=this.data.attrs.report_page_url;this.searchSource().fire("search",this._eo);}},_setSelectedDropdownItem:function(valueToSelect)
{this._selectBox.get("options").each(function(option,i){if(parseInt(option.get("value"),10)===valueToSelect){this._selectBox.set("selectedIndex",i);return;}},this);},_setSelected:function()
{var selectedOption=this._selectBox.get('options').item(this._selectBox.get('selectedIndex')),value=parseInt(selectedOption.get('value'),10),label=selectedOption.get('text'),node;for(node in this.data.js.filters)
{if(this.data.js.filters[node].fltr_id===value)
{this._setSelectedFilter(this.data.js.filters[node],label);}}},_setSelectedFilter:function(selected,label)
{this._eo.filters.fltr_id=selected.fltr_id;this._eo.filters.data={"val":selected.fltr_id};this._eo.filters.data.label=label;this._eo.filters.oper_id=selected.oper_id;},_setFilter:function()
{this._eo.filters={"rnSearchType":this.data.js.rnSearchType,"searchName":this.data.js.searchName,"report_id":this.data.attrs.report_id};for(var node in this.data.js.filters)
{if(this.data.js.filters[node].fltr_id===this.data.js.defaultFilter)
{this._setSelectedFilter(this.data.js.filters[node],this.data.js.filters[node].prompt);break;}}},_onResetRequest:function(type,args)
{if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id))
{if(args[0].data.name===this.data.js.searchName){this._setSelectedDropdownItem(this.data.js.resetFilter);this._setSelected();}
else if(args[0].data.name==='all'){this._setSelectedDropdownItem(this.data.js.defaultFilter);this._setSelected();}}},_onChangedResponse:function(type,args)
{if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id))
{var data=RightNow.Event.getDataFromFiltersEventResponse(args,this.data.js.searchName,this.data.attrs.report_id);this._setSelectedDropdownItem(((data&&data.val)?data.val:this.data.js.defaultFilter));this._setSelected();}}});
RightNow.Widgets.WebSearchSort=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._searchName="webSearchSort";this._optionsSelect=this.Y.one(this.baseSelector+"_Options");if(!this._optionsSelect)
return;this.searchSource().on("webSearchSortChanged",this._onChangedResponse,this).on("search",function(){return this._eo;},this).on("reset",this._onReset,this);this.searchSource(this.data.attrs.report_id).on("response",this._onChangedResponse,this);this._optionsSelect.on("change",this._onSortChange,this);this._setFilter();}},_setFilter:function()
{this._eo=new RightNow.Event.EventObject(this,{filters:{searchName:this._searchName,report_id:this.data.js.report_id}});this._setDataObject();},_setDataObject:function()
{this._eo.filters.data={"col_id":(this.data.js.sortDefault!=this.data.js.configDefault)?this.data.js.sortDefault:null,"sort_direction":1,"sort_order":1};},_setSelected:function()
{var num=this._optionsSelect.get('selectedIndex');if(this._optionsSelect.get('options').item(num))
{this._eo.filters.data.col_id=this._optionsSelect.get('options').item(num).get('value');}},_setSelectedDropdownItem:function(valueToSelect)
{this._optionsSelect.get('options').each(function(option,i){if(parseInt(option.get('value'),10)===valueToSelect)
{this._optionsSelect.set('selectedIndex',i);}},this);},_onSortChange:function()
{this._setSelected();this.searchSource().fire("webSearchSortChanged",this._eo);},_onChangedResponse:function(type,args)
{if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id))
{var data=RightNow.Event.getDataFromFiltersEventResponse(args,this._searchName,this.data.attrs.report_id);var newValue=(!data||data.col_id===null)?this.data.js.sortDefault:data.col_id;if(this._eo.filters.data===null)
this._setDataObject();this._setSelectedDropdownItem(newValue);this._setSelected();}},_onReset:function(type,args)
{if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id)&&(args[0].data.name===this._searchName||args[0].data.name==="all"))
{this._setSelectedDropdownItem(this.data.js.sortDefault);this._setDataObject();}}});
RightNow.Widgets.WebSearchType=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._optionsSelect=this.Y.one(this.baseSelector+"_Options");this._searchName="webSearchType";if(!this._optionsSelect)
return;this.searchSource().on("webSearchTypeChanged",this._onChangedResponse,this).on("search",function(){return this._eo;},this).on("reset",this._onReset,this);this.searchSource(this.data.attrs.report_id).on("response",this._onChangedResponse,this);this._optionsSelect.on("change",this._onSearchChange,this);this._eo=new RightNow.Event.EventObject(this,{filters:{searchName:this._searchName,report_id:this.data.js.report_id}});this._setFilter();}},_setFilter:function()
{this._eo.filters.data=this.data.js.searchDefault;},_setSelected:function()
{var num=this._optionsSelect.get('selectedIndex');if(this._optionsSelect.get('options').item(num))
{this._eo.filters.data=this._optionsSelect.get('options').item(num).get('value');}},_setSelectedDropdownItem:function(valueToSelect)
{this._optionsSelect.get('options').each(function(option,i){if(parseInt(option.get('value'),10)===valueToSelect)
{this._optionsSelect.set('selectedIndex',i);}},this);},_onSearchChange:function(evt)
{this._setSelected();this.searchSource().fire("webSearchTypeChanged",this._eo);},_onChangedResponse:function(type,args)
{if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id))
{var data=RightNow.Event.getDataFromFiltersEventResponse(args,this._searchName,this.data.attrs.report_id);var newValue=(!data)?this.data.js.searchDefault:data;this._setSelectedDropdownItem(newValue);this._setSelected();}},_onReset:function(type,args)
{if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id)&&(args[0].data.name===this._searchName||args[0].data.name==="all"))
{this._setSelectedDropdownItem(this.data.js.searchDefault);this._setFilter();}}});
RightNow.Widgets.ProductCategorySearchFilter=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._getFiltersRequest.lastInstance=this._getFiltersRequest.lastInstance||{};this._currentIndex=0;this._noValueNodeIndex=0;this._displayField=this.Y.one(this.baseSelector+"_"+this.data.attrs.filter_type+"_Button");this._displayFieldVisibleText=this.Y.one(this.baseSelector+"_ButtonVisibleText");this._accessibleView=this.Y.one(this.baseSelector+"_Links");this._outerTreeContainer=this.Y.one(this.baseSelector+"_TreeContainer");if(!this._displayField)return;this.searchSource(this.data.attrs.report_id).on('search',this._getFiltersRequest,this).on('response',this._onReportResponse,this).on('reset',this._onResetRequest,this);RightNow.Event.subscribe("evt_menuFilterGetResponse",this._getSubLevelResponse,this);RightNow.Event.subscribe("evt_accessibleTreeViewGetResponse",this._getAccessibleTreeViewResponse,this);this._displayField.on('click',this._toggleProductCategoryPicker,this);this.Y.one(this.baseSelector+"_LinksTrigger").on("click",this._toggleAccessibleView,this);this._initializeFilter();this._panel=new this.Y.Panel({srcNode:this._outerTreeContainer.removeClass('rn_Hidden'),width:300,visible:false,render:this.Y.one(this.baseSelector),headerContent:'',hideOn:[{eventName:'clickoutside'}],align:{node:this._displayField,points:[this.Y.WidgetPositionAlign.TL,this.Y.WidgetPositionAlign.BL]},zIndex:1000});this.Y.one(this.baseSelector+'_Tree').setStyle('overflow-y','auto');if(this.data.js.hierData[0].length){this._buildTree();}}},_buildTree:function(forceRebuild){if(this._tree&&!forceRebuild)return;var YAHOO=this.Y.Port(),gallery=this.Y.apm,treeDiv=document.getElementById("rn_"+this.instanceID+"_Tree");if(treeDiv&&gallery.TreeView)
{this._tree=new gallery.TreeView(treeDiv.id);this._tree.setDynamicLoad(RightNow.Event.createDelegate(this,this._getSubLevelRequest));this._tree.subscribe('focusChanged',function(e){if(e.newNode){this._treeCurrentFocus=e.newNode;}
else if(e.oldNode){this._treeCurrentFocus=e.oldNode;}},this);if(!this.data.attrs.show_confirm_button_in_dialog){this.Y.one(this._tree.getEl()).on('key',function(ev){var currentNode=this._treeCurrentFocus;if(currentNode.href){if(currentNode.target){window.open(currentNode.href,node.target);}
else{window.location(currentNode.href);}}
else{currentNode.toggle();}
this._tree.fireEvent('enterKeyPressed',currentNode);ev.halt();},'tab',this);}
var hasDefaultValue=false,hierData=this.data.js.hierData||this.data.js.hierDataNone,scope=this,insertNodes=function(nodeList,root){var dataNode,node,childNodes=[],i;for(i=0;i<nodeList.length;i++){dataNode=nodeList[i];node=new gallery.MenuNode(scope.Y.Escape.html(dataNode.label),root);node.href='javascript:void(0)';node.hierValue=dataNode.id;if(!dataNode.hasChildren){node.dynamicLoadComplete=true;node.iconMode=1;}
if(dataNode.selected){hasDefaultValue=true;scope._currentIndex=node.index;}
if(dataNode.hasChildren&&hierData[dataNode.id]){childNodes.push({children:hierData[dataNode.id],parent:node});}}
root.loadComplete();for(i=0;i<childNodes.length;i++){insertNodes(childNodes[i].children,childNodes[i].parent);}};if(this.data.js.hierData&&this.data.js.hierDataNone)
delete this.data.js.hierData;insertNodes(hierData[0],this._tree.getRoot());var noValueNode=this._tree.getRoot().children[0];noValueNode.isLeaf=true;this._noValueNodeIndex=noValueNode.index;this._tree.subscribe("enterKeyPressed",this._enterPressed,this);if(this.data.attrs.show_confirm_button_in_dialog)
{var confirmButton=this.Y.one(this.baseSelector+'_'+this.data.attrs.filter_type+'_ConfirmButton'),cancelButton=this.Y.one(this.baseSelector+'_'+this.data.attrs.filter_type+'_CancelButton');confirmButton.detach('click');cancelButton.detach('click');cancelButton.detach('keydown');confirmButton.on('click',function(){this._selectNode({node:this._treeCurrentFocus});},this);cancelButton.on('click',function(){this._panel.hide();},this);cancelButton.on('key',function(ev){!ev.shiftKey&&this._toggleProductCategoryPicker();},'tab',this);}
else
{this._tree.subscribe('clickEvent',this._selectNode,this);}
this._tree.subscribe('expandComplete',function(e){treeDiv.scrollTop=this.Y.one('#'+e.contentElId).ancestor('.ygtvitem').get('offsetTop');},this);this._tree.collapseAll();this.Y.one(this.baseSelector+'_Tree').setStyle('display','block');if(this.data.attrs.show_confirm_button_in_dialog)
this.Y.one(this.baseSelector+'_TreeContainer').setStyle("display","block");if(hasDefaultValue)
this._displaySelectedNodesAndClose(false);}},_displayAccessibleDialog:function()
{this._buildTree();if(!(this._dialog))
{var handleDismiss=function()
{this.hide();};this._buttons=[{text:RightNow.Interface.getMessage("CANCEL_CMD"),handler:handleDismiss,isDefault:false}];RightNow.UI.show(this._accessibleView);this._dialog=RightNow.UI.Dialog.actionDialog(this.data.attrs.label_nothing_selected,this._accessibleView,{"buttons":this._buttons});this._dialog.after('visibleChange',function(e)
{if(!e.newVal)
{this._displayField.focus();}},this);}
else
{var currentlySelectedSpan=document.getElementById(this.baseDomID+"_IntroCurrentSelection"),introLink=document.getElementById(this.baseDomID+"_Intro");if(currentlySelectedSpan&&introLink)
{var currentNode=this._tree.getNodeByIndex(this._currentIndex);if(!currentNode)
{currentNode={};currentNode.hierValue=0;}
var localID=this.baseDomID;introLink.onclick=function(){document.getElementById(localID+"_AccessibleLink_"+currentNode.hierValue).focus();};var selectedNodes=this._getSelectedNodesMessage();selectedNodes=selectedNodes[0]?selectedNodes.join(", "):this.data.attrs.label_all_values;currentlySelectedSpan.innerHTML=RightNow.Text.sprintf(RightNow.Interface.getMessage("SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG"),selectedNodes);}}
this.Y.Lang.later(1000,this._dialog,'show');},_toggleAccessibleView:function()
{if(this._dataType==="Category"&&this.data.js.linkingOn)
this._eo.data.linkingProduct=RightNow.UI.Form.currentProduct;if(this._flatTreeViewData)
this._displayAccessibleDialog();else
RightNow.Event.fire("evt_accessibleTreeViewRequest",this._eo);},_getAccessibleTreeViewResponse:function(e,args)
{if(args[0].data.hm_type!==this._eo.data.hm_type)return;var evtObj=args[0],i;if(evtObj.data.data_type===this._dataType)
{this._flatTreeViewData=evtObj.data.accessibleLinks;var noValue={0:this.data.attrs.label_all_values,1:0,hier_list:0,level:0};if(!this.Y.Lang.isArray(this._flatTreeViewData))
{var tempArray=[];for(i in this._flatTreeViewData)
{if(!isNaN(parseInt(i,10)))
tempArray[i]=this._flatTreeViewData[i];}
this._flatTreeViewData=tempArray;}
this._flatTreeViewData.unshift(noValue);var htmlList="<p><a href='javascript:void(0)' id='rn_"+this.instanceID+"_Intro'"+"onclick='document.getElementById(\"rn_"+this.instanceID+"_AccessibleLink_"+noValue[1]+"\").focus();'>"+RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_LNKS_DEPTH_ANNOUNCED_MSG"),this.data.attrs.label_input)+" <span id='rn_"+this.instanceID+"_IntroCurrentSelection'>"+RightNow.Text.sprintf(RightNow.Interface.getMessage("SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG"),noValue[0])+"</span></a></p>",previousLevel=-1;for(i in this._flatTreeViewData)
{if(this._flatTreeViewData.hasOwnProperty(i))
{var item=this._flatTreeViewData[i];if(item.level>previousLevel)
htmlList+="<ol>";while(item.level<previousLevel)
{htmlList+="</li></ol>";previousLevel--;}
if(item.level===previousLevel)
htmlList+="</li>";htmlList+='<li><a href="javascript:void(0)" id="rn_'+this.instanceID+'_AccessibleLink_'+item[1]+'" class="rn_AccessibleHierLink" hierList="'+item.hier_list+'">'+'<span class="rn_ScreenReaderOnly">'+this.data.attrs.label_level+' '+(item.level+1)+'</span>'+item[0]+'</a>';previousLevel=item.level;}}
for(i=previousLevel;i>=0;--i)
htmlList+="</li></ol>";htmlList+="<div id='rn_"+this.instanceID+"_AccessibleErrorLocation'></div>";this._accessibleView.set('innerHTML',htmlList);this._accessibleView.all('a.rn_AccessibleHierLink').on('click',this._accessibleLinkClick,this);this._displayAccessibleDialog();}},_accessibleLinkClick:function(e)
{this._expandAndCreateNodes(e.target.getAttribute("hierList").split(","));return false;},_toggleProductCategoryPicker:function(e)
{this._buildTree();if(!this._panel.get("visible"))
{this._panel.align().show();var currentNode=this._tree.getNodeByIndex(this._currentIndex)||this._tree.getRoot().children[0];if(currentNode&&currentNode.focus)
{currentNode.focus();}}},_getSelectedNodesMessage:function()
{return this._getPropertyChain("label");},_getPropertyChain:function(property)
{property=property||"label";this._currentIndex=this._currentIndex||1;var hierValues=[],currentNode=this._tree.getNodeByIndex(this._currentIndex);while(currentNode&&!currentNode.isRoot())
{hierValues.push(currentNode[property]);currentNode=currentNode.parent;}
return hierValues.reverse();},_displaySelectedNodesAndClose:function(focus)
{var hierValues,field,description,descText;this._eo.data.hierChain=this._getPropertyChain('hierValue');RightNow.Event.fire("evt_productCategoryFilterSelected",this._eo);delete this._eo.data.hierChain;this._panel.hide();this._displayField.setAttribute("aria-busy","true");if(this._currentIndex<=this._noValueNodeIndex)
{this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);descText=this.data.attrs.label_nothing_selected;}
else
{hierValues=this._getSelectedNodesMessage().join("<br>");this._displayFieldVisibleText.setHTML(hierValues);descText=this.data.attrs.label_screen_reader_selected+hierValues;}
description=this.Y.one(this.baseSelector+"_TreeDescription");if(description)
description.setHTML(descText);this._displayField.setAttribute("aria-busy","false");if(this._dialog&&this._dialog.get("visible"))
this._dialog.hide();if(focus&&this._displayField.focus&&!this._dialog)
try{this._displayField.focus();}catch(e){}},_enterPressed:function(keyEvent)
{this._selectNode({node:keyEvent.details[0]});},_selectNode:function(clickEvent)
{this._currentIndex=clickEvent.node.index;this._selected=true;this._getFiltersRequest.lastInstance[this.data.attrs.filter_type]=this.baseDomID;this._selectNode._selectedWidget=this.data.info.w_id;if((clickEvent.node.expanded||this._noValueNodeIndex===clickEvent.node.index)&&!this.data.js.linkingOn)
{this._eo.data.level=clickEvent.node.depth+1;if(this._eo.data.level!==this._eo.filters.data[0].length)
{this._eo.filters.data[0]=[];var currentNode=clickEvent.node;while(currentNode&&!currentNode.isRoot())
{this._eo.filters.data[0][currentNode.depth]=currentNode.hierValue;currentNode=currentNode.parent;}}
else
{this._eo.filters.data[0][this._eo.data.level-1]=clickEvent.node.hierValue||this._eo.data.value;for(var i=this._eo.data.level;i<this._eo.filters.data[0].length;i++)
delete this._eo.filters.data[0][i];}}
else if(this.data.attrs.search_on_select&&!RightNow.Url.isSameUrl(this.data.attrs.report_page_url))
{this._eo.data.level=clickEvent.node.depth+1;this._eo.data.label=clickEvent.node.label;this._eo.data.value=clickEvent.node.hierValue;this._eo.filters.data[0][clickEvent.node.depth]=clickEvent.node.hierValue;}
else
{this._getSubLevelRequest(clickEvent.node);this._tree.collapseAll();}
this._displaySelectedNodesAndClose(true);if(clickEvent.event)
clickEvent.event.preventDefault();if(this.data.attrs.search_on_select)
{this._eo.filters.reportPage=this.data.attrs.report_page_url;this.searchSource().fire('search',this._eo);}
return false;},_getSubLevelRequest:function(expandingNode)
{if(this._nodeBeingExpanded||(expandingNode.expanded&&!this.data.js.linkingOn))return;this._nodeBeingExpanded=true;this._eo.data.level=expandingNode.depth+1;this._eo.data.label=expandingNode.label;this._eo.data.value=expandingNode.hierValue;if(this.data.attrs.show_confirm_button_in_dialog)
this._requestedIndex=expandingNode.index;else
this._currentIndex=expandingNode.index;this._getSubLevelRequest._origRequest=this._getSubLevelRequest._origRequest||[];this._getSubLevelRequest._origRequest[this._dataType]=expandingNode.hierValue;if(this._dataType==="Product")
{RightNow.UI.Form.currentProduct=this._eo.data.value;}
if(this._eo.data.value<1&&this._eo.data.linking_on)
{this._eo.data.reset=true;if(this._eo.data.value===0&&this._dataType==="Product")
{this._eo.data.reset=false;this.searchSource().fire('reset',new RightNow.Event.EventObject(this,{data:{name:'c',reset:true}}));this._nodeBeingExpanded=false;return;}
else
{this._eo.data.value=0;}}
else
{this._eo.data.reset=false;}
if(this.data.js.link_map)
{this._eo.data.link_map=this.data.js.link_map;this.data.js.link_map=null;}
if(this._eo.data.level!==this._eo.filters.data[0].length)
{this._eo.filters.data[0]=[];var currentNode=expandingNode;while(currentNode&&!currentNode.isRoot())
{this._eo.filters.data[0][currentNode.depth]=currentNode.hierValue;currentNode=currentNode.parent;}}
else
{this._eo.filters.data[0][this._eo.data.level-1]=this._eo.data.value;for(var i=this._eo.data.level;i<this._eo.filters.data[0].length;i++)
delete this._eo.filters.data[0][i];}
if(!expandingNode.dynamicLoadComplete||this.data.js.linkingOn)
RightNow.Event.fire("evt_menuFilterRequest",this._eo);if(this._eo.data.link_map)
delete this._eo.data.link_map;this._nodeBeingExpanded=false;},_onReportResponse:function(type,args)
{var data=RightNow.Event.getDataFromFiltersEventResponse(args,this.data.js.searchName);this._getFiltersRequest.cachedWidgetHier={};if(data[0]&&data[0].length){this._buildTree();if(typeof data[0]==="string")
data[0]=data[0].split(",");var finalData=RightNow.Lang.arrayFilter(data[0]);var fromHistoryManager=args&&args[0]&&args[0].data&&args[0].data.fromHistoryManager;this._expandAndCreateNodes(finalData,fromHistoryManager);this._eo.filters.data[0]=finalData;this._lastSearchValue=finalData.slice(0);if(this._eo.filters.data.reconstructData){this._eo.filters.data.level=this._eo.filters.data.reconstructData.level;this._eo.filters.data.label=this._eo.filters.data.reconstructData.label;}}
else{this._eo.filters.data[0]=[];if(this._tree){this._currentIndex=this._noValueNodeIndex;this._displaySelectedNodesAndClose();}}},_expandAndCreateNodes:function(hierArray,fromHistoryManager)
{var i=hierArray.length-1,currentNode=null;while(!currentNode&&i>=0){currentNode=this._tree.getNodeByProperty("hierValue",parseInt(hierArray[i],10));i--;}
if(this._dataType==="Category"&&this.data.js.linkingOn&&fromHistoryManager){this._restorationHierArray=hierArray;}
if(!currentNode){return;}
if(this._currentIndex===currentNode.index)
{if(this._dialog&&this._dialog.get("visible"))
this._dialog.hide();return;}
i++;if(this._noValueNodeIndex===currentNode.index||currentNode.hierValue===hierArray[hierArray.length-1]){this._selectNode({node:currentNode});}
else{var onExpandComplete=function(expandingNode){if(expandingNode.nextToExpand){var nextNode=this._tree.getNodeByProperty("hierValue",parseInt(expandingNode.nextToExpand,10));if(nextNode){nextNode.nextToExpand=hierArray[++i];nextNode.expand();}}
else if(i===hierArray.length){this._tree.unsubscribe("expandComplete",onExpandComplete,null);expandingNode.expanded=false;this._selectNode({node:expandingNode});}
return true;};this._tree.subscribe("expandComplete",onExpandComplete,this);currentNode.nextToExpand=hierArray[++i];currentNode.expand();}},_getSubLevelResponse:function(type,args)
{var evtObj=args[0];if((evtObj.data.data_type!==this._dataType)||(evtObj.filters.report_id!==this.data.attrs.report_id))
return;if(this.data.js.link_map)
delete this.data.js.link_map;var hierLevel=evtObj.data.level,hierData=evtObj.data.hier_data,redisplaySelectedNode=false,currentRoot,tempNode;this._buildTree();if(!evtObj.data.reset_linked_category&&this._getSubLevelRequest._origRequest&&this._getSubLevelRequest._origRequest[this._dataType])
{currentRoot=this._tree.getNodeByProperty("hierValue",this._getSubLevelRequest._origRequest[this._dataType]);if(currentRoot&&currentRoot.index!==(this.data.attrs.show_confirm_button_in_dialog?this._requestedIndex:this._currentIndex))
{this._currentIndex=currentRoot.index;redisplaySelectedNode=true;}}
else if(evtObj.data.reset_linked_category)
{currentRoot=this._tree.getRoot();currentRoot.dynamicLoadComplete=false;this._tree.removeChildren(currentRoot);this._flatTreeViewData=null;tempNode=new this.Y.apm.MenuNode(this.Y.Escape.html(this.data.attrs.label_all_values),currentRoot,false);tempNode.hierValue=0;tempNode.href='javascript:void(0);';tempNode.isLeaf=true;this._noValueNodeIndex=this._currentIndex=this._requestedIndex=tempNode.index;this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);var description=this.Y.one(this.baseSelector+"_TreeDescription");if(description)
description.setHTML(this.data.attrs.label_nothing_selected);}
if(hierLevel<7&&currentRoot&&!currentRoot.dynamicLoadComplete)
{for(var i=0;i<hierData.length;i++)
{tempNode=new this.Y.apm.MenuNode(this.Y.Escape.html(hierData[i].label),currentRoot,false);tempNode.hierValue=hierData[i].id;tempNode.href='javascript:void(0);';if(!hierData[i].hasChildren||hierLevel===6)
{tempNode.dynamicLoadComplete=true;tempNode.iconMode=1;}}
currentRoot.loadComplete();}
if(hierData.length===0&&!this._selected)
{this._displaySelectedNodesAndClose();}
else if(this._selected)
{this._selected=false;}
else if(redisplaySelectedNode&&this._selectNode._selectedWidget)
{this._selectNode._selectedWidget=null;this._displaySelectedNodesAndClose();}
if(this._restorationHierArray){var hierArray=this._restorationHierArray;this._restorationHierArray=null;this._expandAndCreateNodes(hierArray);tempNode=this._tree.getNodeByProperty("hierValue",parseInt(hierArray[hierArray.length-1],10));if(tempNode)
this._selectNode({node:tempNode});}},_getFiltersRequest:function(type,args)
{this._getFiltersRequest.lastInstance[this.data.attrs.filter_type]=this._getFiltersRequest.lastInstance[this.data.attrs.filter_type]||null;this._getFiltersRequest.cachedWidgetHier=this._getFiltersRequest.cachedWidgetHier||{};var filterName=(this._eo.filters.searchName||"")+this.data.attrs.report_id,filterKey=filterName+this.baseDomID,mostRecentFilterKey=filterName+this._getFiltersRequest.lastInstance[this.data.attrs.filter_type],cachedHier=this._getFiltersRequest.cachedWidgetHier[mostRecentFilterKey];this._eo.filters.data.reconstructData=[];if(this._tree&&this._currentIndex&&this._currentIndex!==this._noValueNodeIndex)
{var currentNode=this._tree.getNodeByIndex(this._currentIndex),hierValues,level;this._eo.data.level=currentNode.depth+1;this._eo.data.label=currentNode.label;this._eo.data.value=currentNode.hierValue;while(currentNode&&!currentNode.isRoot())
{level=currentNode.depth+1;hierValues=this._eo.filters.data[0].slice(0,level).join(",");this._eo.filters.data.reconstructData.push({"level":level,"label":currentNode.label,"hierList":hierValues});currentNode=currentNode.parent;}
this._eo.filters.data.reconstructData.reverse();if(cachedHier&&filterKey!==mostRecentFilterKey){this._eo.filters.data=cachedHier;}
else{this._getFiltersRequest.cachedWidgetHier[filterKey]=RightNow.Lang.cloneObject(this._eo.filters.data);}}
else if(cachedHier)
{this._eo.filters.data=cachedHier;this._eo.data.value=cachedHier[0][0];}
else
{this._eo.filters.data[0]=[];this._eo.data.value=0;}
this._lastSearchValue=this._eo.filters.data[0].slice(0);return this._eo;},_onResetRequest:function(type,args)
{args=args[0];if(this._tree&&(!args||args.data.name==='all'||args.data.name===this.data.js.searchName))
{if(args&&args.data.name==="all"&&this._lastSearchValue)
{this._eo.filters.data[0]=this._lastSearchValue;var currentNode=this._tree.getNodeByProperty("hierValue",this._lastSearchValue[this._lastSearchValue.length-1]);this._currentIndex=currentNode?currentNode.index:this._noValueNodeIndex;}
else
{if(args&&args.data.reset&&this.data.js.linkingOn&&this._dataType==="Category")
{RightNow.Event.fire('evt_resetFilterRequest',args);if(this.data.js.link_map)
delete this.data.js.link_map;this._buildTree(true);}
if(!args)
this._eo.filters.data=[(this.data.js.initial)?this.data.js.initial:[]];else
this._eo.filters.data[0]=[];this._lastSearchValue=this._eo.filters.data[0].slice(0);this._currentIndex=this._tree.getNodeByProperty("hierValue",this._lastSearchValue[this._lastSearchValue.length-1]).index;this._getFiltersRequest.cachedWidgetHier={};}
this._displaySelectedNodesAndClose();}},_initializeFilter:function()
{this._eo=new RightNow.Event.EventObject(this,{data:{data_type:this._dataType=this.data.attrs.filter_type,linking_on:this.data.js.linkingOn,cache:[],hm_type:this.data.js.hm_type,linkingProduct:0},filters:{rnSearchType:"menufilter",searchName:this.data.js.searchName,report_id:this.data.attrs.report_id,fltr_id:this.data.js.fltr_id,oper_id:this.data.js.oper_id,data:[(this.data.js.initial)?this.data.js.initial:[]]}});this._lastSearchValue=this._eo.filters.data[0].slice(0);if(this._dataType==="Product")
{RightNow.UI.Form.currentProduct=this._eo.filters.data[0][this._eo.filters.data[0].length-1];}}});
RightNow.Widgets.FilterDropdown=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._eo=new RightNow.Event.EventObject(this);this._selectBox=this.Y.one(this.baseSelector+"_Options");this._selectBox.on("change",this._onSelectChange,this);this.searchSource().on("search",function(){return this._eo;},this).on("reset",this._onResetRequest,this);this.searchSource(this.data.attrs.report_id).on("response",this._onChangedResponse,this);this._setSelectedDropdownItem(this.data.js.defaultValue);this._setFilter();this.lastValue=this._eo.filters.data.val;}},_onSelectChange:function()
{this.lastValue=this._eo.filters.data.val;this._eo.filters.data.val=this._getSelected();if(this.data.attrs.search_on_select)
{this._eo.filters.reportPage=this.data.attrs.report_page_url;this.searchSource().fire("search",this._eo);}},_getSelected:function()
{return this._selectBox.get('options').item(this._selectBox.get('selectedIndex')).get('value');},_setSelectedDropdownItem:function(valueToSelect)
{this._selectBox.get("options").each(function(option,i){if(option.get("value")===(valueToSelect+'')){this._selectBox.set("selectedIndex",i);return;}},this);},_setFilter:function()
{this._eo.filters={"searchName":this.data.js.searchName,"rnSearchType":this.data.js.rnSearchType,"report_id":this.data.attrs.report_id,"data":{"fltr_id":this.data.js.filters.fltr_id,"oper_id":this.data.js.filters.oper_id,"val":this._getSelected()}};},_onChangedResponse:function(type,args)
{var data=RightNow.Event.getDataFromFiltersEventResponse(args,this.data.js.searchName,this.data.attrs.report_id),newValue=this._eo.filters.data.val,allFilters;if(data&&data.fltr_id===this.data.js.filters.fltr_id){newValue=data.val||this.data.js.defaultValue;}
else if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id)){allFilters=args[0].filters.allFilters[this.data.js.searchName];if(!allFilters){newValue=this.data.js.defaultValue;}}
if(newValue!==this._eo.filters.data.val){this._setSelectedDropdownItem(newValue);this._eo.filters.data.val=this.lastValue=newValue;}},_onResetRequest:function(type,args)
{var resetValue=this._eo.filters.data.val;if(RightNow.Event.isSameReportID(args,this.data.attrs.report_id)&&(args[0].data.name===this.data.js.searchName||args[0].data.name==="all"))
{if(args[0].data.name===this.data.js.searchName){resetValue=this.lastValue=this.data.js.defaultValue;}
else if(args[0].data.name==='all'){resetValue=this.lastValue||resetValue;}
if(resetValue!==this._eo.filters.data.val){this._setSelectedDropdownItem(resetValue);this._eo.filters.data.val=resetValue;}}}});
RightNow.Widgets.SortList=RightNow.SearchFilter.extend({overrides:{constructor:function(){this.parent();this._headingsSelect=this.Y.one(this.baseSelector+"_Headings");this._directionSelect=this.Y.one(this.baseSelector+"_Direction");RightNow.Event.on("evt_sortChange",this._onResponse,this);this.searchSource().on("search",this._onSearch,this).on("reset",this._onReset,this);this.searchSource(this.data.attrs.report_id).on("response",this._onResponse,this);this._setFilter();this._setSelectedDropdownItem(this._headingsSelect,this.data.js.col_id);this._setSelectedDropdownItem(this._directionSelect,this.data.js.sort_direction);this._headingsSelect.on("change",this._onChange,this,"column");this._directionSelect.on("change",this._onChange,this,"direction");}},_onChange:function(evt,dropdownThatChanged){this._setEventObjectFromUI(dropdownThatChanged);RightNow.Event.fire("evt_sortChange",this._eo);if(this.data.attrs.search_on_select){this._eo.filters.reportPage=this.data.attrs.report_page_url;this.searchSource().fire("search",this._eo);}},_setEventObjectFromUI:function(dropdownThatChanged){var selectBox,memberToSet,index;if(dropdownThatChanged==="direction"){selectBox=this._directionSelect;memberToSet="sort_direction";}
else{selectBox=this._headingsSelect;memberToSet="col_id";}
if(selectBox){index=selectBox.get("selectedIndex");index=(index>0)?index:0;this._eo.filters.data[memberToSet]=parseInt(selectBox.get("options").item(index).get("value"),10);}},_setSelectedDropdownItem:function(selectBox,valueToSelect){if(selectBox){selectBox.get("options").each(function(option,i){if(parseInt(option.get("value"),10)===valueToSelect){selectBox.set("selectedIndex",i);return true;}});}
return false;},_setFilter:function(){this._eo=new RightNow.Event.EventObject(this,{filters:{searchName:this.data.js.searchName,report_id:this.data.attrs.report_id,data:this._getDataObject()}});},_getDataObject:function(){return{col_id:this.data.js.col_id,sort_direction:this.data.js.sort_direction};},_onResponse:function(name,args){if(args[0].w_id===this.instanceID)return;var data=RightNow.Event.getDataFromFiltersEventResponse(args,this.data.js.searchName,this.data.attrs.report_id);if(this._eo.filters.data===null){this._eo.filters.data=this._getDataObject();}
this._setSelectedDropdownItem(this._headingsSelect,((!data||data.col_id==null)?this.data.js.col_id:data.col_id));this._setEventObjectFromUI("column");this._setSelectedDropdownItem(this._directionSelect,((!data||data.sort_direction==null)?this.data.js.sort_direction:data.sort_direction));this._setEventObjectFromUI("direction");},_onReset:function(type,args){if(!args[0]||args[0].data.name===this.data.js.searchName||args[0].data.name==="all"){this._setSelectedDropdownItem(this._headingsSelect,this.data.js.col_id);this._setSelectedDropdownItem(this._directionSelect,this.data.js.sort_direction);this._setFilter();}},_onSearch:function(type,args){return this._eo;}});