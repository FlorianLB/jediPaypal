<?php
/**
* @package jediPaypal
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @license    MIT
*/


/**
*
* This class is a basic implementation. You must execute your own business rules in the processAfterPayment function
* jediPaypal has already check the currency and the paypal account that received the money.
*
*/


jClasses::incIface('jediPaypal~IJediPayment');

class mypayment implements IJediPayment{
    
      public function processAfterPayment($data){
       
        jLog::dump($data, 'Payment OK');
       
        /*
        $item_name = $data['item_name'];
        $item_number = $data['item_number'];
        $payment_status = $data['payment_status'];
        $payment_amount = $data['mc_gross'];
        $payment_currency = $data['mc_currency'];
        $txn_id = $data['txn_id'];
        $receiver_email = $data['receiver_email'];
        $payer_email = $data['payer_email'];
        parse_str($data['custom'], $custom);
        //and many other variable
        */
      }
    
}