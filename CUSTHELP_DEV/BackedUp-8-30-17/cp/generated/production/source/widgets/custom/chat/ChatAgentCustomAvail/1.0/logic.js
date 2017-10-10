RightNow.namespace('Custom.Widgets.chat.ChatAgentCustomAvail');
Custom.Widgets.chat.ChatAgentCustomAvail = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {
		
			agentsavailablecount = this.data.js.result;
			//alert(agentsavailablecount);
			if(agentsavailablecount>0)
			{
				
				
				if(document.getElementById('chat_button')){
				document.getElementById('chat_button').className = "";
				//document.getElementById('chat_button').style.display = "block";
				}
				if(document.getElementById('rn_chatavailable')){
				document.getElementById('rn_chatavailable').className = "";
				}
				if(document.getElementById('rn_chatnotavailable')){
				document.getElementById('rn_chatnotavailable').className = "rn_Hidden";
				}
				
				if(document.getElementById('rn_chat_unavailable')){
				document.getElementById('rn_chat_unavailable').className = "rn_Hidden";
				}
			}
			else
			{
				if(document.getElementById('chat_button')){
				document.getElementById('chat_button').className = "rn_Hidden";
				//document.getElementById('chat_button').style.display = "none";
				}
				
				if(document.getElementById('rn_chatnotavailable')){
				document.getElementById('rn_chatnotavailable').className = "";}
				if(document.getElementById('rn_chatavailable')){
				document.getElementById('rn_chatavailable').className = "rn_Hidden";}
				if(document.getElementById('rn_chat_unavailable')){
				document.getElementById('rn_chat_unavailable').className = "";
				}
				
			}
			

    },

    /**
     * Sample widget method.
     */
    methodName: function() {

    }
});