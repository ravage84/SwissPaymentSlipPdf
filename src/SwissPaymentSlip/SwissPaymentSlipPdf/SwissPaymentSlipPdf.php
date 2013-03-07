<?php
/**
 * Swiss Payment Slip as PDF
 *
 * PHP version >= 5.3.0
 *
 * @licence MIT
 * @copyright 2012-2013 Some nice Swiss guys
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @author Marc Würth ravage@bluewin.ch
 * @link https://github.com/sprain/class.Einzahlungsschein.php
 * @version: 0.5.0
 */

namespace SwissPaymentSlip\SwissPaymentSlipPdf;

/**
 * Responsible for generating standard Swiss payment Slips using FPDF as engine.
 * Layout done by utilizing SwissPaymentSlip
 * Data organisation through SwissPaymentSlipData
 */
abstract class SwissPaymentSlipPdf
{
	/**
	 * The PDF engine object to generate the PDF output
	 *
	 * @var null|object The PDF engine object
	 */
	protected $pdfEngine = null;

	/**
	 * The payment slip object, which contains the payment slip data
	 *
	 * @var null|SwissPaymentSlip The payment slip object
	 */
	protected $paymentSlip = null;

	/**
	 *
	 *
	 * @param object $pdfEngine
	 * @param SwissPaymentSlip $paymentSlip
	 */
	public function __construct($pdfEngine, $paymentSlip)
	{
		if (is_object($pdfEngine)) {
			$this->pdfEngine = $pdfEngine;
		} else {
			// throw error
		}
		if (is_object($paymentSlip)) {
			$this->paymentSlip = $paymentSlip;
		} else {
			// throw error
		}
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
	 * @param $element
	 */
	protected function writePaymentSlipLines($element) {

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
			$this->writePaymentSlipLines($element);
		}
	}
}