 /* Originating Release: May 2016 */
RightNow.Widgets.ProductCategoryInput = RightNow.Field.extend({
    overrides: {
        constructor: function() {
            this.parent();

            this._currentIndex = 0;
            this._noValueNodeIndex = 0;
            this._maxDepth = this.data.attrs.max_lvl || 6;
            this._displayField = this.Y.one(this.baseSelector + "_" + this.data.attrs.data_type + "_Button");
            this._displayFieldVisibleText = this.Y.one(this.baseSelector + "_Button_Visible_Text");
            this._accessibleView = this.Y.one(this.baseSelector + "_Links");
            this._outerTreeContainer = this.Y.one(this.baseSelector + "_TreeContainer");
            this._treeNode = this.Y.one(this.baseSelector + "_Tree");
            this._notRequiredDueToProductLinking = false;

            if(this.data.js.readOnly || !this._displayField) return;

            var RightNowEvent = RightNow.Event;

            RightNowEvent.subscribe("evt_menuFilterGetResponse", this._getSubLevelResponse, this);
            this.parentForm().on('submit', this._onValidate, this);
            RightNowEvent.subscribe("evt_accessibleTreeViewGetResponse", this._getAccessibleTreeViewResponse, this);
            if(this.data.attrs.set_button)
                this.Y.one(this.baseSelector + "_" + this.data.attrs.data_type + "_SetButton").on("click", this._setButtonClick, this);

            if(this.data.attrs.hint)
                this._hintOverlay = this._initializeHint();

            //toggle panel on/off when button is clicked
            this._displayField.on("click", this._toggleProductCategoryPicker, this);
            this.Y.one(this.baseSelector + "_LinksTrigger").on("click", this._toggleAccessibleView, this);

            //setup event object
            this._eo = new RightNow.Event.EventObject(this, {data: {
                data_type: this.data.attrs.data_type,
                hm_type: this.data.js.hm_type,
                linking_on: this.data.js.linkingOn,
                linkingProduct: 0,
                table: "Incident",
                cache: [],
                name: ((this.data.attrs.data_type.indexOf('prod') > -1) ? 'prod' : 'cat')
            }});

            this._buildMenuPanel();
            if(this.data.js.hierData[0].length)
                this._buildTree();

            this.on('constraintChange:required_lvl', this.updateRequiredLevel, this);
        },

        /**
         * Shows hint when the input field is focused
         * and hides the hint on the field's blur.
         */
        _initializeHint: function()
        {
            if(this.Y.Overlay)
            {
                var overlay;
                if (this.data.attrs.always_show_hint)
                {
                    overlay = this._createHintElement(true);
                }
                else
                {
                    overlay = this._createHintElement(false);
                    this._displayField.on("focus", function(){overlay.show();});
                    this._displayField.on("blur", function(){overlay.hide();});
                }
                return overlay;
            }
            else
            {
                //display hint inline if YUI container code isn't being included
                var hint = this.Y.Node.create('<span class="rn_HintText"/>').setHTML(this.data.attrs.hint);
                this._displayField.insert(hint, 'after');
            }
        }
    },

    /**
     * Builds panel for the treeview menu.
     */
    _buildMenuPanel: function() {
        this._panel = new this.Y.Panel({
            srcNode: this._outerTreeContainer.removeClass('rn_Hidden'),
            width: 300,
            visible: false,
            render: this.Y.one(this.baseSelector),
            headerContent: null,
            buttons: [],
            hideOn: [{eventName: 'clickoutside'}],
            align: {node: this._displayField, points: [this.Y.WidgetPositionAlign.TL, this.Y.WidgetPositionAlign.BL]},
            zIndex: 2
        });
        this._panel.on('visibleChange', function(e) {
            // show
            if (e.newVal) {
                this._treeNode.setStyle("display", "block");
            }
            // hide
            else {
                this._treeNode.setStyle("display", "none");
                if (this.data.attrs.hint && !this.data.attrs.always_show_hint) {
                    // Now hiding
                    this._toggleHint("hide");
                }
            }
        }, this);
        this._treeNode.setStyle('overflow-y', 'auto');
    },

    /**
    * Constructs the YUI Treeview widget for the first time with initial data returned
    * from the server. Pre-selects and expands data that is expected to be populated.
    */
    _buildTree: function()
    {
        var YAHOO = this.Y.Port(),
            gallery = this.Y.apm;
        if(this._treeNode && gallery.TreeView)
        {
            this._tree = new gallery.TreeView(this._treeNode.get('id'));
            this._tree.setDynamicLoad(RightNow.Event.createDelegate(this, this._getSubLevelRequest));
            this._tree.subscribe('focusChanged', function(e) {
                if (e.newNode) {
                    this._treeCurrentFocus = e.newNode;
                }
                else if (e.oldNode) {
                    this._treeCurrentFocus = e.oldNode;
                }
            }, this);

            //if there is no confirm button tab should close the panel
            //but when there is tab should be ignored and by default take you to the confirm button
            if(!this.data.attrs.show_confirm_button_in_dialog) {
                YAHOO.util.Event.on(this._tree.getEl(), "keyup", function(ev){
                    if(ev.keyCode === RightNow.UI.KeyMap.TAB)
                    {
                        var currentNode = this._treeCurrentFocus;
                        if(currentNode.href) {
                            if(currentNode.target) {
                                window.open(currentNode.href, currentNode.target);
                            }
                            else {
                                window.location(currentNode.href);
                            }
                        }
                        else {
                            currentNode.toggle();
                        }
                        this._tree.fireEvent('enterKeyPressed', currentNode);
                        YAHOO.util.Event.preventDefault(ev);
                    }
                }, null, this);
            }

            //Load all of the default data into the tree
            var hasDefaultValue = false,
                hierData = this.data.js.hierData || this.data.js.hierDataNone,
                scope = this,
                insertNodes = function(nodeList, root) {
                    var dataNode, node, childNodes = [], i;
                    for(i = 0; i < nodeList.length; i++) {
                        dataNode = nodeList[i];
                        node = new gallery.MenuNode(scope.Y.Escape.html(dataNode.label), root);
                        node.href = 'javascript:void(0)';
                        node.hierValue = dataNode.id;

                        if(!dataNode.hasChildren) {
                            node.dynamicLoadComplete = true;
                            node.iconMode = 1;
                        }

                        if(dataNode.selected) {
                            hasDefaultValue = true;
                            scope._currentIndex = node.index;
                        }

                        //Child processing must be deferred until after root.loadComplete
                        if(dataNode.hasChildren && hierData[dataNode.id]) {
                            childNodes.push({children: hierData[dataNode.id], parent: node});
                        }
                    }
                    //Let YUI know that all of the (direct) children of this root have been loaded
                    root.loadComplete();
                    for(i = 0; i < childNodes.length; i++) {
                        insertNodes(childNodes[i].children, childNodes[i].parent);
                    }
                };

            //If we have a hierDataNone set for this widget, it's a category and linking is on
            //so any subsequent calls to this function should use the reset data in hierDataNone
            if(this.data.js.hierData && this.data.js.hierDataNone)
                delete this.data.js.hierData;

            //Recursively generate the tree from the tree-like data structure
            insertNodes(hierData[0], this._tree.getRoot());

            var noValueNode = this._tree.getRoot().children[0];
            noValueNode.isLeaf = true;
            this._noValueNodeIndex = noValueNode.index;

            this._tree.subscribe("enterKeyPressed", this._enterPressed, this);
            if(this.data.attrs.show_confirm_button_in_dialog)
            {
                var confirmButton = this.Y.one(this.baseSelector + '_' + this.data.attrs.data_type + '_ConfirmButton'),
                cancelButton = this.Y.one(this.baseSelector + '_' + this.data.attrs.data_type + '_CancelButton');
                confirmButton.detach('click');
                cancelButton.detach('click');
                cancelButton.detach('keydown');
                confirmButton.on('click', function(){
                    this._selectNode({node: this._treeCurrentFocus});
                }, this);
                cancelButton.on('click', function() {
                    this._panel.hide();
                }, this);
                cancelButton.on('key', function(ev) {
                    !ev.shiftKey && this._toggleProductCategoryPicker();
                }, 'tab', this);
            }
            else
            {
                this._tree.subscribe('clickEvent', this._selectNode, this);
            }

            //scroll container to 20px above expanded node
            this._tree.subscribe('expandComplete', function(e) {
                this._treeNode.set('scrollTop', this.Y.one('#' + e.contentElId).ancestor('.ygtvitem').get('offsetTop'));
            }, this);
            this._tree.collapseAll();
            if(this.data.attrs.show_confirm_button_in_dialog)
                this._outerTreeContainer.setStyle("display", "block");
            this._treeNode.setStyle("display", "block");
            if(hasDefaultValue)
                this._displaySelectedNodesAndClose(false);
        }
    },

    /**
     * Returns the level of the node in the tree.
     * @param node Object node in the tree
     */
    _levelOfNode: function(node)
    {
        return (node === null || typeof node.depth === "undefined") ? 0 : node.depth + 1;
    },

    /**
    * Creates and displays a dialog consisting of an accessible list of items.
    */
    _displayAccessibleDialog: function()
    {
        if(!this._tree)
            this._buildTree();
        // If the dialog doesn't exist, create it.  (Happens on first click).
        if(!(this._dialog))
        {
            var handleDismiss = function()
            {
                this.hide();
            };

            this._buttons = [ { text: RightNow.Interface.getMessage("CANCEL_CMD"), handler: handleDismiss, isDefault: false} ];
            RightNow.UI.show(this._accessibleView);
            this._dialog = RightNow.UI.Dialog.actionDialog(this.data.attrs.label_nothing_selected, this._accessibleView, {"buttons": this._buttons});
            this._dialog.after('visibleChange', function(e)
            {
                if (!e.newVal)
                {
                    // When the dialog closes, focus on the main selector button on the page.
                    this._displayField.focus();
                }
            }, this);
        }
        else
        {
            var currentlySelectedSpan = document.getElementById(this.baseDomID + "_IntroCurrentSelection");
            var introLink = document.getElementById(this.baseDomID + "_Intro");
            if(currentlySelectedSpan && introLink)
            {
                var currentNode = this._tree.getNodeByIndex(this._currentIndex);
                if(!currentNode)
                {
                    currentNode = {};
                    currentNode.hierValue = 0;
                }
                var localInstanceID = this.instanceID;
                introLink.onclick = function(){document.getElementById("rn_" + localInstanceID + "_AccessibleLink_" + currentNode.hierValue).focus();};
                var selectedNodes = this._getSelectedNodesMessage();
                selectedNodes = selectedNodes[0] ? selectedNodes.join(", ") : this.data.attrs.label_all_values;
                currentlySelectedSpan.innerHTML = RightNow.Text.sprintf(RightNow.Interface.getMessage("SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG"), selectedNodes);
            }
        }

        this._dialog.show();
    },

    /**
    * Toggles accessible view.
    */
    _toggleAccessibleView: function()
    {
        if(this.data.attrs.data_type === "Category" && this.data.js.linkingOn)
            this._eo.data.linkingProduct = RightNow.UI.Form.currentProduct;

        if(this._flatTreeViewData)
            this._displayAccessibleDialog();
        else
            RightNow.Event.fire("evt_accessibleTreeViewRequest", this._eo);
    },

    /**
    * Listens to response from the server and constructs an HTML tree according to
    * the flat data structure given.
    * @param e String Event name
    * @param args Object Event arguments
    */
    _getAccessibleTreeViewResponse: function(e, args)
    {
        if(args[0].data.hm_type != this._eo.data.hm_type)
            return;
        var evtObj = args[0];
        if(evtObj.data.data_type == this.data.attrs.data_type)
        {
            this._flatTreeViewData = evtObj.data.accessibleLinks;
            //add the No Value node
            var noValue = {0: this.data.attrs.label_all_values,
                           1: 0,
                           hier_list: 0,
                           level: 0};
            if(!this.Y.Lang.isArray(this._flatTreeViewData))
            {
                //convert object to array because objects don't support unshift drop off the nonNumeric values
                var tempArray = [];
                for(var i in this._flatTreeViewData)
                {
                    if(!isNaN(parseInt(i, 10)))
                        tempArray[i] = this._flatTreeViewData[i];
                }

                this._flatTreeViewData = tempArray;
            }
            this._flatTreeViewData.unshift(noValue);
            var htmlList = "<p><a href='javascript:void(0)' id='rn_" + this.instanceID + "_Intro'" +
                    "onclick='document.getElementById(\"rn_" + this.instanceID + "_AccessibleLink_" + noValue[1] +
                    "\").focus();'>" + RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_LNKS_DEPTH_ANNOUNCED_MSG"), this.data.attrs.label_input) +
                    " <span id='rn_" + this.instanceID + "_IntroCurrentSelection'>" + RightNow.Text.sprintf(RightNow.Interface.getMessage("SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG"), noValue[0]) + "</span></a></p>",
                previousLevel = -1;
            //loop through each hier_item to figure out nesting structure
            for(i in this._flatTreeViewData)
            {
                if(this._flatTreeViewData.hasOwnProperty(i))
                {
                    var item = this._flatTreeViewData[i];
                    //print down html
                    if(item.level > previousLevel)
                        htmlList += "<ol>";

                    //print up html
                    while(item.level < previousLevel)
                    {
                        htmlList += "</li></ol>";
                        previousLevel--;
                    }
                    //print across html
                    if(item.level === previousLevel) {
                        htmlList += "</li>";
                    }

                    htmlList += '<li><a href="javascript:void(0)" id="rn_' + this.instanceID + '_AccessibleLink_' + item[1] + '" class="rn_AccessibleHierLink" data-hierList="' + item.hier_list + '">' +
                        '<span class="rn_ScreenReaderOnly">' + this.data.attrs.label_level + ' ' + (item.level + 1) + '</span>' + item[0] +
                        '</a>';
                    previousLevel = item.level;
                }
            }
            //close list
            for(i = previousLevel; i >= 0; --i)
                htmlList += "</li></ol>";

            htmlList += "<div id='rn_" + this.instanceID + "_AccessibleErrorLocation'></div>";
            this._accessibleView.setHTML(htmlList).all('a.rn_AccessibleHierLink').on('click', this._accessibleLinkClick, this);
            this._displayAccessibleDialog();
        }
    },

    /**
    * Executed when a tree item is selected from the accessible view.
    * @param e Event DOM click event
    */
    _accessibleLinkClick: function(e)
    {
        //basically transfer this click to the visible control
        //find the node in this._tree. If it's not there, expand it's parents until it is there.
        //call click on that node.
        var element = e.target;
        var hierArray = element.getAttribute("data-hierList").split(",");
        //attempt to get the one they clicked first
        var i = hierArray.length - 1;
        var currentNode = null;
        //walk up the chain looking for the first available node
        while(!currentNode && i >= 0)
        {
            currentNode = this._tree.getNodeByProperty("hierValue", parseInt(hierArray[i], 10));
            i--;
        }
        //now currentNode should be something.
        //if we already have the one they selected, then we can go ahead and click it.
        i++;
        if(this._noValueNodeIndex === currentNode.index || currentNode.hierValue == hierArray[hierArray.length - 1])
        {
            this._selectNode({node: currentNode});
        }
        else
        {
            var onExpandComplete = function(expandingNode)
            {
                if(expandingNode.nextToExpand)
                {
                    var nextNode = this._tree.getNodeByProperty("hierValue", parseInt(expandingNode.nextToExpand, 10));
                    if(nextNode)
                    {
                        nextNode.nextToExpand = hierArray[++i];
                        nextNode.expand();
                    }
                }
                else if(i === hierArray.length)
                {
                    //we don't want to subscribe to this more than once
                    this._tree.unsubscribe("expandComplete", onExpandComplete, null);
                    this._selectNode({node: expandingNode});
                }
                return true;
            };
            //walk back down to their selection from here expanding as you go
            this._tree.subscribe("expandComplete", onExpandComplete, this);
            currentNode.nextToExpand = hierArray[++i];
            currentNode.expand();
        }
        return false;
    },

    /**
    * Shows / hides Panel containing TreeView widget
    * Shows when user clicks button and the Panel is hidden.
    * Hides when user selects a node or the Panel loses focus.
    * @param {Object} e Click event
    */
    _toggleProductCategoryPicker: function(e)
    {
        //build tree for the first time
        if(!this._tree)
            this._buildTree();
        //show panel
        if(!this._panel.get("visible"))
        {
            this._panel.align().show();
            //focus on either the previously selected node or the first node
            var currentNode = this._tree.getNodeByIndex(this._currentIndex) || this._tree.getRoot().children[0];
            if(currentNode && currentNode.focus)
            {
                currentNode.focus();
            }

            this._toggleHint("show");
        }
        else
        {
            // The panel's `clickoutside` event takes care of hiding the panel.
            this._toggleHint("hide");
        }
    },

    /**
    * Returns an array of all the labels of the selected nodes
    * @return array Array of labels
    */
    _getSelectedNodesMessage: function()
    {
        return this._getPropertyChain("label");
    },

    /**
    * Navigates up from the selected node, generating an array
    * consisting of the values of the property passed in.
    * @param {String} property The property you wish to access.
    * @return array Array of values
    */
    _getPropertyChain: function(property)
    {
        property = property || "label";
        //work back up the tree from the selected node
        this._currentIndex = this._currentIndex || 1;
        var hierValues = [],
              currentNode = this._tree.getNodeByIndex(this._currentIndex);
        while(currentNode && !currentNode.isRoot())
        {
            hierValues.push(currentNode[property]);
            currentNode = currentNode.parent;
        }
        return hierValues.reverse();
    },

    /**
    * Displays the hierarchy of the currently selected node up to it's root node,
    * hides the panel, and focuses on the selection button (if directed).
    * @param focus Boolean Whether or not the button should be focused
    */
    _displaySelectedNodesAndClose: function(focus)
    {
        var hierValues, description, descText;

        this._eo.data.value = this._currentIndex;

        // event to notify listeners of selection
        this._eo.data.hierChain = this._getPropertyChain('hierValue');
        RightNow.Event.fire("evt_productCategorySelected", this._eo);
        this.fire('change', this);
        delete this._eo.data.hierChain;

        this._panel.hide();
        this._displayField.setAttribute("aria-busy", "true");
        if(this._currentIndex <= this._noValueNodeIndex)
        {
            this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);
            descText = this.data.attrs.label_nothing_selected;
        }
        else
        {
            hierValues = this._getSelectedNodesMessage().join("<br>");
            this._displayFieldVisibleText.setHTML(hierValues);
            descText = this.data.attrs.label_screen_reader_selected + hierValues;
        }
        description = this.Y.one(this.baseSelector + "_TreeDescription");
        if(description)
           description.setHTML(descText);

        this._displayField.setAttribute("aria-busy", "false");

        //also close the dialog if it exists
        if(this._dialog && this._dialog.get("visible"))
            this._dialog.hide();

        //don't focus if the accessible dialog is in use or was in use during this page load.
        //the acccessible view and the treeview shouldn't really be mixed
        if(focus && this._displayField.focus && !this._dialog)
            try{this._displayField.focus();} catch(e){}
    },

    /**
    * Handler for when enter was pressed while focused on a node
    * Emulates mouse click
    * @param {Event} keyEvent The node's enterPressed event.
    */
    _enterPressed: function(keyEvent)
    {
        this._selectNode({node:keyEvent.details[0]});
    },

    /**
    * Selected a node by clicking on its label
    * (as opposed to expanding it via the expand image).
    * @param clickEvent Event The node's click event.
    */
    _selectNode: function(clickEvent)
    {
        this._selectedNode = clickEvent.node;
        this._currentIndex = this._selectedNode.index;
        this._selected = true;
        //get next level if the node hasn't loaded children yet, isn't expanded, and isn't the 'No Value' node
        //or if product linking is on and this is the product (regardless of level)
        if((!this._selectedNode.expanded && this._currentIndex !== this._noValueNodeIndex && !this._selectedNode.dynamicLoadComplete)
            || (this.data.js.linkingOn && this.data.attrs.data_type === "Product"))
        {
            this._getSubLevelRequest(clickEvent.node);
        }
        else
        {
            this._errorLocation = "";
            this._checkRequiredLevel();
        }
        this._displaySelectedNodesAndClose(true);
        if(clickEvent.event)
            clickEvent.event.preventDefault();

        return false;
    },

    /**
     * Event handler when a node is expanded.
     * Requests the next sub-level of items from the server.
     * @param expandingNode Event The node that's expanding
     */
    _getSubLevelRequest: function(expandingNode)
    {
        //only allow one node at-a-time to be expanded
        if (this._nodeBeingExpanded) return;

        this._nodeBeingExpanded = true;
        this._eo.data.level = expandingNode.depth + 1;
        this._eo.data.value = expandingNode.hierValue;
        this._eo.data.label = expandingNode.label;

        //When the show_confirm_button_in_dialog attribute is set, we don't want to explicity change the users selection when they drill down
        //into an element. If we did that, the user wouldn't be able to use the cancel button correctly. We just want to set a
        //temporary value which we can use in the response event. If this attribute isn't set, keep the behavior the same as before.
        if(this.data.attrs.show_confirm_button_in_dialog)
            this._requestedIndex = expandingNode.index;
        else
            this._currentIndex = expandingNode.index;

        if(this.data.attrs.data_type === "Product")
        {
            //Set namespace global for hier menu list linking display
            RightNow.UI.Form.currentProduct = this._eo.data.value;
        }

        this._eo.data.reset = false; //whether data should be reset for the current level
        if(this._eo.data.linking_on)
        {
            //prod linking
            if(this.data.attrs.data_type === "Category")
            {
                if(expandingNode.children.length)
                {
                    //data's already been loaded
                    this._nodeBeingExpanded = false;
                    return;
                }
                this._eo.data.reset = (this._eo.data.value < 1);
            }
            else if(this._eo.data.value < 1 && this.data.attrs.data_type === "Product")
            {
                //product was set back to all: fire event for categories to re-show all
                this._nodeBeingExpanded = false;
                RightNow.Event.fire("evt_menuFilterGetResponse", new RightNow.Event.EventObject(this, {data: {
                    reset_linked_category: true,
                    data_type: "Category",
                    reset: true
                }}));
                return;
            }
        }

        if(this.data.js.link_map)
        {
            //pass link map (prod linking) to EventBus for first time
            this._eo.data.link_map = this.data.js.link_map;
            delete this.data.js.link_map;
        }
        RightNow.Event.fire("evt_menuFilterRequest", this._eo);
        // Remove link_map from this._eo so this widget does not misinform the Event Bus
        // or other widgets about the link_map on subsequent requests.
        if(this._eo.data.link_map)
            delete this._eo.data.link_map;
        this._nodeBeingExpanded = false;
    },

    /**
     * Event handler when returning from ajax data request.
     * @param type String Event name
     * @param args Object Event arguments
     */
    _getSubLevelResponse: function(type, args)
    {
        var evtObj = args[0],
            tempNode;

        //Check if we are supposed to update : only if the original requesting widget or if category widget receiving prod links
        if((evtObj.w_id && evtObj.w_id === this.instanceID) || (this.data.js.linkingOn && evtObj.data.data_type === "Category" && this.data.attrs.data_type === evtObj.data.data_type))
        {
            var currentRoot;
            //prod linking : category data's being completely reset
            if(evtObj.data.reset_linked_category && this.data.attrs.data_type === "Category")
            {
                // delete link_map if we have not already so that we don't send stale data
                if(this.data.js.link_map)
                    delete this.data.js.link_map;

                if(!this._tree || evtObj.data.reset)
                {
                    //restore category tree to its orig. state
                    this._buildTree();
                    this._linkedCategorySubset = false;
                }

                this._flatTreeViewData = null;
                //clear out the existing tree and add 'no value' node
                currentRoot = this._tree.getRoot();
                if(!evtObj.data.reset)
                {
                    this._linkedCategorySubset = true;
                    currentRoot.dynamicLoadComplete = false;
                    this._tree.removeChildren(currentRoot);
                    tempNode = new this.Y.apm.MenuNode(this.Y.Escape.html(this.data.attrs.label_all_values), currentRoot, false);
                    tempNode.hierValue = 0;
                    tempNode.href = 'javascript:void(0);';
                    tempNode.isLeaf = true;
                    this._noValueNodeIndex = this._currentIndex = this._requestedIndex = tempNode.index;
                }
                //since the data's being reset, reset the button's label
                this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);
                var description = this.Y.one(this.baseSelector + "_TreeDescription");
                if(description)
                    description.setHTML(this.data.attrs.label_nothing_selected);

                this._errorLocation = '';
                this._checkRequiredLevel();
            }
            else
            {
                //Get the current root based on what node was drilled into. Depending on this attribute, it'll either be the currently
                //selected node or it'll be the temporary value we set above
                currentRoot = this._tree.getNodeByIndex(this.data.attrs.show_confirm_button_in_dialog ? this._requestedIndex : this._currentIndex);
            }

            var hierLevel = evtObj.data.level,
                hierData = evtObj.data.hier_data;

            if(hierLevel <= this._maxDepth)
            {
                for(var i = 0, hierValue; i < hierData.length; i++)
                {
                    hierValue = hierData[i].id;
                    if(!currentRoot.children[i] || currentRoot.children[i].hierValue !== hierValue)
                    {
                        tempNode = new this.Y.apm.MenuNode(this.Y.Escape.html(hierData[i].label), currentRoot, false);
                        tempNode.hierValue = hierValue;
                        tempNode.href = 'javascript:void(0);';
                        if(!hierData[i].hasChildren || hierLevel === this._maxDepth)
                        {
                            //if it doesn't have children then turn off the +/- icon
                            //and notify that the node is already loaded
                            tempNode.dynamicLoadComplete = true;
                            tempNode.iconMode = 1;
                        }
                    }
                }
                currentRoot.loadComplete();
            }

            if(this._selected && this.data.attrs.required_lvl)
            {
                this._errorLocation = "";
                this._checkRequiredLevel();
                this._selected = false;
            }
        }
    },

    /**
     * Event handler if set_button attribute is set to true
     */
    _setButtonClick: function()
    {
        var hierValues = [], ID;

        if(this._currentIndex <= this._noValueNodeIndex) {
            // Nothing selected
            if(!this._errorMessageDiv) {
                this._errorMessageDiv = this.Y.Node.create("<div class='rn_MessageBox rn_ErrorMessage'/>");
                this.Y.one(this.baseSelector).prepend(this._errorMessageDiv);
            }
            this._errorMessageDiv.setHTML("<b><a href='javascript:void(0);' onclick='document.getElementById(\"" + this._displayField.get('id') + "\").focus(); return false;'>" +
                this.data.attrs.label_nothing_selected + "</a></b>");
            RightNow.UI.show(this._errorMessageDiv);
            var errorLink = this._errorMessageDiv.one('a');
            if(errorLink) {
                errorLink.focus();
            }
            return;
        }

        if(!this._checkRequiredLevel()) {
            // Required level not met. The error message is presented via _checkRequiredLevel
            return;
        }

        //collect node values: work back up the tree
        RightNow.UI.hide(this._errorMessageDiv);
        var currentNode = this._tree.getNodeByIndex(this._currentIndex),
            index = currentNode.depth + 1;
        while(currentNode && !currentNode.isRoot()) {
            ID = currentNode.hierValue;
            hierValues[index] = {"id" : ID, "label" : currentNode.label};
            currentNode = currentNode.parent;
            index--;
        }
        this._currentIndex = this._noValueNodeIndex;
        var description = this.Y.one(this.baseSelector + "_TreeDescription");
        if(this._displayField && description) {
            description.setHTML(this.data.attrs.label_nothing_selected);
            this._displayFieldVisibleText.setHTML(this.data.attrs.label_nothing_selected);
        }

        this._eo.data.hierSetData = hierValues;
        this._eo.data.id = hierValues[hierValues.length - 1].id; // Use ID from deepest level of hier
        RightNow.Event.fire("evt_menuFilterSelectRequest", this._eo);
    },

    /**
     * Event handler for when form is being validated
     * @param type String Event name
     * @param args Object Event arguments
     */
    _onValidate: function(type, args)
    {
        var formEventObject = this.createEventObject();
        this._errorLocation = this.lastErrorLocation = args[0].data.error_location;

        if(this._checkRequiredLevel())
        {
            formEventObject.data.value = (this._currentIndex && this._currentIndex !== this._noValueNodeIndex)
                ? this._tree.getNodeByIndex(this._currentIndex).hierValue
                : null;

            if (formEventObject.data.required && this._notRequiredDueToProductLinking) {
                formEventObject.data.required = false;
            }

            RightNow.Event.fire("evt_formFieldValidatePass", formEventObject);
            return formEventObject;
        }

        RightNow.Event.fire("evt_formFieldValidateFailure", this._eo);
        return false;
    },

    /**
     * Creates the hint element.
     * @param visibility Boolean whether the hint element is initially visible
     * @return Object representing the hint element
     */
    _createHintElement: function(visibility)
    {
        var overlay = this.Y.Node.create("<span class='rn_HintBox'/>").set('id', this.baseDomID + '_Hint').setHTML(this.data.attrs.hint);
        if (visibility)
            overlay.addClass("rn_AlwaysVisibleHint");

        return new this.Y.Overlay({
            visible: visibility,
            align: {
                node: this._displayField,
                points: [this.Y.WidgetPositionAlign.TL, this.Y.WidgetPositionAlign.TR]
            },
            bodyContent: overlay,
            render: this.Y.one(this.baseSelector)
        });
    },

    /**
     * Toggle the display of the hint overlay if it exists and is not set to always display.
     * @param hideOrShow String The toggle function to call on the overlay "hide" or "show"
     */
    _toggleHint: function(hideOrShow)
    {
        if(this._hintOverlay && this._hintOverlay[hideOrShow] && !this.data.attrs.always_show_hint)
            this._hintOverlay[hideOrShow]();
    },

    /**
     * Used by Dynamic Forms to switch between a required and a non-required label
     * @param  {Object} container    The DOM node containing the label
     * @param  {Number} requiredLevel The new required level
     * @param  {String} label        The label text to be inserted
     * @param  {String} template     The template text
     */
    swapLabel: function(container, requiredLevel, label, template) {
        var templateObject = {
            label: label,
            instanceID: this.instanceID,
            fieldName: this._fieldName,
            requiredLevel: requiredLevel,
            requiredMarkLabel: RightNow.Interface.getMessage("FIELD_REQUIRED_MARK_LBL"),
            requiredLabel: RightNow.Interface.getMessage("REQUIRED_LBL")
        };

        container.setHTML('');
        container.append(new EJS({text: template}).render(templateObject));
    },

    /**
     * Update the required level
     * @param  {String} evt        The event name
     * @param  {Object} constraint An object containing the altered constraint
     */
    updateRequiredLevel: function(evt, constraint) {
        var newLevel = constraint[0].constraint;
        if(newLevel > this.data.attrs.max_lvl || this.data.attrs.required_lvl === newLevel) return;

        //Clear all error div messages
        if(this.data.attrs.required_lvl > 0 && this.lastErrorLocation) {
            this.Y.one('#' + this.lastErrorLocation).all("[data-field='" + this._fieldName + "']").remove();
        }

        //Update the label HTML
        this.swapLabel(this.Y.one(this.baseSelector + '_Label'), newLevel, this.data.attrs.label_input, this.getStatic().templates.label);

        //Update the field
        this.data.attrs.required_lvl = newLevel;
        if(!newLevel) {
            this._displayField.removeClass("rn_ErrorField");
            this.Y.one(this.baseSelector + "_Label").removeClass("rn_ErrorLabel");
        }
        else {
            this._errorLocation = "";
            this._checkRequiredLevel();
        }
    },

    /**
     * Checks if field has met its required level for submission
     */
    _checkRequiredLevel: function()
    {
        if(this.data.attrs.required_lvl)
        {
            if(!this._tree)
            {
                this._buildTree();
                this._currentIndex = this._noValueNodeIndex;
            }
            var currentNode = this._tree.getNodeByIndex(this._currentIndex);
            this._removeRequiredError(currentNode);
            var currentDepth = (currentNode) ? currentNode.depth + 1 : 1;
            this._notRequiredDueToProductLinking = false;
            if(this.data.js.linkingOn && this.data.attrs.data_type === "Category" && this._linkedCategorySubset)
            {
                //if there's some subset of categories that have been loaded then
                //allow submission if either there's only a single 'no value' node...
                if(this._tree.getNodeCount() === 1)
                {
                    this._notRequiredDueToProductLinking = true;
                    return true;
                }
                //don't allow submission if 'no value' node is selected
                //or non-leaf/still-loading node not at the required depth is selected
                else if((this._currentIndex === this._noValueNodeIndex)
                    || (
                        ((currentNode.dynamicLoadComplete === false) || currentNode.hasChildren(false))
                        &&
                        (currentDepth < this.data.attrs.required_lvl)))
                {
                    this._displayRequiredError(currentNode);
                    return false;
                }
            }
            //don't allow submission if nothing is selected or 'no value' node is selected
            //or non-leaf/still-loading node not at the required depth is selected
            else if((!currentNode)
                || (this._currentIndex === this._noValueNodeIndex)
                || (
                    ((currentNode.dynamicLoadComplete === false) || currentNode.hasChildren(false))
                    &&
                    (currentDepth < this.data.attrs.required_lvl)))
            {
                this._displayRequiredError(currentNode);
                return false;
            }
        }
        return true;
    },

    /**
    * Removes any previously set error classes from the widget's label,
    * selection button, and previously erroneous node.
    * @param currentNode MenuNode the currently selected node
    */
    _removeRequiredError: function(currentNode)
    {
        this._displayField.removeClass("rn_ErrorField");
        this.Y.one(this.baseSelector + "_Label").removeClass("rn_ErrorLabel");
        currentNode = this._displayRequiredError.errorNode || currentNode;
        if(currentNode)
            currentNode.removeClass("rn_ErrorField");
        this.Y.one(this.baseSelector + "_RequiredLabel").replaceClass("rn_RequiredLabel", "rn_Hidden");
        RightNow.UI.hide(this._accessibleErrorMessageDiv);
    },

    /**
     * Adds error classes to the widget's label, selection button,
     * and the currently selected node. Adds the required message
     * to the form's common error location.
     * @param currentNode MenuNode the currently selected node
     */
    _displayRequiredError: function(currentNode)
    {
        //indicate the error
        this._displayField.addClass("rn_ErrorField");
        this.Y.one(this.baseSelector + "_Label").addClass("rn_ErrorLabel");

        currentNode || (currentNode = this._tree.getRoot().children[0]);
        currentNode.addClass("rn_ErrorField");
        //save a local reference to the error node so that the error class can be removed from it later
        this._displayRequiredError.errorNode = currentNode;

        var message = this.data.attrs.label_nothing_selected;
        if (currentNode.index !== this._noValueNodeIndex)
        {
            message = (this.data.attrs.label_required.indexOf("%s") > -1) ?
                RightNow.Text.sprintf(this.data.attrs.label_required, currentNode.label) :
                this.data.attrs.label_required;
        }
        //write out the required label
        var requiredLabel = this.Y.one(this.baseSelector + "_RequiredLabel");
        if(requiredLabel)
        {
            requiredLabel.setHTML(message).replaceClass('rn_Hidden', 'rn_RequiredLabel');
        }

        var label = this.data.attrs.label_error || this.data.attrs.label_input;
        //report error on common form button area
        if(this._errorLocation)
        {
            var commonErrorDiv = this.Y.one('#' + this._errorLocation);
            if(commonErrorDiv){
                commonErrorDiv.append("<div data-field=\"" + this._fieldName + "\"><b><a href='#' onclick='document.getElementById(\"" + this._displayField.get('id') + "\").focus(); return false;'>" +
                    label + " - " + message + "</a></b></div> ");
            }
        }
        //if the accessible dialog is created & open, add the error message to it
        if(this._dialog && this._dialog.get("visible"))
        {
            this._accessibleErrorMessageDiv || (this._accessibleErrorMessageDiv = this.Y.one(this.baseSelector + "_AccessibleErrorLocation"));
            if(this._accessibleErrorMessageDiv)
            {
                this._accessibleErrorMessageDiv.setHTML("<div><b><a id='rn_" + this.instanceID + "_FocusLink' href='javascript:void(0);' " +
                    " onclick='document.getElementById(\"" + "rn_" + this.instanceID + "_AccessibleLink_" + currentNode.hierValue + "\").focus(); return false;'>" +
                    label + " - " + message + "</a></b></div> ")
                    .addClass('rn_MessageBox')
                    .addClass('rn_ErrorMessage')
                    .removeClass('rn_Hidden');
            }
            var errorLink = this.Y.one(this.baseSelector + "_FocusLink");
            RightNow.UI.updateVirtualBuffer();
            if(errorLink)
                errorLink.focus();
        }
    }
});
