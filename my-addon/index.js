/*var self = require('sdk/self');

// a dummy function, to show how tests work.
// to see how to test this function, look at test/test-index.js
function dummy(text, callback) {
callback(text);
}

exports.dummy = dummy;*/
var buttons = require('sdk/ui/button/toggle');
var panels = require('sdk/panel');
var selfa = require('sdk/self');
var tabs = require("sdk/tabs");

var button = buttons.ToggleButton({
id: "mozilla-link",
label: "Get Latest Notifications from Moodle",
icon: {
"16": "./moodle-16.png",
"32": "./moodle-32.png",
"64": "./moodle-64.png"
},
onChange: handleChange,
badge: 0,
badgeColor: "#00AAAA"
});

var loginvalid=0;



//var ss = require("sdk/simple-storage");
function handleChange(state){
	/*var getFirstParagraph = "var paras = document.getElementsByTagName('div');" +
                        "console.log(paras[0].textContent);" +
                        "self.port.emit('loaded');" + "self.port.emit('getvalue',paras[0].textContent.toString());";
	pageWorker = require("sdk/page-worker").Page({
  	contentScript: getFirstParagraph,
	contentURL: "http://10.1.39.55/addon/notifier.php"
	});
	pageWorker.port.on("getvalue", function(code){
	console.log(code);
	if (code.indexOf("Please enter")>-1){
		loginvalid=1;
	}
	else{
		loginvalid=0;
	}
	});

	pageWorker.port.on("loaded", function() {
	//
	});*/
	
	var chrome = require('chrome');
	var data = require('sdk/self').data;
	var ios = chrome.Cc["@mozilla.org/network/io-service;1"].getService(chrome.Ci.nsIIOService);
	var ssm = chrome.Cc["@mozilla.org/scriptsecuritymanager;1"].getService(chrome.Ci.nsIScriptSecurityManager);
	var dsm = chrome.Cc["@mozilla.org/dom/storagemanager;1"].getService(chrome.Ci.nsIDOMStorageManager);
	var uri = ios.newURI(data.url('panel.html'), "", null);
	var principal = ssm.getCodebasePrincipal(uri);
	var storage = dsm.getLocalStorageForPrincipal(principal, data.url('index.html'));
	var username = storage.getItem('username');
	var password = storage.getItem('password');
	var oldPage = storage.getItem('oldpage');
	var currentPage="HI";
	if(oldPage!=currentPage){
		button.badge = state.badge + 1;
  		if (state.checked) {
  	  		button.badgeColor = "#AA00AA";
  		}
  		else {
    			button.badgeColor = "#00AAAA";
  		}
	}
	var kk = 0;
	storage.setItem('oldpage',currentPage);
	if(username){
	var getFirstParagraph = "var paras = document.getElementsByTagName('div');" + "self.port.emit('getvalue',paras[0].textContent.toString());";

	pageWorker = require("sdk/page-worker").Page({
		contentScript: getFirstParagraph,
  		contentURL: "http://10.1.39.55/addon/notifier.php"+"?username=" + username +"&password=" + password
	});
	pageWorker.port.on('getvalue',function(code){
		console.log(code);
		if(code.indexOf("Please enter")>-1){
			console.log("YAY");
			username=null;
		}
	});
	}
	let { setTimeout } = require('sdk/timers');
	setTimeout(function() {
	if(state.checked){
		console.log(kk);
		if(!username)
		{
			console.log("HI");
			var panel = panels.Panel({
			contentURL: selfa.data.url("panel.html"),
			//contentURL: "http://10.1.39.55/addon/index.php",
			//contentURL: "http://moodle.iiit.ac.in/login/index.php",
			onHide: handleHide,
			height: 320
			});
			panel.show({
				position: button
			});
		}
		else{
			var panel2 = panels.Panel({
				contentURL: "http://10.1.39.55/addon/notifier.php",
				onHide: handleHide,
				height: 320
			});
			panel2.contentURL = panel2.contentURL + "?username=" + username +"&password=" + password;
			panel2.show({
				position: button
			});
		}
	}	},1000);
}

function handleHide(){
	button.state('window',{checked: false});
}




