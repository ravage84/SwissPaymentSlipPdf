<?php
/**
 * Swiss Payment Slip PDF
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright 2012-2015 Some nice Swiss guys
 * @author Marc Würth <ravage@bluewin.ch>
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
     * @expectedException \TypeError
     * @expectedExceptionMessage Argument 1 passed to SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf::createPaymentSlip() must be an instance of SwissPaymentSlip\SwissPaymentSlip\PaymentSlip, instance of stdClass given
     * @covers ::createPaymentSlip
     */
    public function testConstructorInvalidPaymentSlip()
    {
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('This test fails on HHVM due to error message varieties');
        }
        $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar');
        $paymentSlipPdf->createPaymentSlip((object)'NotAPaymentSlip');
    }

    /**
     * Tests the createPaymentSlip method
     *
     * @return void
     * @covers ::createPaymentSlip
     */
    public function testCreatePaymentSlip()
    {
        $paymentSlipPdf = $this->getMock(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            ['writePaymentSlipLines', 'displayImage'],
            [(object)'FooBar']
        );

        // $paymentSLip property should not be set
        $this->assertAttributeEquals(null, 'paymentSlip', $paymentSlipPdf);

        // Setup expectations
        $expectedElements = [
            'bankLeft',
            'bankRight',
            'recipientLeft',
            'recipientRight',
            'accountLeft',
            'accountRight',
            'amountFrancsLeft',
            'amountFrancsRight',
            'amountCentsLeft',
            'amountCentsRight',
            'payerLeft',
            'payerRight',
        ];
        foreach ($expectedElements as $elementNr => $elementName) {
            $paymentSlipPdf->expects($this->at($elementNr + 1))
                ->method('writePaymentSlipLines')
                ->with(
                    $elementName,
                    $this->anything()
                );
        }
        $paymentSlipPdf->expects($this->exactly(12))
            ->method('writePaymentSlipLines')
            ->will($this->returnSelf());
        $paymentSlipPdf->expects($this->once())
            ->method('displayImage')
            ->will($this->returnSelf());

        $slipData = new TestablePaymentSlipData();
        $paymentSlip = new TestablePaymentSlip($slipData);
        $paymentSlipPdf->createPaymentSlip($paymentSlip);

        // $paymentSLip property should be null again
        $this->assertAttributeEquals(null, 'paymentSlip', $paymentSlipPdf);
    }

    /**
     * Tests the createPaymentSlip method when no background image is displayed
     *
     * @return void
     * @covers ::createPaymentSlip
     */
    public function testCreatePaymentSlipNoBackground()
    {
        $paymentSlipPdf = $this->getMock(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            ['writePaymentSlipLines', 'displayImage'],
            [(object)'FooBar']
        );

        // Setup expectations
        // Twelve elements
        $paymentSlipPdf->expects($this->exactly(12))
            ->method('writePaymentSlipLines')
            ->will($this->returnSelf());
        $paymentSlipPdf->expects($this->never())
            ->method('displayImage')
            ->will($this->returnSelf());

        $slipData = new TestablePaymentSlipData();
        $paymentSlip = new TestablePaymentSlip($slipData);
        $paymentSlip->setDisplayBackground(false);
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
            ['setFont', 'setBackground', 'setPosition', 'displayImage', 'createCell'],
            [(object)'FooBar']
        );

        // Setup expectations
        // Twelve elements, some elements with more than one line
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

    /**
     * Tests the writePaymentSlipLines method with an element that has a background set
     *
     * @return void
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLinesElementWithBackground()
    {
        $paymentSlipPdf = $this->getMock(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            ['setFont', 'setBackground', 'setPosition', 'displayImage', 'createCell'],
            [(object)'FooBar']
        );

        // Setup expectations
        $paymentSlipPdf->expects($this->exactly(12))
            ->method('setFont');
        $paymentSlipPdf->expects($this->exactly(1))
            ->method('setBackground')
            ->with($this->equalTo('#AABBCC'));
        $paymentSlipPdf->expects($this->exactly(26))
            ->method('setPosition');
        $paymentSlipPdf->expects($this->exactly(26))
            ->method('createCell');

        $slipData = new TestablePaymentSlipData();
        $paymentSlip = new TestablePaymentSlip($slipData);
        $paymentSlip->setBankLeftAttr(null, null, null, null, '#AABBCC');
        $paymentSlipPdf->createPaymentSlip($paymentSlip);
    }

    /**
     * Tests the writePaymentSlipLines method with an invalid first parameter
     *
     * @return void
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $elementName is not a string!
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLinesInvalidFirstParameter()
    {
        $method = $this->makeMethodAccessible(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            'writePaymentSlipLines'
        );
        $method->invoke(
            $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar'),
            [],
            []
        );
    }

    /**
     * Tests the writePaymentSlipLines method with an invalid second parameter
     *
     * @return void
     * @expectedException \TypeError
     * @expectedExceptionMessage Argument 2 passed to SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf::writePaymentSlipLines() must be of the type array, string given
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLinesInvalidSecondParameter()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            $this->markTestSkipped('This test fails on PHP 5.3 due to error message varieties');
        }
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('This test fails on HHVM due to error message varieties');
        }
        $method = $this->makeMethodAccessible(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            'writePaymentSlipLines'
        );
        $method->invoke(
            $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar'),
            'elementName',
            'notAnArray'
        );
    }

    /**
     * Tests the writePaymentSlipLines method with no 'lines' key
     *
     * @return void
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $element contains not "lines" key!
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLinesNoLinesKey()
    {
        $method = $this->makeMethodAccessible(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            'writePaymentSlipLines'
        );
        $method->invoke(
            $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar'),
            'elementName',
            ['attributes' => []]
        );
    }

    /**
     * Tests the writePaymentSlipLines method with no 'attributes' key
     *
     * @return void
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $element contains not "attributes" key!
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLinesNoAttributesKey()
    {
        $method = $this->makeMethodAccessible(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            'writePaymentSlipLines'
        );
        $method->invoke(
            $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar'),
            'elementName', ['lines' => []]
        );
    }

    /**
     * Tests the writePaymentSlipLines method with 'lines' key being no array
     *
     * @return void
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $lines is not an array!
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLinesLinesKeyNoArray()
    {
        $method = $this->makeMethodAccessible(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            'writePaymentSlipLines'
        );
        $method->invoke(
            $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar'),
            'elementName', ['lines' => 'notAnArray', 'attributes' => []]
        );
    }

    /**
     * Tests the writePaymentSlipLines method with 'attributes' key being no array
     *
     * @return void
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $attributes is not an array!
     * @covers ::writePaymentSlipLines
     */
    public function testWritePaymentSlipLinesAttributesKeyNoArray()
    {
        $method = $this->makeMethodAccessible(
            'SwissPaymentSlip\SwissPaymentSlipPdf\Tests\TestablePaymentSlipPdf',
            'writePaymentSlipLines'
        );
        $method->invoke(
            $paymentSlipPdf = new TestablePaymentSlipPdf((object)'FooBar'),
            'elementName',
            ['lines' => [], 'attributes' => 'notAnArray']
        );
    }

    /**
     * Make a protected method public using the Reflection API
     *
     * @param string $className The full name of the class incl. namespace
     * @param string $methodName The name of the method to make accessible.
     * @return \ReflectionMethod The now public method
     */
    protected function makeMethodAccessible($className, $methodName) {
        $method = new \ReflectionMethod($className, $methodName);
        $method->setAccessible(true);
        return $method;
    }
}
