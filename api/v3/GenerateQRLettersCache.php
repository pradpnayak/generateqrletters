<?php
/**
 * This api exposes CiviCRM GenerateQRLettersCache.
 *
 * @package CiviCRM_APIv3
 */

/**
 * Save a GenerateQRLettersCache.
 *
 * @param array $params
 *
 * @return array
 */
function civicrm_api3_generate_q_r_letters_cache_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'GenerateQRLettersCache');
}

/**
 * Get a GenerateQRLettersCache.
 *
 * @param array $params
 *
 * @return array
 *   Array of retrieved GenerateQRLettersCache property values.
 */
function civicrm_api3_generate_q_r_letters_cache_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Delete a GenerateQRLettersCache.
 *
 * @param array $params
 *
 * @return array
 *   Array of deleted values.
 */
function civicrm_api3_generate_q_r_letters_cache_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

function civicrm_api3_generate_q_r_letters_cache_processletters($params) {
  $minutesOld = CRM_GenerateQRLetters_Utils::getSettingValue('time_to_delete');

  $date = date('YmdHis', strtotime("-{$minutesOld} minute"));
  $results = CRM_Core_DAO::executeQuery('
    SELECT c.id
    FROM `civicrm_qr_letters_cache` c
      LEFT JOIN civicrm_entity_file f
      ON f.entity_id = c.id
        AND f.entity_table = "civicrm_qr_letters_cache"
    WHERE f.id IS NOT NULL
      AND datetime < ' . $date);

  while ($results->fetch()) {
    civicrm_api3('Attachment', 'delete', [
      'entity_table' => 'civicrm_qr_letters_cache',
      'entity_id' => $results->id,
    ]);

    civicrm_api3('GenerateQRLettersCache', 'delete', [
      'id' => $results->id,
    ]);

  }

  $results = CRM_Core_DAO::executeQuery('
    SELECT c.*
    FROM `civicrm_qr_letters_cache` c
      LEFT JOIN civicrm_entity_file f
      ON f.entity_id = c.id
        AND f.entity_table = "civicrm_qr_letters_cache"
    WHERE f.id IS NULL
    ORDER BY datetime ASC
    LIMIT 1
  ');

  while ($results->fetch()) {
    $fValues = json_decode($results->form_values, TRUE);
    $params = [
      'html_message' => $results->html_message,
      'contribution_page_ids' => $fValues['contribution_page_ids'],
    ];

    CRM_GenerateQRLetters_Utils::createPdfs($fValues['contact_ids'], $params, $results->id);
  }
  return civicrm_api3_create_success(1);
}
