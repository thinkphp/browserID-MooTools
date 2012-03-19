/*
---
description: This is a MooTools client library for the BrowserID Protocol.

authors:
- Adrian Statescu (http://thinkphp.ro)

license:
- MIT-style license

requires:
 core/1.4.5: '*'

provides: BrowserID
...
*/

var BrowserID = new Class({

    /**
     *  Implements: Events and Options
     */
    Implements: [Options, Events],

    /**
     *  options
     */
    options: {

        //the encoded assertion
        assertion: null,
        //user's email
        email: null,
        //proxy server to verify user's identity
        service: 'login.php'
    }, 

    /**
     * Constructor of class
     * @param assertion String - a string containing a signed claim that proves the user is who they say they are.
     * @param options   Object - the options for this class.
     * @return None
     * @access public
     */
    initialize: function(assertion,options) {

          //set options
          this.setOptions(options)

          //holds the assertion
          this.options.assertion = assertion

          //got an assertion, now send it up to the server for verifying by using an AJAX Request POST
          //in this example we have a server running at 'login.php' which receives and verifies assertions
          this._verify_assertion()
    },

    /**
     * Make a Request AJAX POST to verify the user's identity
     * @param None
     * @return None
     * @access private
     */
    _verify_assertion: function() {

            //make a AJAX POST Request
            var request = new Request.JSON({

                //provided the service to verify
                url: 'login.php',
 
                //POST the param 'assertion'
                data: {assertion: this.options.assertion},

                onRequest: function() {

                      //for debug
                      if(window.console) console.log('Requesting...')

                      //fire event onrequest
                      this.fireEvent('request')

                }.bind(this),

                onComplete: function(response) {

                      //for debug
                      if(window.console) console.log('Completed...')

                      //You must verify the assertion is authentic and extract the 
                      //user's email address from it. 
                      if(response.status && response.status == 'okay') {

                          this.options.email = response.email
                      }  

                      //fire event oncomplete
                      this.fireEvent('complete',[response])

                }.bind(this)

            }).send()
    }
})
