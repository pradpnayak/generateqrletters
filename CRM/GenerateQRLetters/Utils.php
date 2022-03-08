<?php

class CRM_GenerateQRLetters_Utils {

  public static $_contributionPageIds = [];
  public static $_settings;

  public static function createPdfs(array $contactIds, array $params, int $queueId = NULL): bool {
    self::$_contributionPageIds = $params['contribution_page_ids'] ?? [];
    $batchLimit = CRM_GenerateQRLetters_Utils::getSettingValue('batch_limit_per_pdf');
    $htmlMessage = CRM_GenerateQRLetters_PrintPDF::processMessageTemplate(
      $params['html_message']
    );

    $pdfFilename = [];
    if (count($contactIds) > $batchLimit) {
      if ($queueId !== NULL) {
        $config = CRM_Core_Config::singleton();
        $fname = ts('CiviLetters') . date('YmdHis') . '.zip';
        $zip = $config->customFileUploadDir . $fname;

        foreach (array_chunk($contactIds, $batchLimit) as $cids) {
          $pdfFilename[] = self::createPdf($cids, $htmlMessage, TRUE);
        }

        CRM_GenerateQRLetters_PrintPDF::createZip($pdfFilename, $zip);
        $fileId = civicrm_api3('Attachment', 'create', [
          'entity_table' => 'civicrm_qr_letters_cache',
          'entity_id' => $queueId,
          'name' => $fname,
          'mime_type' => 'application/zip',
          'options' => [
            'move-file' => $zip,
          ],
        ])['id'];
        self::sendEmail($fileId, $queueId);
      }
      else {
        $params['contact_ids'] = $contactIds;
        unset($params['html_message']);
        civicrm_api3('GenerateQRLettersCache', 'create', [
          'form_values' => json_encode($params),
          'html_message' => $htmlMessage,
        ]);
      }
    }
    else {
      self::createPdf($contactIds, $htmlMessage);
      CRM_Utils_System::civiExit(1);
    }
    return TRUE;
  }

  private static function sendEmail($fileId, $queueId) {
    $toEmail = CRM_GenerateQRLetters_Utils::getSettingValue('email_to');
    $toEmail = trim($toEmail);
    $toEmail = explode(',', $toEmail);
    $toEmail = array_filter($toEmail);
    if (empty($toEmail)) {
      return;
    }

    $url = self::getfileUrl($queueId, $fileId);
    $p = [
      'subject' => ts('Letters are ready for Download'),
      'html' => $url,
      'toEmail' => array_shift($toEmail),
      'cc' => implode(',', $toEmail),
      'from' => civicrm_api3('OptionValue', 'getvalue', [
        'return' => "label",
        'option_group_id' => "from_email_address",
        'is_default' => 1,
        'options' => ['limit' => 1],
      ])
    ];
    $send = CRM_Utils_Mail::send($p);
  }
  public static function getfileUrl($entityId, $fileId) {
    $fileHash = CRM_Core_BAO_File::generateFileHash($entityId, $fileId);
    return CRM_Utils_System::url(
      'civicrm/file', 'reset=1&id=' . $fileId . '&eid=' . $entityId . '&fcs=' . $fileHash,
      TRUE, NULL, FALSE, TRUE
    );
  }

  private static function createPdf(array $contactIds, $htmlMessage, $output = FALSE): string {
    $fileName = ts('CiviLetter') . md5(json_encode($contactIds) . date('YmdHis')) . '.pdf';
    $pdfFilename = '';
    if ($output) {
      $pdfFilename = CRM_Core_Config::singleton()->templateCompileDir . CRM_Utils_File::makeFileName($fileName);
    }

    foreach ($contactIds as $contactId) {
      $tokenHtml = CRM_Core_BAO_MessageTemplate::renderTemplate([
        'contactId' => $contactId,
        'messageTemplate' => ['msg_html' => $htmlMessage],
        'tokenContext' => [],
        'disableSmarty' => (!defined('CIVICRM_MAIL_SMARTY') || !CIVICRM_MAIL_SMARTY),
      ])['html'];

      $html[] = $tokenHtml;
    }

    $outputData = CRM_Utils_PDF_Utils::html2pdf($html, $fileName, $output, []);
    if ($output) {
      file_put_contents($pdfFilename, $outputData);
    }
    return $pdfFilename;
  }

  public static function generateQRCodeToken(array &$value, int $contactId) {
    $contributionPageIds = CRM_GenerateQRLetters_Utils::$_contributionPageIds ?? [];
    $cs = CRM_Contact_BAO_Contact_Utils::generateChecksum($contactId, NULL, 'inf');

    foreach ($contributionPageIds as $k => $contributionPageId) {
      $url = CRM_Utils_System::url('civicrm/contribute/transact', [
        'reset' => 1,
        'id' => $contributionPageId,
        'cid' => $contactId,
        'cs' => $cs,
      ], TRUE, NULL, FALSE, TRUE);
      $value["generateqrletters.qrcode_{$k}"] = self::generateQRCode($url);
    }
  }

  public static function getSettingValue($name) {
    if (empty(self::$_settings)) {
      self::$_settings = civicrm_api3('Setting', 'getvalue', [
        'name' => 'generateqrletters',
      ]);
    }
    return self::$_settings[$name];
  }

  private static function generateQRCode(string $url): string {
    $options = new chillerlan\QRCode\QROptions([
      'outputType' => chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
      'imageBase64' => TRUE,
      'imageTransparent' => FALSE,
    ]);
    $data = (new chillerlan\QRCode\QRCode($options))->render($url);
    return ts('<img alt="QR Code with link to Donation page" src="%1">', [1 => $data]);
  }

}
