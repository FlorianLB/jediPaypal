<?php
/**
* @package jediPaypal
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @license    MIT
*/

interface IJediPayment{
    
    public function processAfterPayment($data);
    
}
