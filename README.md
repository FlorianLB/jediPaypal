Configuration
--------------------------------------------------
You must put this options on your defaultconfig.ini.php

    [jediPaypal]
    
    ; your email adress of your paypal account
    email_account = 'mypaypalemailadress@gmail.com'
    
    ; selector of the class that implement 'jediPaypal~IJediPayment', it will be called after each notification of payment from Paypal
    classe_service_payment = 'myapp~mypayment'
    
    ; activation of the sandbox mode (on|off)
    sandbox_mode = on
    
    ; thecurrency used for your transactions (EUR|USE|GBP|...)
    currency_code = EUR
    
    ; activate the auto save of the transaction in database (on|off)
    save_payments = on
    
    
Utilisation
--------------------------------------------------

This module provide (for the moment) only the "backend" treatment of your paypal payment. That's why, you must create the payment form (adressed to Paypal) by your own.

Once the payment have be done, jediPaypal will execute the method "processAfterPayment" of the class indicated in the config (this class must implement "jediPaypal~IJediPayment", you have an example in "jediPaypal~mypayment"). This method is called only after verfication of the payment validity, the correspondance of the paypal email account and the correspondance of the currency.

If the option "save_payments" is activated, the module will save in database each transaction (price, item name, transaction id, buyer email, etc).