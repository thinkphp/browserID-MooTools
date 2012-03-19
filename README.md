BrowserID
=========

This is a MooTools client library for the BrowserID Protocol. BrowserID is a new way for users to log into web sites using their email address. 
It aims to provide a secure way of proving your identity to servers across the internet, without having to create separate usernames and passwords each time. 
Instead of a new username, it uses your email address as you identity which allows it to be descentralized since anyone can send you an
email verification message.

![Screenshot](https://developer.mozilla.org/@api/deki/files/6051/=browserid-enter-email.png)

How to Use
----------

Include the BrowserID include.js library in your site by adding the following script tag to your pages:

        <script src="https://browserid.org/include.js" type="text/javascript"></script>

And
        <script type="text/javascript" src="mootools.js"></script>
        <script type="text/javascript" src="browserID.js.js"></script>

Then

         #HTML
         <button id="login"><img src="https://browserid.org/i/sign_in_green.png" alt="sign in with browser ID"></button>


         #JS
         window.addEvent('domready', function(){

                $('login').addEvent('click',function(){
                   navigator.id.getVerifiedEmail(function(assertion){
                            if(assertion) {
                              //got an assertion, now send it up to the server for verification
                               verify(assertion)
                            } else {
                               alert("I still don't know you")
                            }
                   })
               })
         })


         function verify(assertion) {

             var browserid = new BrowserID(assertion, {

                             onComplete: function(response){

                                 //if the server successfully verifies the assertion we
                                 //updating the UI by calling 'loggedIn()'
                                 if(response.status == 'okay') {

                                       loggedIn(response.email)

                                 //otherwise we handle the login failure by calling 'failure()'
                                 } else {
                                       failure(response)
                                 }    
                             }
             })
         }

         function loggedIn(email) {
             //do stuff with email
             var p = new Element('p').set('text','Logged In as: ' + email)
             $('login').parentNode.replaceChild(p,$('login'))
         }

         function failure(f) {
             //do stuff with failure
             alert('Failure reason: ' + f.reason) 
         }