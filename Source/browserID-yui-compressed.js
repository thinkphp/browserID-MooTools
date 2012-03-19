/*
---
description: This is a MooTools client library for the BrowserID Protocol

authors:
- Adrian Statescu (http://thinkphp.ro)

license:
- MIT-style license

requires:
 core/1.4.5: '*'

provides: BrowserID
...
*/

var BrowserID=new Class({Implements:[Options,Events],options:{assertion:null,email:null,service:"login.php"},initialize:function(assertion,options){this.setOptions(options);this.options.assertion=assertion;this._verify_assertion();},_verify_assertion:function(){var request=new Request.JSON({url:"login.php",data:{assertion:this.options.assertion},onRequest:function(){if(window.console){console.log("Requesting...");}this.fireEvent("request");}.bind(this),onComplete:function(response){if(window.console){console.log("Completed...");}if(response.status&&response.status=="okay"){this.options.email=response.email;}this.fireEvent("complete",[response]);}.bind(this)}).send();}});