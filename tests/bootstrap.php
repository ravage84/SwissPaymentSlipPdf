<?php
/**
 * Swiss Payment Slip PDF
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright 2012-2015 Some nice Swiss guys
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @author Marc Würth ravage@bluewin.ch
 * @link https://github.com/sprain/class.Einzahlungsschein.php
 */

namespace SwissPaymentSlip\SwissPaymentSlipPdf\Tests;

use SwissPaymentSlip\SwissPaymentSlipPdf\SwissPaymentSlipPdf;

// Include Composer's autoloader
require __DIR__.'/../vendor/autoload.php';

/**
 * A wrapping class to allow testing the abstract class SwissPaymentSlipPdf
 */
class TestablePaymentSlipPdf extends SwissPaymentSlipPdf
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

    protected function createCell($width, $height, $line,$textAlign, $fill)
    {
    }
}
