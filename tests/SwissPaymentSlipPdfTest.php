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

namespace SwissPaymentSlip\SwissPaymentSlip\Tests;

use SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlip;
use SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipData;
use SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf;

/**
 * Tests for the OrangePaymentSlipPdf class
 *
 * @coversDefaultClass SwissPaymentSlip\SwissPaymentSlipPdf\SwissPaymentSlipPdf
 */
class SwissPaymentSlipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the constructor with an invalid PDF engine object
     *
     * @return void
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $pdfEngine is not an object!
     * @covers ::__construct
     */
    public function testConstructorInvalidPdfEngine()
    {
        $slipData = new TestablePaymentSlipData();
        $paymentSlip = new TestablePaymentSlip($slipData);
        new TestablePaymentSlipPdf('FooBar', $paymentSlip);
    }

    /**
     * Tests the constructor with an invalid payment slip object
     *
     * @return void
     * @expectedException \PHPUnit_Framework_Error
     * @expectedExceptionMessage Argument 2 passed to SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf::__construct() must be an instance of SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlip, instance of stdClass given
     * @covers ::__construct
     */
    public function testConstructorInvalidPaymentSlip()
    {
        new TestablePaymentSlipPdf((object)'FooBar', (object)'');
    }

    /**
     * Tests the constructor with valid parameters
     *
     * @return void
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $slipData = new TestablePaymentSlipData();
        $paymentSlip = new TestablePaymentSlip($slipData);
        new TestablePaymentSlipPdf((object)'FooBar', $paymentSlip);
    }
}
