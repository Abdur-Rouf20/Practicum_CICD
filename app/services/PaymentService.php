<?php
// Placeholder: PaymentService.php
<?php
require_once __DIR__ . "/../models/Payment.php";

class PaymentService
{
    public static function process($orderId, $amount, $method)
    {
        // Mock success for now
        Payment::log($orderId, $amount, $method, "success");
        return true;
    }
}
