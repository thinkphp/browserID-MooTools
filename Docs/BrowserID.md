Class: BrowserID {#BrowserID}
==============================

This is a MooTools client library for the BrowserID Protocol. BrowserID is a new way for users to log into web sites using their email address. 
It aims to provide a secure way of proving your identity to servers across the internet, without having to create separate usernames and passwords each time. 
Instead of a new username, it uses your email address as you identity which allows it to be descentralized since anyone can send you an
email verification message.

### Syntax:

    var browserID = new BrowserID(assertion, options);

### Arguments:

- assertion `String` - a string containing a signed claim that proves the user is who they say they are.

- options   `object` - The options for the BrowserID instance.

### Events

### onRequest

* `function` Function to execute when you make a request.

### Signature

    onRequest();

### onComplete

* `function` Function to execute when the request is completed.

### Signature

    onComplete(response);

### Arguments

- `object` The verifier will check that the assertion was meant for your website and is valid
           returns => {status: 'okay','email': 'user@mozilla.com'}, 
           otherwise returns {status: 'failure','reason': 'audience missmatch'}, 


