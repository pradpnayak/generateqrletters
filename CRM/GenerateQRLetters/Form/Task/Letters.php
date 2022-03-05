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
  }

  /**
   * Build the form object.
   */
  public function buildQuickForm() {
    $this->addDefaultButtons(ts('Generate Invoice'));
  }

  /**
   * Process the form after the input has been submitted and validated.
   */
  public function postProcess() {
  }

}
