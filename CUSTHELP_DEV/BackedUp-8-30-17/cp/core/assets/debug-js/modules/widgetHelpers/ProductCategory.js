/**
 * Provides Product / Category TreeView widget functionality:
 * - Dropdown menu
 * - TreeView UI contained within the menu
 * - Accessible TreeView dialog
 *
 *  May be extended by a widget or mixed into a widget using
 *  `Y.augment`, where it is then the widget's responsibility to
 *  override methods in order to add or change specific behavior
 *  (e.g. product linking features form validation, searching,
 *  etc.).
 */
RightNow.ProductCategory = RightNow.EventProvider.extend({
   /**
     * Initializes the various UI components.
     * @param {string} dataType Product or Category
     */
   initializeTreeView: function (dataType) {
       this.dataType = dataType;
       this.displayField || (this.displayField = this.Y.one(this.baseSelector + "_" + this.dataType + "_Button"));

       this.buildPanel();

       this.Y.one(this.baseSelector + "_LinksTrigger").on("click", this.showAccessibleView, this);

       RightNow.Event.on("evt_accessibleTreeViewGetResponse", this.getAccessibleTreeViewResponse, this);
       RightNow.Event.on("evt_menuFilterGetResponse", this.getSubLevelResponse, this);

       if (this.data.js.hierData && this.data.js.hierData[0] && this.data.js.hierData[0].length) {
           this.buildTree();
       }
   },

   /**
     * Builds panel for the treeview menu.
     */
   buildPanel: function() {
       this.dropdown = new this.Y.RightNowTreeViewDropdown({
           srcNode: this.Y.one(this.baseSelector + "_TreeContainer").removeClass('rn_Hidden'),
           render: this.Y.one(this.baseSelector),
           trigger: this.displayField,
           visible: false
       });
       this.dropdown.once('show', this.Y.bind(this.buildTree, this, false));
       this.dropdown.on('show', function () {
           this.tree.focusOnSelectedNode();
       }, this);
   },

   /**
     * Constructs the RightNowTreeView widget for the first time with initial data returned
     * from the server. Pre-selects and expands data that is expected to be populated.
     * @param {boolean} forceRebuild Whether to forcefully recreate the tree if it already exists
     */
   buildTree: function (forceRebuild) {
       if (this.tree && !forceRebuild) return;

       if (this.tree) {
           this.tree.clear();
       }

       this.tree = new this.Y.RightNowTreeView({
           hierarchyData: this.data.js.hierData || this.data.js.hierDataNone,
           contentBox: this.Y.one(this.baseSelector + '_Tree').setStyles({
               'overflow-y': 'auto',
               'display': 'block'
           })
       });
       this.tree.render();

       //If we have a hierDataNone set for this widget, it's a category and linking is on
       //so any subsequent calls to this function should use the reset data in hierDataNone
       if(this.data.js.hierData && this.data.js.hierDataNone)
           delete this.data.js.hierData;

       this.tree.on("enterKey", this.selectNode, this);
       this.tree.on('dynamicNodeExpand', this.getSubLevelRequest, this);

       if (this.data.attrs.show_confirm_button_in_dialog) {
           this.dropdown.set('confirmButton', this.Y.one(this.baseSelector + '_' + this.data.js.data_type + '_ConfirmButton'));
           this.dropdown.set('cancelButton', this.Y.one(this.baseSelector + '_' + this.data.js.data_type + '_CancelButton'));
           this.dropdown.on('confirm', function () {
               this.selectNode(this.tree.getFocusedNode());
           }, this);
           this.Y.one(this.baseSelector + '_TreeContainer').setStyle("display", "block");
       }
       else {
           this.tree.on('click', this.selectNode, this);
       }

       if (this.tree.get('value')) {
           this.displaySelectedNodesAndClose(false);
       }

       this.dropdown.set('treeView', this.tree);
   },

   /**
    * Executed when a tree item is selected from the accessible view.
    * @param {Object} e YUI event facade
    */
   onAccessibleLinkClick: function(e) {
       this.dialog.hide();
       this.tree.expandAndCreateNodes(e.valueChain);
   },

   /**
    * Shows the accessible dialog.
    * @param {Object} e Click event
    */
   showAccessibleView: function(e) {
       e.halt();

       this._eo || (this._eo = new RightNow.Event.EventObject(this));

       if (this.dataType === "Category" && this.data.js.linkingOn) {
           this._eo.data.linkingProduct = RightNow.UI.Form.currentProduct;
       }

       if (this.dialog) {
           this.displayAccessibleDialog();
       }
       else {
           RightNow.Event.fire("evt_accessibleTreeViewRequest", this._eo);
       }
   },

   /**
    * Listens to response from the server and constructs an HTML tree according to
    * the flat data structure given.
    * @param {string} e Event name
    * @param {Array} args Event arguments
    */
   getAccessibleTreeViewResponse: function(e, args) {
       if(args[0].data.hm_type !== this._eo.data.hm_type) return;

       var results = this.Y.Array(args[0].data.accessibleLinks);
       results.unshift({
          0: this.data.attrs.label_all_values,
          1: 0,
          hier_list: 0,
          level: 0
       });

       this.createAccessibleDialog(results);
       this.buildTree();
       this.displayAccessibleDialog();
   },

   /**
     * Creates a new RightNowTreeViewDialog with the given hierarchy data.
     * @param  {Array} flatHierarchyData Flat hierarchy data the the RightNowTreeViewDialog
     *                                   uses to construct the dialog content.
     */
   createAccessibleDialog: function(flatHierarchyData) {
       if (this.dialog) {
           this.dialog.destroy();
       }

       this.dialog = new this.Y.RightNowTreeViewDialog({
           id: 'rn_' + this.instanceID,
           hierarchyData: flatHierarchyData,
           contentBox: this.Y.one(this.baseSelector + "_Links"),
           dismissLabel: RightNow.Interface.getMessage("CANCEL_CMD"),
           titleLabel: this.data.attrs.label_nothing_selected,
           introLabel: RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_LNKS_DEPTH_ANNOUNCED_MSG"), this.data.attrs.label_input),
           selectionPlaceholderLabel: RightNow.Interface.getMessage("SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG"),
           levelLabel: this.data.attrs.label_level,
           noItemSelectedLabel: this.data.attrs.label_all_values
       });
       this.dialog.on('selectionMade', this.onAccessibleLinkClick, this);
       var triggerElement = this.dropdown.get('trigger');
       this.dialog.on('close', triggerElement.focus, triggerElement);

       this.dialog.render();
   },

   /**
     * Sets the currently-selected values and labels on the dialog
     * and shows it.
     */
   displayAccessibleDialog: function () {
       this.dialog.set('selectedValue', this.tree.get('value'));
       this.dialog.set('selectedLabels', this.tree.get('labelChain'));
       this.dialog.show();
   },

   /**
    * Displays the hierarchy of the currently selected node up to it's root node,
    * hides the panel, and focuses on the selection button (if directed).
    * @param {Boolean} focus Whether or not the button should be focused
    */
   displaySelectedNodesAndClose: function(focus) {
       var selectedValues = this.tree.get('valueChain');
       var labels = {
           trigger: this.data.attrs.label_nothing_selected,
           desc:    this.data.attrs.label_nothing_selected
       };

       this.dropdown.hide();

       if (selectedValues[0]) {
           labels.trigger = this.tree.get('labelChain').join("<br>");
           labels.desc = this.data.attrs.label_screen_reader_selected + labels.trigger;
       }
       this.dropdown.set('triggerText', labels.trigger);

       this.Y.all(this.baseSelector + "_TreeDescription").setHTML(labels.desc);

       if (focus && !this.dialog) {
           //don't focus if the accessible dialog is in use or was in use during this page load.
           //the acccessible view and the treeview shouldn't really be mixed
           try {
               this.dropdown.get('trigger').focus();
           }
           catch(oldIE){}
       }
   },

   /**
    * Selected a node by clicking on its label
    * (as opposed to expanding it via the expand image).
    * @param {Object} node The node
    */
   selectNode: function(node) {
       this.displaySelectedNodesAndClose(true);
   },

   /**
     * Peforms a request to get children for the given node.
     * @param  {Object} expandingNode The parent node
     */
   getSubLevelRequest: function (expandingNode) {
       // Only allow one node at-a-time to be expanded.
       if (this._nodeBeingExpanded) return;

       this._nodeBeingExpanded = true;

       var eo = this.getSubLevelRequestEventObject(expandingNode);

       if (eo) {
           if (this.dataType === "Product") {
               //Set namespace global for hier menu list linking display
               RightNow.UI.Form.currentProduct = eo.data.value;
           }

           this._requesting = eo.data.value;

           RightNow.Event.fire("evt_menuFilterRequest", eo);
       }

       this._nodeBeingExpanded = false;
   },

   /**
     * Called by #getSubLevelRequest to retrieve an EventObject instance
     * for the request. If this method returns a falsy value, the request is
     * not made.
     * @param  {Object} expandingNode The parent node
     * @return {Object}               EventObject for the request
     */
   getSubLevelRequestEventObject: function (expandingNode) {
       return new RightNow.Event.EventObject(this, {
           data: {
               level: expandingNode.depth + 1,
               value: expandingNode.value,
               label: expandingNode.label,
               cache: {}
           }
       });
   },

   /**
     * Called upon server response containing child node data.
     * @param  {string} type Event name
     * @param  {Array} args Event args
     */
   getSubLevelResponse: function (type, args) {
       this.insertChildrenForNode(args[0].data.hier_data, this._requesting);
       this._requesting = null;
   },

   /**
     * Inserts the given child node data for the node with the given value
     * @param  {Array} hierData    Child data
     * @param  {string|number} currentRoot ID / value of the parent node
     */
   insertChildrenForNode: function (hierData, currentRoot) {
       this.tree.insertChildHierarchyData(hierData, currentRoot);
   }
});