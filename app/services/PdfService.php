<?php
// Placeholder: PdfService.php
<?php

class PdfService
{
    public static function generateInvoice($order)
    {
        $file = "invoice_" . $order['id'] . ".pdf";
        file_put_contents($file, "Invoice for Order #" . $order['id']);
        return $file;
    }
}
