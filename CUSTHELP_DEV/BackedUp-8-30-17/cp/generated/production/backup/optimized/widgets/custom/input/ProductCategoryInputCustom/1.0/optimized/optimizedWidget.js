RightNow.namespace('Custom.Widgets.input.ProductCategoryInputCustom');Custom.Widgets.input.ProductCategoryInputCustom=RightNow.Field.extend({overrides:{constructor:function(){this.parent();this._currentIndex=0;this._noValueNodeIndex=0;this._maxDepth=this.data.attrs.max_lvl||6;this._displayField=this.Y.one(this.baseSelector+"_"+this.data.attrs.data_type+"_Button");this._displayFieldVisibleText=this.Y.one(this.baseSelector+"_Button_Visible_Text");this._accessibleView=this.Y.one(this.baseSelector+"_Links");this._outerTreeContainer=this.Y.one(this.baseSelector+"_TreeContainer");this._treeNode=this.Y.one(this.baseSelector+"_Tree");this._notRequiredDueToProductLinking=false;if(this.data.js.readOnly||!this._displayField)return;var RightNowEvent=RightNow.Event;RightNowEvent.subscribe("evt_resetSelection",this._resetSelection,this);RightNowEvent.subscribe("evt_menuFilterGetResponse",this._getSubLevelResponse,this);this.parentForm().on('submit',this._onValidate,this);RightNowEvent.subscribe("evt_accessibleTreeViewGetResponse",this._getAccessibleTreeViewResponse,this);if(this.data.attrs.set_button)
this.Y.one(this.baseSelector+"_"+this.data.attrs.data_type+"_SetButton").on("click",this._setButtonClick,this);if(this.data.attrs.hint)
this._hintOverlay=this._initializeHint();this._displayField.on("click",this._toggleProductCategoryPicker,this);this.Y.one(this.baseSelector+"_LinksTrigger").on("click",this._toggleAccessibleView,this);this._eo=new RightNow.Event.EventObject(this,{data:{data_type:this.data.attrs.data_type,hm_type:this.data.js.hm_type,linking_on:this.data.js.linkingOn,linkingProduct:0,table:"Incident",cache:[],name:((this.data.attrs.data_type.indexOf('prod')>-1)?'prod':'cat')}});this._buildMenuPanel();if(this.data.js.hierData[0].length)
this._buildTree();this.on('constraintChange:required_lvl',this.updateRequiredLevel,this);},_initializeHint:function()
{if(this.Y.Overlay)
{var overlay;if(this.data.attrs.always_show_hint)
{overlay=this._createHintElement(true);}
else
{overlay=this._createHintElement(false);this._displayField.on("focus",function(){overlay.show();});this._displayField.on("blur",function(){overlay.hide();});}
return overlay;}
else
{var hint=this.Y.Node.create('<span class="rn_HintText"/>').setHTML(this.data.attrs.hint);this._displayField.insert(hint,'after');}}},_buildMenuPanel:function(){this._panel=new this.Y.Panel({srcNode:this._outerTreeContainer.removeClass('rn_Hidden'),width:300,visible:false,render:this.Y.one(this.baseSelector),headerContent:null,buttons:[],hideOn:[{eventName:'clickoutside'}],align:{node:this._displayField,points:[this.Y.WidgetPositionAlign.TL,this.Y.WidgetPositionAlign.BL]},zIndex:2});this._panel.on('visibleChange',function(e){if(e.newVal){this._treeNode.setStyle("display","block");}
else{this._treeNode.setStyle("display","none");if(this.data.attrs.hint&&!this.data.attrs.always_show_hint){this._toggleHint("hide");}}},this);this._treeNode.setStyle('overflow-y','auto');},_buildTree:function()
{var YAHOO=this.Y.Port(),gallery=this.Y.apm;if(this._treeNode&&gallery.TreeView)
{this._tree=new gallery.TreeView(this._treeNode.get('id'));this._tree.setDynamicLoad(RightNow.Event.createDelegate(this,this._getSubLevelRequest));this._tree.subscribe('focusChanged',function(e){if(e.newNode){this._treeCurrentFocus=e.newNode;}
else if(e.oldNode){this._treeCurrentFocus=e.oldNode;}},this);if(!this.data.attrs.show_confirm_button_in_dialog){YAHOO.util.Event.on(this._tree.getEl(),"keyup",function(ev){if(ev.keyCode===RightNow.UI.KeyMap.TAB)
{var currentNode=this._treeCurrentFocus;if(currentNode.href){if(currentNode.target){window.open(currentNode.href,currentNode.target);}
else{window.location(currentNode.href);}}
else{currentNode.toggle();}
this._tree.fireEvent('enterKeyPressed',currentNode);YAHOO.util.Event.preventDefault(ev);}},null,this);}
var hasDefaultValue=false,hierData=this.data.js.hierData||this.data.js.hierDataNone,scope=this,insertNodes=function(nodeList,root){var dataNode,node,childNodes=[],i;for(i=0;i<nodeList.length;i++){dataNode=nodeList[i];node=new gallery.MenuNode(scope.Y.Escape.html(dataNode.label),root);node.href='javascript:void(0)';node.hierValue=dataNode.id;if(!dataNode.hasChildren){node.dynamicLoadComplete=true;node.iconMode=1;}
if(dataNode.selected){hasDefaultValue=true;scope._currentIndex=node.index;}
if(dataNode.hasChildren&&hierData[dataNode.id]){childNodes.push({children:hierData[dataNode.id],parent:node});}}
root.loadComplete();for(i=0;i<childNodes.length;i++){insertNodes(childNodes[i].children,childNodes[i].parent);}};if(this.data.js.hierData&&this.data.js.hierDataNone)
delete this.data.js.hierData;insertNodes(hierData[0],this._tree.getRoot());var noValueNode=this._tree.getRoot().children[0];noValueNode.isLeaf=true;this._noValueNodeIndex=noValueNode.index;this._tree.subscribe("enterKeyPressed",this._enterPressed,this);if(this.data.attrs.show_confirm_button_in_dialog)
{var confirmButton=this.Y.one(this.baseSelector+'_'+this.data.attrs.data_type+'_ConfirmButton'),cancelButton=this.Y.one(this.baseSelector+'_'+this.data.attrs.data_type+'_CancelButton');confirmButton.detach('click');cancelButton.detach('click');cancelButton.detach('keydown');confirmButton.on('click',function(){this._selectNode({node:this._treeCurrentFocus});},this);cancelButton.on('click',function(){this._panel.hide();},this);cancelButton.on('key',function(ev){!ev.shiftKey&&this._toggleProductCategoryPicker();},'tab',this);}
else
{this._tree.subscribe('clickEvent',this._selectNode,this);}
this._tree.subscribe('expandComplete',function(e){this._treeNode.set('scrollTop',this.Y.one('#'+e.contentElId).ancestor('.ygtvitem').get('offsetTop'));},this);this._tree.collapseAll();if(this.data.attrs.show_confirm_button_in_dialog)
this._outerTreeContainer.setStyle("display","block");this._treeNode.setStyle("display","block");if(hasDefaultValue)
this._displaySelectedNodesAndClose(false);}},_levelOfNode:function(node)
{return(node===null||typeof node.depth==="undefined")?0:node.depth+1;},_displayAccessibleDialog:function()
{if(!this._tree)
this._buildTree();if(!(this._dialog))
{var handleDismiss=function()
{this.hide();};this._buttons=[{text:RightNow.Interface.getMessage("CANCEL_CMD"),handler:handleDismiss,isDefault:false}];RightNow.UI.show(this._accessibleView);this._dialog=RightNow.UI.Dialog.actionDialog(this.data.attrs.label_nothing_selected,this._accessibleView,{"buttons":this._buttons});this._dialog.after('visibleChange',function(e)
{if(!e.newVal)
{this._displayField.focus();}},this);}
else
{var currentlySelectedSpan=document.getElementById(this.baseDomID+"_IntroCurrentSelection");var introLink=document.getElementById(this.baseDomID+"_Intro");if(currentlySelectedSpan&&introLink)
{var currentNode=this._tree.getNodeByIndex(this._currentIndex);if(!currentNode)
{currentNode={};currentNode.hierValue=0;}
var localInstanceID=this.instanceID;introLink.onclick=function(){document.getElementById("rn_"+localInstanceID+"_AccessibleLink_"+currentNode.hierValue).focus();};var selectedNodes=this._getSelectedNodesMessage();selectedNodes=selectedNodes[0]?selectedNodes.join(", "):this.data.attrs.label_all_values;currentlySelectedSpan.innerHTML=RightNow.Text.sprintf(RightNow.Interface.getMessage("SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG"),selectedNodes);}}
this._dialog.show();},_toggleAccessibleView:function()
{if(this.data.attrs.data_type==="Category"&&this.data.js.linkingOn)
this._eo.data.linkingProduct=RightNow.UI.Form.currentProduct;if(this._flatTreeViewData)
this._displayAccessibleDialog();else
RightNow.Event.fire("evt_accessibleTreeViewRequest",this._eo);},_getAccessibleTreeViewResponse:function(e,args)
{if(args[0].data.hm_type!=this._eo.data.hm_type)
return;var evtObj=args[0];if(evtObj.data.data_type==this.data.attrs.data_type)
{this._flatTreeViewData=evtObj.data.accessibleLinks;var noValue={0:this.data.attrs.label_all_values,1:0,hier_list:0,level:0};if(!this.Y.Lang.isArray(this._flatTreeViewData))
{var tempArray=[];for(var i in this._flatTreeViewData)
{if(!isNaN(parseInt(i,10)))
tempArray[i]=this._flatTreeViewData[i];}
this._flatTreeViewData=tempArray;}
this._flatTreeViewData.unshift(noValue);var htmlList="<p><a href='javascript:void(0)' id='rn_"+this.instanceID+"_Intro'"+"onclick='document.getElementById(\"rn_"+this.instanceID+"_AccessibleLink_"+noValue[1]+"\").focus();'>"+RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_LNKS_DEPTH_ANNOUNCED_MSG"),this.data.attrs.label_input)+" <span id='rn_"+this.instanceID+"_IntroCurrentSelection'>"+RightNow.Text.sprintf(RightNow.Interface.getMessage("SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG"),noValue[0])+"</span></a></p>",previousLevel=-1;for(i in this._flatTreeViewData)
{if(this._flatTreeViewData.hasOwnProperty(i))
{var item=this._flatTreeViewData[i];if(item.level>previousLevel)
htmlList+="<ol>";while(item.level<previousLevel)
{htmlList+="</li></ol>";previousLevel--;}
if(item.level===previousLevel){htmlList+="</li>";}
htmlList+='<li><a href="javascript:void(0)" id="rn_'+this.instanceID+'_AccessibleLink_'+item[1]+'" class="rn_AccessibleHierLink" data-hierList="'+item.hier_list+'">'+'<span class="rn_ScreenReaderOnly">'+this.data.attrs.label_level+' '+(item.level+1)+'</span>'+item[0]+'</a>';previousLevel=item.level;}}
for(i=previousLevel;i>=0;--i)
htmlList+="</li></ol>";htmlList+="<div id='rn_"+this.instanceID+"_AccessibleErrorLocation'></div>";this._accessibleView.setHTML(htmlList).all('a.rn_AccessibleHierLink').on('click',this._accessibleLinkClick,this);this._displayAccessibleDialog();}},_accessibleLinkClick:function(e)
{var element=e.target;var hierArray=element.getAttribute("data-hierList").split(",");var i=hierArray.length-1;var currentNode=null;while(!currentNode&&i>=0)
{currentNode=this._tree.getNodeByProperty("hierValue",parseInt(hierArray[i],10));i--;}
i++;if(this._noValueNodeIndex===currentNode.index||currentNode.hierValue==hierArray[hierArray.length-1])
{this._selectNode({node:currentNode});}
else
{var onExpandComplete=function(expandingNode)
{if(expandingNode.nextToExpand)
{var nextNode=this._tree.getNodeByProperty("hierValue",parseInt(expandingNode.nextToExpand,10));if(nextNode)
{nextNode.nextToExpand=hierArray[++i];nextNode.expand();}}
else if(i===hierArray.length)
{this._tree.unsubscribe("expandComplete",onExpandComplete,null);this._selectNode({node:expandingNode});}
return true;};this._tree.subscribe("expandComplete",onExpandComplete,this);currentNode.nextToExpand=hierArray[++i];currentNode.expand();}
return false;},_toggleProductCategoryPicker:function(e)
{if(!this._tree)
this._buildTree();if(!this._panel.get("visible"))
{this._panel.align().show();var currentNode=this._tree.getNodeByIndex(this._currentIndex)||this._tree.getRoot().children[0];if(currentNode&&currentNode.focus)
{currentNode.focus();}
this._toggleHint("show");}
else
{this._toggleHint("hide");}},_getSelectedNodesMessage:function()
{return this._getPropertyChain("label");},_getPropertyChain:function(property)
{property=property||"label";this._currentIndex=this._currentIndex||1;var hierValues=[],currentNode=this._tree.getNodeByIndex(this._currentIndex);while(currentNode&&!currentNode.isRoot())
{hierValues.push(currentNode[property]);currentNode=currentNode.parent;}
return hierValues.reverse();},_displaySelectedNodesAndClose:function(focus)
{var hierValues,description,descText;this._eo.data.value=this._currentIndex;this._eo.data.hierChain=this._getPropertyChain('hierValue');RightNow.Event.fire("evt_productCategorySelected",this._eo);this.fire('change',this);delete this._eo.data.hierChain;this._panel.hide();this._displayField.setAttribute("aria-busy","true");if(this._currentIndex<=this._noValueNodeIndex)
{this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);descText=this.data.attrs.label_nothing_selected;}
else
{hierValues=this._getSelectedNodesMessage().join("<br>");this._displayFieldVisibleText.setHTML(hierValues);descText=this.data.attrs.label_screen_reader_selected+hierValues;}
description=this.Y.one(this.baseSelector+"_TreeDescription");if(description)
description.setHTML(descText);this._displayField.setAttribute("aria-busy","false");if(this._dialog&&this._dialog.get("visible"))
this._dialog.hide();if(focus&&this._displayField.focus&&!this._dialog)
try{this._displayField.focus();}catch(e){}},_enterPressed:function(keyEvent)
{this._selectNode({node:keyEvent.details[0]});},_selectNode:function(clickEvent)
{this._selectedNode=clickEvent.node;this._currentIndex=this._selectedNode.index;this._selected=true;if((!this._selectedNode.expanded&&this._currentIndex!==this._noValueNodeIndex&&!this._selectedNode.dynamicLoadComplete)||(this.data.js.linkingOn&&this.data.attrs.data_type==="Product"))
{this._getSubLevelRequest(clickEvent.node);}
else
{this._errorLocation="";this._checkRequiredLevel();}
this._displaySelectedNodesAndClose(true);if(clickEvent.event)
clickEvent.event.preventDefault();return false;},_getSubLevelRequest:function(expandingNode)
{if(this._nodeBeingExpanded)return;this._nodeBeingExpanded=true;this._eo.data.level=expandingNode.depth+1;this._eo.data.value=expandingNode.hierValue;this._eo.data.label=expandingNode.label;if(this.data.attrs.show_confirm_button_in_dialog)
this._requestedIndex=expandingNode.index;else
this._currentIndex=expandingNode.index;if(this.data.attrs.data_type==="Product")
{RightNow.UI.Form.currentProduct=this._eo.data.value;}
this._eo.data.reset=false;if(this._eo.data.linking_on)
{if(this.data.attrs.data_type==="Category")
{if(expandingNode.children.length)
{this._nodeBeingExpanded=false;return;}
this._eo.data.reset=(this._eo.data.value<1);}
else if(this._eo.data.value<1&&this.data.attrs.data_type==="Product")
{this._nodeBeingExpanded=false;RightNow.Event.fire("evt_menuFilterGetResponse",new RightNow.Event.EventObject(this,{data:{reset_linked_category:true,data_type:"Category",reset:true}}));return;}}
if(this.data.js.link_map)
{this._eo.data.link_map=this.data.js.link_map;delete this.data.js.link_map;}
RightNow.Event.fire("evt_menuFilterRequest",this._eo);if(this._eo.data.link_map)
delete this._eo.data.link_map;this._nodeBeingExpanded=false;},_getSubLevelResponse:function(type,args)
{var evtObj=args[0],tempNode;if((evtObj.w_id&&evtObj.w_id===this.instanceID)||(this.data.js.linkingOn&&evtObj.data.data_type==="Category"&&this.data.attrs.data_type===evtObj.data.data_type))
{var currentRoot;if(evtObj.data.reset_linked_category&&this.data.attrs.data_type==="Category")
{if(this.data.js.link_map)
delete this.data.js.link_map;if(!this._tree||evtObj.data.reset)
{this._buildTree();this._linkedCategorySubset=false;}
this._flatTreeViewData=null;currentRoot=this._tree.getRoot();if(!evtObj.data.reset)
{this._linkedCategorySubset=true;currentRoot.dynamicLoadComplete=false;this._tree.removeChildren(currentRoot);tempNode=new this.Y.apm.MenuNode(this.Y.Escape.html(this.data.attrs.label_all_values),currentRoot,false);tempNode.hierValue=0;tempNode.href='javascript:void(0);';tempNode.isLeaf=true;this._noValueNodeIndex=this._currentIndex=this._requestedIndex=tempNode.index;}
this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);var description=this.Y.one(this.baseSelector+"_TreeDescription");if(description)
description.setHTML(this.data.attrs.label_nothing_selected);this._errorLocation='';this._checkRequiredLevel();}
else
{currentRoot=this._tree.getNodeByIndex(this.data.attrs.show_confirm_button_in_dialog?this._requestedIndex:this._currentIndex);}
var hierLevel=evtObj.data.level,hierData=evtObj.data.hier_data;if(hierLevel<=this._maxDepth)
{for(var i=0,hierValue;i<hierData.length;i++)
{hierValue=hierData[i].id;if(!currentRoot.children[i]||currentRoot.children[i].hierValue!==hierValue)
{tempNode=new this.Y.apm.MenuNode(this.Y.Escape.html(hierData[i].label),currentRoot,false);tempNode.hierValue=hierValue;tempNode.href='javascript:void(0);';if(!hierData[i].hasChildren||hierLevel===this._maxDepth)
{tempNode.dynamicLoadComplete=true;tempNode.iconMode=1;}}}
currentRoot.loadComplete();}
if(this._selected&&this.data.attrs.required_lvl)
{this._errorLocation="";this._checkRequiredLevel();this._selected=false;}}},_setButtonClick:function()
{var hierValues=[],ID;if(this._currentIndex<=this._noValueNodeIndex){if(!this._errorMessageDiv){this._errorMessageDiv=this.Y.Node.create("<div class='rn_MessageBox rn_ErrorMessage'/>");this.Y.one(this.baseSelector).prepend(this._errorMessageDiv);}
this._errorMessageDiv.setHTML("<b><a href='javascript:void(0);' onclick='document.getElementById(\""+this._displayField.get('id')+"\").focus(); return false;'>"+
this.data.attrs.label_nothing_selected+"</a></b>");RightNow.UI.show(this._errorMessageDiv);var errorLink=this._errorMessageDiv.one('a');if(errorLink){errorLink.focus();}
return;}
if(!this._checkRequiredLevel()){return;}
RightNow.UI.hide(this._errorMessageDiv);var currentNode=this._tree.getNodeByIndex(this._currentIndex),index=currentNode.depth+1;while(currentNode&&!currentNode.isRoot()){ID=currentNode.hierValue;hierValues[index]={"id":ID,"label":currentNode.label};currentNode=currentNode.parent;index--;}
this._currentIndex=this._noValueNodeIndex;var description=this.Y.one(this.baseSelector+"_TreeDescription");if(this._displayField&&description){description.setHTML(this.data.attrs.label_nothing_selected);this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);}
this._eo.data.hierSetData=hierValues;this._eo.data.id=hierValues[hierValues.length-1].id;RightNow.Event.fire("evt_menuFilterSelectRequest",this._eo);},_onValidate:function(type,args)
{var formEventObject=this.createEventObject();this._errorLocation=this.lastErrorLocation=args[0].data.error_location;if(this._checkRequiredLevel())
{formEventObject.data.value=(this._currentIndex&&this._currentIndex!==this._noValueNodeIndex)?this._tree.getNodeByIndex(this._currentIndex).hierValue:null;if(formEventObject.data.required&&this._notRequiredDueToProductLinking){formEventObject.data.required=false;}
RightNow.Event.fire("evt_formFieldValidatePass",formEventObject);return formEventObject;}
RightNow.Event.fire("evt_formFieldValidateFailure",this._eo);return false;},_createHintElement:function(visibility)
{var overlay=this.Y.Node.create("<span class='rn_HintBox'/>").set('id',this.baseDomID+'_Hint').setHTML(this.data.attrs.hint);if(visibility)
overlay.addClass("rn_AlwaysVisibleHint");return new this.Y.Overlay({visible:visibility,align:{node:this._displayField,points:[this.Y.WidgetPositionAlign.TL,this.Y.WidgetPositionAlign.TR]},bodyContent:overlay,render:this.Y.one(this.baseSelector)});},_toggleHint:function(hideOrShow)
{if(this._hintOverlay&&this._hintOverlay[hideOrShow]&&!this.data.attrs.always_show_hint)
this._hintOverlay[hideOrShow]();},swapLabel:function(container,requiredLevel,label,template){var templateObject={label:label,instanceID:this.instanceID,fieldName:this._fieldName,requiredLevel:requiredLevel,requiredMarkLabel:RightNow.Interface.getMessage("FIELD_REQUIRED_MARK_LBL"),requiredLabel:RightNow.Interface.getMessage("REQUIRED_LBL")};container.setHTML('');container.append(new EJS({text:template}).render(templateObject));},updateRequiredLevel:function(evt,constraint){var newLevel=constraint[0].constraint;if(newLevel>this.data.attrs.max_lvl||this.data.attrs.required_lvl===newLevel)return;if(this.data.attrs.required_lvl>0&&this.lastErrorLocation){this.Y.one('#'+this.lastErrorLocation).all("[data-field='"+this._fieldName+"']").remove();}
this.swapLabel(this.Y.one(this.baseSelector+'_Label'),newLevel,this.data.attrs.label_input,this.getStatic().templates.label);this.data.attrs.required_lvl=newLevel;if(!newLevel){this._displayField.removeClass("rn_ErrorField");this.Y.one(this.baseSelector+"_Label").removeClass("rn_ErrorLabel");}
else{this._errorLocation="";this._checkRequiredLevel();}},_checkRequiredLevel:function()
{if(this.data.attrs.required_lvl)
{if(!this._tree)
{this._buildTree();this._currentIndex=this._noValueNodeIndex;}
var currentNode=this._tree.getNodeByIndex(this._currentIndex);this._removeRequiredError(currentNode);var currentDepth=(currentNode)?currentNode.depth+1:1;this._notRequiredDueToProductLinking=false;if(this.data.js.linkingOn&&this.data.attrs.data_type==="Category"&&this._linkedCategorySubset)
{if(this._tree.getNodeCount()===1)
{this._notRequiredDueToProductLinking=true;return true;}
else if((this._currentIndex===this._noValueNodeIndex)||(((currentNode.dynamicLoadComplete===false)||currentNode.hasChildren(false))&&(currentDepth<this.data.attrs.required_lvl)))
{this._displayRequiredError(currentNode);return false;}}
else if((!currentNode)||(this._currentIndex===this._noValueNodeIndex)||(((currentNode.dynamicLoadComplete===false)||currentNode.hasChildren(false))&&(currentDepth<this.data.attrs.required_lvl)))
{this._displayRequiredError(currentNode);return false;}}
return true;},_removeRequiredError:function(currentNode)
{this._displayField.removeClass("rn_ErrorField");this.Y.one(this.baseSelector+"_Label").removeClass("rn_ErrorLabel");currentNode=this._displayRequiredError.errorNode||currentNode;if(currentNode)
currentNode.removeClass("rn_ErrorField");this.Y.one(this.baseSelector+"_RequiredLabel").replaceClass("rn_RequiredLabel","rn_Hidden");RightNow.UI.hide(this._accessibleErrorMessageDiv);},_displayRequiredError:function(currentNode)
{this._displayField.addClass("rn_ErrorField");this.Y.one(this.baseSelector+"_Label").addClass("rn_ErrorLabel");currentNode||(currentNode=this._tree.getRoot().children[0]);currentNode.addClass("rn_ErrorField");this._displayRequiredError.errorNode=currentNode;var message=this.data.attrs.label_nothing_selected;if(currentNode.index!==this._noValueNodeIndex)
{message=(this.data.attrs.label_required.indexOf("%s")>-1)?RightNow.Text.sprintf(this.data.attrs.label_required,currentNode.label):this.data.attrs.label_required;}
var requiredLabel=this.Y.one(this.baseSelector+"_RequiredLabel");if(requiredLabel)
{requiredLabel.setHTML(message).replaceClass('rn_Hidden','rn_RequiredLabel');}
var label=this.data.attrs.label_error||this.data.attrs.label_input;if(this._errorLocation)
{var commonErrorDiv=this.Y.one('#'+this._errorLocation);if(commonErrorDiv){commonErrorDiv.append("<div data-field=\""+this._fieldName+"\"><b><a href='#' onclick='document.getElementById(\""+this._displayField.get('id')+"\").focus(); return false;'>"+
label+" - "+message+"</a></b></div> ");}}
if(this._dialog&&this._dialog.get("visible"))
{this._accessibleErrorMessageDiv||(this._accessibleErrorMessageDiv=this.Y.one(this.baseSelector+"_AccessibleErrorLocation"));if(this._accessibleErrorMessageDiv)
{this._accessibleErrorMessageDiv.setHTML("<div><b><a id='rn_"+this.instanceID+"_FocusLink' href='javascript:void(0);' "+" onclick='document.getElementById(\""+"rn_"+this.instanceID+"_AccessibleLink_"+currentNode.hierValue+"\").focus(); return false;'>"+
label+" - "+message+"</a></b></div> ").addClass('rn_MessageBox').addClass('rn_ErrorMessage').removeClass('rn_Hidden');}
var errorLink=this.Y.one(this.baseSelector+"_FocusLink");RightNow.UI.updateVirtualBuffer();if(errorLink)
errorLink.focus();}},_resetSelection:function(type)
{this._currentIndex=0;this._selected=true;this._displaySelectedNodesAndClose(true);return false;},});