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

namespace SwissPaymentSlip\SwissPaymentSlipPdf\Examples;

use SwissPaymentSlip\SwissPaymentSlipPdf\PaymentSlipPdf;

/**
 * An example implementation of PaymentSlipPdf
 */
class ExamplePaymentSlipPdf extends PaymentSlipPdf
{
    protected function displayImage($background)
    {
        echo sprintf('Display the background image "%s"<br>', $background);
    }

    protected function setFont($fontFamily, $fontSize, $fontColor)
    {
        echo sprintf('Set the font "%s" "%s" "%s"<br>', $fontFamily, $fontSize, $fontColor);
    }

    protected function setBackground($background)
    {
        echo sprintf('Set the background "%s"<br>', $background);
    }

    protected function setPosition($posX, $posY)
    {
        echo sprintf('Set the position to "%s"/"%s"<br>', $posX, $posY);
    }

    protected function createCell($width, $height, $line, $textAlign, $fill)
    {
        echo sprintf(
            'Create a cell; width: "%s"; height: "%s"; line: "%s"; textAlign: "%s"; fill: "%s"<br>',
            $width,
            $height,
            $line,
            $textAlign,
            $fill
        );
    }

    /**
     * Normally it is not necessary to overwrite this method
     *
     * {@inheritDoc}
     */
    protected function writePaymentSlipLines($elementName, $element)
    {
        echo sprintf('Write the element "%s"<br>', $elementName);
        parent::writePaymentSlipLines($elementName, $element);
        echo '<br>';

        return $this;
    }


}
