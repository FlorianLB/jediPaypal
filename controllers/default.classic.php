<?php
/**
* @package jediPaypal
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @license    MIT
*/

class defaultCtrl extends jController {
    /**
    *
    */
    function index() {
        $rep = $this->getResponse('html');

       
        jLog::dump($conf);


        return $rep;
    }
    

    public function ipn(){
        $rep = $this->getResponse('text');

        $conf = $this->loadConfig();


        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        
        // post back to PayPal system to validate
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        
        $adr = 'ssl://www.paypal.com';
        if($conf['sandbox_mode'])
            $adr =  'ssl://www.sandbox.paypal.com';
        
        $fp = fsockopen ($adr, 443, $errno, $errstr, 30);
        
        $payment_status = $_POST['payment_status'];
        $payment_currency = $_POST['mc_currency'];
        $receiver_email = $_POST['receiver_email'];
  
        

        if (!$fp) {
            // HTTP ERROR
        }
        else {
            fputs ($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets ($fp, 1024);
                if (strcmp($res, 'VERIFIED') == 0) {
                    
                    if($payment_status == 'Completed'){  
                      
                        //Verify if the payment have been done on YOUR account with the right CURRENCY
                        if($receiver_email == $conf['email_account']
                           && $payment_currency = $conf['currency_code']){
                            
                            $paymentService = jClasses::getService($conf['classe_service_payment']);
                            $paymentService->processAfterPayment($_POST);
                            if($conf['save_payments'])
                                $this->savePayment($_POST);
                            
                        }
                      
                    }
                }
                else if (strcmp ($res, "INVALID") == 0) {
                    jLog::dump($_POST, 'Invalid payment', 'jediPaypal');
                }
            }
            fclose ($fp);
        }

        return $rep;
    }
    
    
    private function loadConfig(){
        
        global $gJConfig;
        $conf = $gJConfig->jediPaypal;
        if($conf == null)
            throw new jException('You must specify  parameters for jediPaypal module');
        
        if(!isset($conf['email_account']))
            throw new jException('You must specify your paypal email account on the config of jediPaypal module');
            
        if(!isset($conf['classe_service_payment']))
            throw new jException('You must specify a classe that manage the payment on the config of jediPaypal module');
            
        if(!isset($conf['currency_code']))
            throw new jException('You must specify a currency code for your payment on the config of jediPaypal module');
        
        if(isset($conf['sandbox_mode']) && ($conf['sandbox_mode'] == 'on' OR $conf['sandbox_mode'] == 1))
            $conf['sandbox_mode'] = true;
        else 
            $conf['sandbox_mode'] = false;
            
        if(isset($conf['save_payments']) && ($conf['save_payments'] == 'on' OR $conf['save_payments'] == 1))
            $conf['save_payments'] = true;
        else 
            $conf['save_payments'] = false;
            
        return $conf;
    }
    
    private function savePayment($data){
        
        $record = jDao::createRecord('jediPaypal~payments');
        $record->currency = $data['mc_currency'];
        $record->amount = $data['mc_gross'];
        $record->transaction_id = $data['txn_id'];
        $record->payer_email = $data['payer_email'];
        $record->payer_id = $data['payer_id'];
        $record->item_name = $data['item_name'];
        $record->custom = $data['custom'];
        
        /*
        $event = jEvent::notify('jediPaypal_save_payment', array('data' => $data, 'record' => $record));
        $reps = $event->getResponse();
        */
        
        jDao::get('jediPaypal~payments')->insert($record);
    }
    
    
}