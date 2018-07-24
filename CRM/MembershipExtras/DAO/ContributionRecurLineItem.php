<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2018
 *
 * Generated from /var/www/html/baswii/sites/default/files/civicrm/ext/uk.co.compucorp.membershipextras/xml/schema/CRM/MembershipExtras/ContributionRecurLineItem.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:8afd7b7ce826d195843d6f3921a3dde2)
 */

/**
 * Database access object for the ContributionRecurLineItem entity.
 */
class CRM_MembershipExtras_DAO_ContributionRecurLineItem extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'memberextras_contribrecur_lineitem';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  static $_log = TRUE;

  /**
   * Discount Item ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * ID of the recurring contribution.
   *
   * @var int unsigned
   */
  public $contribution_recur_id;

  /**
   * ID of the line item related to the recurring contribution.
   *
   * @var int unsigned
   */
  public $line_item_id;

  /**
   * Start date of the period for the membership/recurring contribution.
   *
   * @var datetime
   */
  public $start_date;

  /**
   * End date of the period for the membership/recurring contribution.
   *
   * @var datetime
   */
  public $end_date;

  /**
   * If the line-item should be auto-renewed or not.
   *
   * @var datetime
   */
  public $auto_renew;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'memberextras_contribrecur_lineitem';
    parent::__construct();
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static ::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contribution_recur_id', 'civicrm_contribution_recur', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'line_item_id', 'civicrm_line_item', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'Discount Item ID',
          'required' => TRUE,
          'table_name' => 'memberextras_contribrecur_lineitem',
          'entity' => 'ContributionRecurLineItem',
          'bao' => 'CRM_MembershipExtras_DAO_ContributionRecurLineItem',
          'localizable' => 0,
        ],
        'contribution_recur_id' => [
          'name' => 'contribution_recur_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'ID of the recurring contribution.',
          'required' => TRUE,
          'table_name' => 'memberextras_contribrecur_lineitem',
          'entity' => 'ContributionRecurLineItem',
          'bao' => 'CRM_MembershipExtras_DAO_ContributionRecurLineItem',
          'localizable' => 0,
        ],
        'line_item_id' => [
          'name' => 'line_item_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'ID of the line item related to the recurring contribution.',
          'required' => TRUE,
          'table_name' => 'memberextras_contribrecur_lineitem',
          'entity' => 'ContributionRecurLineItem',
          'bao' => 'CRM_MembershipExtras_DAO_ContributionRecurLineItem',
          'localizable' => 0,
        ],
        'start_date' => [
          'name' => 'start_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Start Date'),
          'description' => 'Start date of the period for the membership/recurring contribution.',
          'required' => FALSE,
          'table_name' => 'memberextras_contribrecur_lineitem',
          'entity' => 'ContributionRecurLineItem',
          'bao' => 'CRM_MembershipExtras_DAO_ContributionRecurLineItem',
          'localizable' => 0,
        ],
        'end_date' => [
          'name' => 'end_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('End Date'),
          'description' => 'End date of the period for the membership/recurring contribution.',
          'required' => FALSE,
          'table_name' => 'memberextras_contribrecur_lineitem',
          'entity' => 'ContributionRecurLineItem',
          'bao' => 'CRM_MembershipExtras_DAO_ContributionRecurLineItem',
          'localizable' => 0,
        ],
        'auto_renew' => [
          'name' => 'auto_renew',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Auto Renew'),
          'description' => 'If the line-item should be auto-renewed or not.',
          'required' => FALSE,
          'table_name' => 'memberextras_contribrecur_lineitem',
          'entity' => 'ContributionRecurLineItem',
          'bao' => 'CRM_MembershipExtras_DAO_ContributionRecurLineItem',
          'localizable' => 0,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'tras_contribrecur_lineitem', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'tras_contribrecur_lineitem', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [
      'index_contribrecurid_lineitemid' => [
        'name' => 'index_contribrecurid_lineitemid',
        'field' => [
          0 => 'contribution_recur_id',
          1 => 'line_item_id',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'memberextras_contribrecur_lineitem::1::contribution_recur_id::line_item_id',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
