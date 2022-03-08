<?php
/*
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC. All rights reserved.                        |
 |                                                                    |
 | This work is published under the GNU AGPLv3 license with some      |
 | permitted exceptions and without any warranty. For full license    |
 | and copyright information, see https://civicrm.org/licensing       |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 */

/**
 * This class provides the functionality to delete a group of
 * Activities. This class provides functionality for the actual
 * deletion.
 */
class CRM_GenerateQRLetters_Form_Task_Letters extends CRM_Contact_Form_Task {

  /**
   * Are we operating in "single mode", i.e. deleting one
   * specific Activity?
   *
   * @var bool
   */
  protected $_single = FALSE;

  /**
   * @var bool
   */
  public $submitOnce = TRUE;

  /**
   * Build all the data structures needed to build the form.
   */
  public function preProcess() {
    parent::preProcess();
    $this->setTitle(ts('Generate QR Letters'));
    $noContPages = CRM_GenerateQRLetters_Utils::getSettingValue('no_contribution_page_ids');

    $this->assign('contributionPages', $noContPages + 1);
  }

  /**
   * Build the form object.
   */
  public function buildQuickForm() {
    $noContPages = CRM_GenerateQRLetters_Utils::getSettingValue('no_contribution_page_ids');
    $this->addDefaultButtons(ts('Generate Invoice'));
    CRM_Mailing_BAO_Mailing::commonCompose($this);
    for ($i = 1; $i <= $noContPages; $i++) {
      $this->addEntityRef("contribution_page_ids[{$i}]", ts('Contribution Page ' . $i), [
        'context' => 'search',
        'entity' => 'ContributionPage',
        'select' => ['minimumInputLength' => 0],
      ]);
    }
    $buttons[] = [
      'type' => 'upload',
      'name' => ts('Download Document'),
      'isDefault' => TRUE,
      'icon' => 'fa-download',
    ];
    $buttons[] = [
      'type' => 'cancel',
      'name' => $this->isFormInViewMode() ? ts('Done') : ts('Cancel'),
    ];
    $this->addButtons($buttons);
  }

  /**
   * Process the form after the input has been submitted and validated.
   */
  public function postProcess() {
    $formValues = $this->controller->exportValues($this->getName());
    $params = [
      'html_message' => $formValues['html_message'],
      'contribution_page_ids' => $formValues['contribution_page_ids'],
    ];

    $isRedirect = CRM_GenerateQRLetters_Utils::createPdfs($this->_contactIds, $params);
    if ($isRedirect) {
      CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/a/#/status', ''));
    }
  }

}
