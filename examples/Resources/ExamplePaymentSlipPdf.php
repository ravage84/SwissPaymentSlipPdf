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

namespace SwissPaymentSlip\SwissPaymentSlipPdf\Examples;

use SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf;

/**
 * An example implementation of PaymentSlipPdf
 */
class ExamplePaymentSlipPdf extends PaymentSlipPdf
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
