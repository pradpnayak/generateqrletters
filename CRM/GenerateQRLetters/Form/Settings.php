<?php

class CRM_GenerateQRLetters_Form_Settings extends CRM_Admin_Form_Setting {

  const PREFERENCE = 'GenerateQRLetters Preferences';

  protected $_settings = [
    'generateqrletters' => CRM_GenerateQRLetters_Form_Settings::PREFERENCE,
  ];

  /**
   * Set variables up before form is built.
   */
  public function preProcess() {
    $this->setPageTitle(ts('QR Letters Settings'));
  }

  /**
   * Function to actually build the form
   *
   * @access public
   */
  public function buildQuickForm() {
    $this->assign('elementNames', [
      'no_contribution_page_ids',
      'batch_limit_per_pdf',
      'email_to',
      'time_to_delete',
    ]);

    $this->add(
      'number', 'generateqrletters[no_contribution_page_ids]',
      ts('# Contribution Pages'),
      ['id' => 'no_contribution_page_ids', 'step' => '1'],
      TRUE
    );

    $this->add(
      'number', 'generateqrletters[batch_limit_per_pdf]',
      ts('Batch limit per pdf file'),
      ['id' => 'batch_limit_per_pdf', 'step' => '1'],
      TRUE
    );

    $this->add(
      'number', 'generateqrletters[time_to_delete]',
      ts('Delete files after minutes'),
      ['id' => 'time_to_delete', 'step' => '1'],
      TRUE
    );

    $this->add(
      'text', 'generateqrletters[email_to]',
      ts('Email to?'), ['id' => 'email_to']
    );

    // Add submit/save button
    $this->addButtons([
      [
        'type' => 'submit',
        'name' => ts('Save'),
      ],
      [
        'type' => 'cancel',
        'name' => ts('Cancel'),
      ],
    ]);
  }

  /**
   * Default values
   *
   * @access public
   * @return void
   */
  public function setDefaultValues() {
    $defaults = parent::setDefaultValues();
    foreach ([
      'time_to_delete' => 720,
      'batch_limit_per_pdf' => 500,
      'no_contribution_page_ids' => 5,
    ] as $k => $v) {
      if (!isset($defaults['generateqrletters'][$k])) {
        $defaults['generateqrletters'][$k] = $v;
      }
    }
    return $defaults;
  }

  /**
   * Function to process the form
   *
   * @access public
   */
  public function postProcess() {
    $params = $this->controller->exportValues($this->_name);
    parent::commonProcess($params);
    CRM_Core_Session::setStatus(ts('Settings saved successfully.'), ts('Changes Saved'), "success");
    CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/admin', 'reset=1'));
  }

}
