<?php
/**
 * Swiss Payment Slip PDF
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright 2012-2015 Some nice Swiss guys
 * @author Marc Würth ravage@bluewin.ch
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @link https://github.com/ravage84/SwissPaymentSlipPdf/
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SwissPaymentSlip Example 01-01: OrangePaymentSlip basic usage</title>
</head>
<body>
<h1>SwissPaymentSlip Example 02-01: OrangePaymentSlip basic usage</h1>
<?php
// Make sure the classes get auto-loaded
require __DIR__.'/../vendor/autoload.php';

// Load the example implementation of PaymentSlipPdf class
require __DIR__. '/Resources/ExamplePaymentSlipPdf.php';

// Import necessary classes
use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlipData;
use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlip;
use SwissPaymentSlip\SwissPaymentSlipPdf\Examples\ExamplePaymentSlipPdf;

// Create a pseudo PDF engine, because we have none at hand right now
$pseudoPdfEngine = (object)'Not a real PDF engine';

// Create a payment slip data container, which could bef filled with the actual data
$slipData = new SwissPaymentSlipData();

// Create a payment slip, which contains the layout information, using the payment slip data container
$paymentSlip = new SwissPaymentSlip($slipData);

// Create an object of our example implementation using the pseudo PDF engine and the payment slip
$paymentSlipPdf = new ExamplePaymentSlipPdf($pseudoPdfEngine, $paymentSlip);

// Dump object to screen
echo "This is how your slip object looks now: <br>";
var_dump($paymentSlipPdf);
?>
</body>
</html>
