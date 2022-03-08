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
  $entities[] = [
    'module' => 'generateqrletters',
    'name' => 'generateqrletters_zip_ext',
    'update' => 'never',
    'entity' => 'OptionValue',
    'params' => [
      'label' => 'zip',
      'name' => 'zip',
      'option_group_id' => 'safe_file_extension',
      'is_active' => 1,
      'version' => 3,
      'options' => ['match' => ['option_group_id', 'name']],
    ],
  ];
  $entities[] = [
    'module' => 'generateqrletters',
    'name' => 'generateqrletters_job',
    'entity' => 'Job',
    'update' => 'never',
    'params' => [
      'version' => 3,
      'name' => 'Process Letters',
      'description' => 'Process Letters',
      'run_frequency' => 'Always',
      'api_entity' => 'GenerateQRLettersCache',
      'api_action' => 'processletters',
      'parameters' => '',
      'is_active' => TRUE,
    ],
  ];
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
 * Implements hook_civicrm_alterSettingsMetaData().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsMetaData
 */
function generateqrletters_civicrm_alterSettingsMetaData(&$settingsMetaData, $domainID, $profile) {
  $settingsMetaData['generateqrletters'] = [
    'group_name' => 'GenerateQRLetters Preferences',
    'group' => 'generateqrletters',
    'name' => 'generateqrletters',
    'type' => 'Array',
    'html_type' => 'select',
    'quick_form_type' => 'Element',
    'default' => '',
    'add' => '5.40',
    'title' => ts('QR Letters Settings'),
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => '',
    'help_text' => '',
  ];
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
  $tokens['generateqrletters'] = [];
  $noContPages = CRM_GenerateQRLetters_Utils::getSettingValue('no_contribution_page_ids');
  for ($i = 1; $i <= $noContPages; $i++) {
    $tokens['generateqrletters']["generateqrletters.qrcode_{$i}"] = ts('Contribution Page QR Code ') . $i;
  }
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

  require_once __DIR__ . '/vendor/autoload.php';

  foreach ($cids as $cid) {
    CRM_GenerateQRLetters_Utils::generateQRCodeToken($values[$cid], $cid);
  }
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 */
function generateqrletters_civicrm_navigationMenu(&$menu) {
  _generateqrletters_civix_insert_navigation_menu($menu, 'Administer/System Settings', [
    'label' => ts('QR Letters Settings', ['domain' => 'generateqrletters']),
    'name' => 'QR Letters Settings',
    'url' => CRM_Utils_System::url(
      'civicrm/admin/generateqrletters/settings',
      'reset=1',
      TRUE
    ),
    'active' => 1,
    'permission_operator' => 'AND',
    'permission' => 'administer CiviCRM ',
  ]);
}

/**
 * Implements hook_civicrm_check().
 *
 * @throws \CiviCRM_API3_Exception
 */
function generateqrletters_civicrm_check(&$messages) {
  $results = CRM_Core_DAO::executeQuery('
    SELECT c.id, c.datetime, f.file_id
    FROM `civicrm_qr_letters_cache` c
      LEFT JOIN civicrm_entity_file f
      ON f.entity_id = c.id
        AND f.entity_table = "civicrm_qr_letters_cache"
    ORDER BY datetime DESC
  ')->fetchAll();

  if (empty($results)) {
    return;
  }

  $message = '<table><tr><th>Date</th><th>Letters</th></tr>';
  $dateFormat = CRM_Core_Config::singleton()->dateformatDatetime;
  foreach ($results as $result) {
    $date = CRM_Utils_Date::customFormat($result['datetime'], $dateFormat);
    $file = ts('Processing.....');
    if (!empty($result['file_id'])) {
      $url = CRM_GenerateQRLetters_Utils::getfileUrl($result['id'], $result['file_id']);
      $file = '<a href="' . $url . '"><i class="crm-i fa-paperclip" aria-hidden="true"></i></a>';
    }
    $message .= "<tr><td>{$date}</td><td>{$file}</td></tr>";
  }
  $message .= '</table>';
  $msg = new CRM_Utils_Check_Message(
    __FUNCTION__,
    $message,
    ts('QR Letters'),
    \Psr\Log\LogLevel::INFO,
    'fa-download'
  );
  $messages[] = $msg;
}
