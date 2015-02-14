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

namespace SwissPaymentSlip\SwissPaymentSlipPdf\Tests;

use SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf;
use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlip;
use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlipData;

// Include Composer's autoloader
require __DIR__.'/../vendor/autoload.php';

/**
 * A wrapping class to allow testing the abstract class PaymentSlipData
 */
class TestablePaymentSlipData extends SwissPaymentSlipData
{
    public function getCodeLine($fillZeros = true)
    {
    }
}

/**
 * A wrapping class to allow testing the abstract class PaymentSlip
 */
class TestablePaymentSlip extends SwissPaymentSlip
{
}

/**
 * A wrapping class to allow testing the abstract class SwissPaymentSlipPdf
 */
class TestablePaymentSlipPdf extends PaymentSlipPdf
{
    protected function displayImage($background)
    {
    }

    protected function setFont($fontFamily, $fontSize, $fontColor)
    {
    }

    protected function setBackground($background)
    {
    }

    protected function setPosition($posX, $posY)
    {
    }

    protected function createCell($width, $height, $line, $textAlign, $fill)
    {
    }
}
