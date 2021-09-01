<?php

namespace Drupal\qr_scan\Plugin\Block;

use Drupal\node\NodeInterface;
use Drupal\Core\Block\BlockBase;

/**
 * QR Code Generate Block.
 *
 * @Block(
 *   id = "qr_scan_block",
 *   admin_label = @Translation("QR Code Generate"),
 *   category = @Translation("Blocks")
 * )
 */
class QrScanBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    /* get the current node from router */
    $node = \Drupal::routeMatch()->getParameter('node');

    if ($node instanceof NodeInterface) {

      $qr_service = \Drupal::service('qr_scan.qrcode');
      $qrcode = $qr_service->getQrcode($node);
      $file = $base_url . $qrcode;

    }

    $build['#markup'] = '<img src ="' . $file . '">';

    return $build;
  }

  /**
   * Caching removing for this block.
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
