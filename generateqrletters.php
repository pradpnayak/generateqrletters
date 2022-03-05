<?php

require_once 'generateqrletters.civix.php';
// phpcs:disable
use CRM_Generateqrletters_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function generateqrletters_civicrm_config(&$config) {
  _generateqrletters_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function generateqrletters_civicrm_xmlMenu(&$files) {
  _generateqrletters_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function generateqrletters_civicrm_install() {
  _generateqrletters_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function generateqrletters_civicrm_postInstall() {
  _generateqrletters_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function generateqrletters_civicrm_uninstall() {
  _generateqrletters_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function generateqrletters_civicrm_enable() {
  _generateqrletters_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function generateqrletters_civicrm_disable() {
  _generateqrletters_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function generateqrletters_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _generateqrletters_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function generateqrletters_civicrm_managed(&$entities) {
  _generateqrletters_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function generateqrletters_civicrm_caseTypes(&$caseTypes) {
  _generateqrletters_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function generateqrletters_civicrm_angularModules(&$angularModules) {
  _generateqrletters_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function generateqrletters_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _generateqrletters_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function generateqrletters_civicrm_entityTypes(&$entityTypes) {
  _generateqrletters_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function generateqrletters_civicrm_themes(&$themes) {
  _generateqrletters_civix_civicrm_themes($themes);
}

/**
 * Implements hook_civicrm_searchTasks().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_searchTasks
 */
function generateqrletters_civicrm_searchTasks($objectName, &$tasks) {
  if ($objectName == 'contact') {
    $tasks[] = [
      'title' => ts('Generate QR Letters'),
      'class' => 'CRM_GenerateQRLetters_Form_Task_Letters',
      'result' => FALSE,
    ];
  }
}

/**
 * Implements hook_civicrm_tokens().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tokens
 */
function generateqrletters_civicrm_tokens(&$tokens) {
  $tokens['generateqrletters'] = [
    'generateqrletters.qrcode_1' => ts('Contribution Page QR Code 1'),
    'generateqrletters.qrcode_2' => ts('Contribution Page QR Code 2'),
    'generateqrletters.qrcode_3' => ts('Contribution Page QR Code 3'),
    'generateqrletters.qrcode_4' => ts('Contribution Page QR Code 4'),
    'generateqrletters.qrcode_5' => ts('Contribution Page QR Code 5'),
  ];
}

/**
 * Implements hook_civicrm_tokenValues().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tokenValues
 */
function generateqrletters_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokens = [], $context = NULL) {
  if (empty(CRM_GenerateQRLetters_Utils::$_contributionPageIds)) {
    return;
  }

  foreach ($cids as $cid) {
    CRM_GenerateQRLetters_Utils::generateQRCodeToken($values[$cid], $cid);
  }
}
