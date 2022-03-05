<?php

class CRM_GenerateQRLetters_Utils {

  private static $_params;
  public static $_contributionPageIds = [
    1 => 1,
    2 => 2,
    3 => 3,
  ];

  public static function createPdfs(array $contactIds, array $params) {
    self::$_params = $params;
  }

  private static function createPdf(int $contactId) {

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
