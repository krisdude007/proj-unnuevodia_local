
<?php

class StripeUtility {

    public static function config() {
        require_once('core/protected/vendor/stripe/init.php');

        $stripe = array(
          'secret_key'      => 'sk_test_0NUQd79oT84RYT3k2Z8zEATP',
          'publishable_key' => 'pk_test_9wvBHmpsc2n0hRoCGgxi12wD'
          //'secret_key'      => 'sk_live_5QB6FOoERjkyPjlh5nK0l1ej',
          //'publishable_key' => 'pk_live_jjMJkYqxB7rWcmvmY6Ims2At'
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        return $stripe;
    }

}

?>

