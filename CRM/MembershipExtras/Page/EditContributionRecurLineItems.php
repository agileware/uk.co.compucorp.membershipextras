<?php
use CRM_MembershipExtras_ExtensionUtil as E;

class CRM_MembershipExtras_Page_EditContributionRecurLineItems extends CRM_Core_Page {

  /**
   * ID of the recurring contribution being viewed.
   *
   * @var int
   */
  private $contribRecur;

  /**
   * List of available financial types in the system.
   *
   * @var array
   */
  private $financialTypes;

  /**
   * @inheritdoc
   */
  public function __construct($title = NULL, $mode = NULL) {
    parent::__construct($title, $mode);

    $this->contribRecur = $this->getRecurringContribution();
    $this->financialTypes = $this->getFinancialTypes();
  }

  /**
   * Loads recurring contribution identified by ID set in request.
   *
   * @return array
   */
  private function getRecurringContribution() {
    $recurringContributionID = CRM_Utils_Request::retrieveValue('crid', 'Positive', 0);

    return civicrm_api3('ContributionRecur', 'getsingle', [
      'id' => $recurringContributionID,
    ]);
  }

  /**
   * Loads available financial types.
   *
   * @return array
   */
  private function getFinancialTypes() {
    $financialTypes = array();

    $result = civicrm_api3('FinancialType', 'get', [
      'options' => ['limit' => 0],
    ]);

    if ($result['count'] > 0) {
      foreach ($result['values'] as $financialType) {
        $financialTypes[] = array_merge($financialType, array(
          'tax_rate' => $this->getTaxRateForFinancialType($financialType['id']),
        ));
      }
    }

    return $financialTypes;
  }

  /**
   * @inheritdoc
   */
  public function run() {
    CRM_Utils_System::setTitle(E::ts('Manage Installments'));

    $this->assign('recurringContributionID', $this->contribRecur['id']);

    $this->assign('periodStartDate', CRM_Utils_Array::value('start_date', $this->contribRecur));
    $this->assign('periodEndDate', CRM_Utils_Array::value('end_date', $this->contribRecur));
    $this->assign('lineItems', $this->getLineItems(['end_date' => ['IS NULL' => 1]]));

    $this->assign('autoRenewEnabled', $this->isAutoRenewEnabled());
    $this->assign('nextPeriodStartDate', $this->calculateNextPeriodStartDate());
    $this->assign('financialTypes', $this->financialTypes);
    $this->assign('currencySymbol', $this->getCurrencySymbol());
    $this->assign('nextPeriodLineItems', $this->getLineItems(['auto_renew' => TRUE]));

    parent::run();
  }

  /**
   * @return string
   */
  private function getCurrencySymbol() {
    $config = CRM_Core_Config::singleton();
    return CRM_Core_DAO::getFieldValue('CRM_Financial_DAO_Currency', $config->defaultCurrency, 'symbol', 'name');
  }

  /**
   * @return boolean
   */
  private function isAutoRenewEnabled() {
    $isAutoRenew = CRM_Utils_String::strtobool(CRM_Utils_Array::value('auto_renew', $this->contribRecur));
  
    if ($isAutoRenew && count($this->getMemberships())) {
      return TRUE;
    }
  
    return FALSE;
  }

  /**
   * Calculates next period's start date
   * 
   * @return string
   */
  private function calculateNextPeriodStartDate() {
    $nextPeriodStartDate = new DateTime(CRM_Utils_Array::value('start_date', $this->contribRecur));
    $intervalLength = CRM_Utils_Array::value('frequency_interval', $this->contribRecur) * CRM_Utils_Array::value('installments', $this->contribRecur);

    switch (CRM_Utils_Array::value('frequency_unit', $this->contribRecur)) {
      case 'month':
        $interval = 'P' . $intervalLength . 'M';
        break;
      case 'day':
        $interval = 'P' . $intervalLength .'D';
        break;
      case 'year':
        $interval = 'P' . $intervalLength .'Y';
        break;
    }

    $nextPeriodStartDate->add(new DateInterval($interval));

    return $nextPeriodStartDate->format('Y-m-d');
  }

  /**
   * Obtains list of line items for the current recurring contribution.
   * 
   * @param array $conditions
   *
   * @return array
   */
  private function getLineItems($conditions = []) {
    $lineItems = array();

    $options = array_merge($conditions, [
      'sequential' => 1,
      'contribution_recur_id' => $this->contribRecur['id'],
      'api.LineItem.getsingle' => [
        'id' => '$value.line_item_id',
        'entity_table' => ['IS NOT NULL' => 1],
        'entity_id' => ['IS NOT NULL' => 1]
      ],
    ]);

    $result = civicrm_api3('ContributionRecurLineItem', 'get', $options);

    if ($result['count'] > 0) {
      foreach ($result['values'] as $lineItemData) {
        $lineDetails = $lineItemData['api.LineItem.getsingle'];
        $lineDetails['tax_rate'] = $this->getTaxRateForFinancialType($lineDetails['financial_type_id']);
        $lineDetails['financial_type'] = $this->getFinancialTypeName($lineDetails['financial_type_id']);

        unset($lineDetails['id']);
        unset($lineItemData['api.LineItem.getsingle']);
        $lineItems[] = array_merge($lineItemData, $lineDetails);
      }
    }

    return $lineItems;
  }

  /**
   * Gets the memberships associated with the current recurring contribution
   * 
   * @return array
   */
  private function getMemberships() {
    return civicrm_api3('Membership', 'get', [
      'sequential' => 1,
      'contribution_recur_id' => $this->contribRecur['id'],
    ])['values'];
  }

  /**
   * Returns tax rate used for given financial type ID.
   *
   * @param $financialTypeID
   *
   * @return double
   */
  private function getTaxRateForFinancialType($financialTypeID) {
    $taxRates = CRM_Core_PseudoConstant::getTaxRates();
    $rate = round(CRM_Utils_Array::value($financialTypeID, $taxRates, 0), 2);

    return $rate;
  }

  /**
   * Returns the financial type's name identified by the given ID.
   *
   * @param int $id
   *
   * @return string
   */
  private function getFinancialTypeName($id) {
    foreach ($this->financialTypes as $financialType) {
      if ($financialType['id'] === $id) {
        return $financialType['name'];
      }
    }

    return '';
  }

}