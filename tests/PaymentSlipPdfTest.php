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
 * @coversDefaultClass SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf
 */
class PaymentSlipTest extends \PHPUnit_Framework_TestCase
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
        new TestablePaymentSlipPdf('FooBar');
    }

    /**
     * Tests the constructor with valid parameters
     *
     * @return void
     * @covers ::__construct
     */
    public function testConstructor()
    {
        new TestablePaymentSlipPdf((object)'FooBar');
    }

    /**
     * Tests the createPaymentSlip method with a valid payment slip
     *
     * @return void
     * @expectedException \PHPUnit_Framework_Error
     * @expectedExceptionMessage Argument 1 passed to SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf::createPaymentSlip() must be an instance of SwissPaymentSlip\SwissPaymentSlip\PaymentSlip, instance of stdClass given
     * @covers ::createPaymentSlip
     */
    public function testConstructorInvalidPaymentSlip()
    {
        $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar');
        $paymentSlipPdf->createPaymentSlip((object)'NotAPaymentSlip');
    }

    /**
     * Tests the createPaymentSlip method with a valid payment slip
     *
     * @return void
     * @covers ::createPaymentSlip
     */
    public function testCreatePaymentSlip()
    {
        $paymentSlipPdf = $this->getMock(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            array('writePaymentSlipLines', 'displayImage'),
            array((object)'FooBar')
        );

        // Setup expectations
        $paymentSlipPdf->expects($this->exactly(12))
            ->method('writePaymentSlipLines')
            ->will($this->returnSelf());
        $paymentSlipPdf->expects($this->once())
            ->method('displayImage')
            ->will($this->returnSelf());

        $slipData = new TestablePaymentSlipData();
        $paymentSlip = new TestablePaymentSlip($slipData);
        $paymentSlipPdf->createPaymentSlip($paymentSlip);
    }

    /**
     * Tests the writePaymentSlipLines method
     *
     * @return void
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLines()
    {
        $paymentSlipPdf = $this->getMock(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            array('setFont', 'setBackground', 'setPosition', 'displayImage', 'createCell'),
            array((object)'FooBar')
        );

        // Setup expectations
        $paymentSlipPdf->expects($this->exactly(12))
            ->method('setFont');
        $paymentSlipPdf->expects($this->exactly(0))
            ->method('setBackground');
        $paymentSlipPdf->expects($this->exactly(26))
            ->method('setPosition');
        $paymentSlipPdf->expects($this->exactly(26))
            ->method('createCell');

        $slipData = new TestablePaymentSlipData();
        $paymentSlip = new TestablePaymentSlip($slipData);
        $paymentSlipPdf->createPaymentSlip($paymentSlip);
    }
}
