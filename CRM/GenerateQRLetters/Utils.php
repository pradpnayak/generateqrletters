<?php

class CRM_GenerateQRLetters_Utils {

  private static $_params;
  public static $_contributionPageIds;

  public static function createPdfs(array $contactIds, array $params) {
    self::$_params = $params;
  }

  private static function createPdf(int $contactId) {

  }

  public static function generateQRCodeToken(array &$value, int $contactId) {
    $contributionPageIds = CRM_GenerateQRLetters_Utils::$_contributionPageIds ?? [];
    $cs = CRM_Contact_BAO_Contact_Utils::generateChecksum($contactId, NULL, 'inf');
    foreach ($contributionPageIds as $contributionPageId) {
      $url = CRM_Utils_System::url('civicrm/contribute/transact', [
        'reset' => 1,
        'id' => $contributionPageId,
        'cid' => $contactId,
        'cs' => $cs,
      ], TRUE, NULL, FALSE, TRUE);
    }
  }

}
