<?php
    /**
     *  Simple implementation of Mozilla BrowserID
     */

    class BrowserID {
          
          /**
           *  The browserID's assertion verification service endpoint 
           */
          const endpoint = 'https://browserid.org/verify';

          /**
           *  
           */
          private $assertion;

          /**
           *  The hostname and optional port of your site 
           */
          private $audience;

          /**
           *  The email address of the user
           */
          private $email;

          /**
           *  Expiration timestamp of the assertion
           */
          private $expires;

          /**
           *  The entity who issued the assertion
           */
          private $issuer;

          /**
           *  The entity who issued the assertion
           */
          private $reason;

          /**
           * The constructor of class
           * @public access
           */
          public function __construct($audience, $assertion) {
     
                 //init
                 $this->audience = $audience;
                 $this->assertion = $assertion;
          }  


          /**
           * Get email address of the user
           * @param None
           * @return String return email address
           * @public access
           */
          public function getEmail() {

                 return $this->email;
          }

          /**
           * Get expiration timestamp
           * @param None
           * @return integer expiration timestamp
           * @public access
           */
          public function getExpires() {

                 return $this->expires;
          }

          /**
           * Get the entity who issued the assertion 
           * @param None
           * @return String the entity who issued the assertion 
           * @public access
           */
          public function getIssuer() {

                 return $this->issuer;
          }


          /**
           * Get the reason if any!
           * @param None
           * @return String the reason why the assertion is failed
           * @public access
           */
          public function getReason() {

                 return $this->reason;
          }

          /**
           * Makes an HTTP POST Request to verification endpoint
           * @param   String Endpoint Server
           * @param   Array the data to be sent to the endpoint
           * @return  Object returns an object verification response
           * @private access
           */
          private function _requestPOST($url, $data) {

                  $ch = curl_init();

                  curl_setopt($ch, CURLOPT_URL,$url);    
                  curl_setopt($ch, CURLOPT_POST, true); 
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
                  curl_setopt($ch, CURLOPT_HEADER, false);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                  $response = curl_exec($ch);

                  $infos = curl_getinfo($ch); 

                  curl_close($ch);

                  if(false === $response) {
                      throw new Exception(sprintf("Faild to connect to the %s verifier", $url));
                  }

                  $json_decoded = json_decode($response);

                  if(!$json_decoded) {
                      throw new Exception(sprintf("JSON Response from %s is not valid", $url));
                  } 

                  //for debug
                  //echo"<pre>"
                  //print_r($infos); 
                  //echo"</pre>"

              return $json_decoded;
          }

          /**
           * With this method you must verify the assertion is authentic and extract the email address from it.
           * @public access
           * @return Object - returns an object as response from service with the following attributes:
           *                  1)status   Okay 
           *                  2)email    mergesortv@gmail.com
           *                  3)audience https://mysite.com
           *                  4)expires  1308859352261
           *                  5)issuer   "browserid.org"
           */  
          public function verify_assertion() {
 
                 $params = json_encode(array('assertion'=>$this->assertion,
                                             'audience'=>$this->audience));  

                 $output = $this->_requestPOST(self::endpoint, $params);

                 //for debug
                 //print_r($output);

                 if(isset($output->status) && $output->status == 'okay') {

                    $this->email   = $output->email;
                    $this->expires = $output->expires;
                    $this->issuer  = $output->issuer;

                   return true;

                 } else {

                   $this->reason = $output->reason;
 
                   return false;
                 }
           }
    }

?>