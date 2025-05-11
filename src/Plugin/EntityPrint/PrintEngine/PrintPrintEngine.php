<?php

namespace Drupal\entity_print_print\Plugin\EntityPrint\PrintEngine;

use Drupal\Core\Form\FormStateInterface;
use Drupal\entity_print\Plugin\ExportTypeInterface;
use Drupal\entity_print\Plugin\PrintEngineBase;

/**
 * Print Print plugin implementation.
 *
 * @PrintEngine(
 *   id = "printprintengine",
 *   label = @Translation("PrintPrint"),
 *   export_type = "pdf"
 * )
 */
class PrintPrintEngine extends PrintEngineBase {

  /**
   * @var string
   */
  protected $html = '';

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ExportTypeInterface $export_type) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $export_type);
  }

  /**
   * {@inheritdoc}
   */
  public function addPage($content) {
    $this->html .= (string) $content;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function send($filename, $force_download = TRUE) {
    header("Cache-Control: private");
    header("Content-Type: text/html");

    $js =<<<'ENDJS'
<script type="text/javascript">
window.print();
</script>
ENDJS;

    echo $this->html . $js;
  }

  /**
   * {@inheritdoc}
   */
  public function getBlob() {
    return $this->html;
  }

  /**
   * {@inheritdoc}
   */
  public static function dependenciesAvailable() {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getPrintObject() {
    return NULL;
  }

}
