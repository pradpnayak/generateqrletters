<?php

class CRM_GenerateQRLetters_PrintPDF {

  /**
   * Part of the post process which prepare and extract information from the template.
   *
   *
   * @param array $formValues
   *
   * @return array
   *   [$categories, $html_message
   */
  public static function processMessageTemplate(string $htmlMessage): string {

    //time being hack to strip '&nbsp;'
    //from particular letter line, CRM-6798
    self::formatMessage($htmlMessage);

    return $htmlMessage;
  }

  /**
   * @param $message
   */
  public static function formatMessage(string &$message) {
    $newLineOperators = [
      'p' => [
        'oper' => '<p>',
        'pattern' => '/<(\s+)?p(\s+)?>/m',
      ],
      'br' => [
        'oper' => '<br />',
        'pattern' => '/<(\s+)?br(\s+)?\/>/m',
      ],
    ];

    $htmlMsg = preg_split($newLineOperators['p']['pattern'], $message);
    foreach ($htmlMsg as $k => & $m) {
      $messages = preg_split($newLineOperators['br']['pattern'], $m);
      foreach ($messages as $key => & $msg) {
        $msg = trim($msg);
        $matches = [];
        if (preg_match('/^(&nbsp;)+/', $msg, $matches)) {
          $spaceLen = strlen($matches[0]) / 6;
          $trimMsg = ltrim($msg, '&nbsp; ');
          $charLen = strlen($trimMsg);
          $totalLen = $charLen + $spaceLen;
          if ($totalLen > 100) {
            $spacesCount = 10;
            if ($spaceLen > 50) {
              $spacesCount = 20;
            }
            if ($charLen > 100) {
              $spacesCount = 1;
            }
            $msg = str_repeat('&nbsp;', $spacesCount) . $trimMsg;
          }
        }
      }
      $m = implode($newLineOperators['br']['oper'], $messages);
    }
    $message = implode($newLineOperators['p']['oper'], $htmlMsg);
  }

  public static function createZip($files = [], $destination = NULL, $overwrite = FALSE) {
    // if the zip file already exists and overwrite is false, return false
    if (file_exists($destination) && !$overwrite) {
      return FALSE;
    }
    $valid_files = [];
    if (is_array($files)) {
      foreach ($files as $file) {
        // make sure the file exists
        if (file_exists($file)) {
          $validFiles[] = $file;
        }
      }
    }
    if (count($validFiles)) {
      $zip = new ZipArchive();
      if ($zip->open($destination, $overwrite ? ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== TRUE) {
        return FALSE;
      }
      foreach ($validFiles as $file) {
        $zip->addFile($file, CRM_Utils_File::cleanFileName(basename($file)));
      }
      $zip->close();
      return file_exists($destination);
    }
    else {
      return FALSE;
    }
  }
}
