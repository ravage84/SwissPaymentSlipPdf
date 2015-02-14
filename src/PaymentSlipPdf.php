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

namespace SwissPaymentSlip\SwissPaymentSlipPdf;

use SwissPaymentSlip\SwissPaymentSlip\SwissPaymentSlip;

/**
 * An abstract base class for concrete implementations for creating Swiss payment slips as PDFs
 *
 * Responsible for generating standard Swiss payment Slips
 * using a PDF engine, e.g. FPDF or TCPDF.
 * Layout done by utilizing PaymentSlip and
 * data organisation through PaymentSlipData.
 *
 * @link https://github.com/ravage84/SwissPaymentSlip/ SwissPaymentSlip
 * @link https://github.com/ravage84/SwissPaymentSlipTcpdf/ SwissPaymentSlipTcpdf
 * @link https://github.com/ravage84/SwissPaymentSlipFpdf/ SwissPaymentSlipFpdf
 */
abstract class PaymentSlipPdf
{
    /**
     * The PDF engine object to generate the PDF output
     *
     * @var null|object
     */
    protected $pdfEngine = null;

    /**
     * The payment slip object, which contains the payment slip data and layout information
     *
     * @var null|SwissPaymentSlip
     */
    protected $paymentSlip = null;

    /**
     *
     *
     * @param object $pdfEngine
     * @param SwissPaymentSlip $paymentSlip
     */
    public function __construct($pdfEngine, SwissPaymentSlip $paymentSlip)
    {
        if (!is_object($pdfEngine)) {
            throw new \InvalidArgumentException('$pdfEngine is not an object!');
        }
        $this->pdfEngine = $pdfEngine;
        $this->paymentSlip = $paymentSlip;
    }

    /**
     * @param $background
     * @return mixed
     */
    abstract protected function displayImage($background);

    /**
     * @param $fontFamily
     * @param $fontSize
     * @param $fontColor
     * @return mixed
     */
    abstract protected function setFont($fontFamily, $fontSize, $fontColor);

    /**
     * @param $background
     * @return mixed
     */
    abstract protected function setBackground($background);

    /**
     * @param $posX
     * @param $posY
     * @return mixed
     */
    abstract protected function setPosition($posX, $posY);

    /**
     * @param $width
     * @param $height
     * @param $line
     * @param $textAlign
     * @param $fill
     * @return mixed
     */
    abstract protected function createCell($width, $height, $line,$textAlign, $fill);

    /**
     * @param $elementName string
     * @param $element array
     */
    protected function writePaymentSlipLines($elementName, $element)
    {
        if (is_array($element)) {

            if (isset($element['lines']) && isset($element['attributes'])) {
                $lines = $element['lines'];
                $attributes = $element['attributes'];

                if (is_array($lines) && is_array($attributes)) {
                    $posX = $attributes['PosX'];
                    $posY = $attributes['PosY'];
                    $height = $attributes['Height'];
                    $width = $attributes['Width'];
                    $fontFamily = $attributes['FontFamily'];
                    $background = $attributes['Background'];
                    $fontSize = $attributes['FontSize'];
                    $fontColor = $attributes['FontColor'];
                    $lineHeight = $attributes['LineHeight'];
                    $textAlign = $attributes['TextAlign'];

                    $this->setFont($fontFamily, $fontSize, $fontColor);
                    if ($background != 'transparent') {
                        $this->setBackground($background);
                        $fill = true;
                    } else {
                        $fill = false;
                    }

                    foreach ($lines as $lineNr => $line) {
                        $this->setPosition($this->paymentSlip->getSlipPosX() + $posX, $this->paymentSlip->getSlipPosY() + $posY + ($lineNr * $lineHeight));
                        $this->createCell($width, $height, $line, $textAlign, $fill);
                    }
                }
            }
        }
    }

    /**
     * @param bool $formatted
     * @param bool $fillZeroes
     * @param bool $withBackground
     */
    public function createPaymentSlip($formatted = true, $fillZeroes = true, $withBackground = true) {
        $paymentSlip = $this->paymentSlip;

        // Place background
        if ($withBackground) {
            $this->displayImage($paymentSlip->getSlipBackground());
        }

        // go through all elements/element groups, write each line
        foreach ($paymentSlip->getAllElements($formatted, $fillZeroes) as $elementName => $element) {
            $this->writePaymentSlipLines($elementName, $element);
        }
    }
}
