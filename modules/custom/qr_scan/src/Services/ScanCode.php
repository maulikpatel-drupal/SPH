<?php

namespace Drupal\qr_scan\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

/**
 * Class ScanCode.
 */
class ScanCode {

  /**
   * Function to generate qrcode.
   */
  public function getQrcode($node) {

    $writer = new PngWriter();
    // Create QR code.
    $qrCode = QrCode::create($node->get('field_purchase_link')->uri)
      ->setEncoding(new Encoding('UTF-8'))
      ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
      ->setSize(300)
      ->setMargin(10)
      ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
      ->setForegroundColor(new Color(0, 0, 0))
      ->setBackgroundColor(new Color(255, 255, 255));

    // Create generic label.
    $label = Label::create($node->getTitle())
      ->setTextColor(new Color(255, 0, 0));

    $result = $writer->write($qrCode, $logo, $label);

    // Directly output the QR code.
    header('Content-Type: ' . $result->getMimeType());
    $file_directory = \Drupal::service('file_system')->realpath('public://generated_qrcode');
    $name = $node->getTitle() . $node->id() . '.png';
    $qrcode_path = $file_directory . '/' . $name;
    $qrcode = '/sites/default/files/generated_qrcode/';
    $result->saveToFile($qrcode_path);

    return $qrcode . $name;
  }

}
