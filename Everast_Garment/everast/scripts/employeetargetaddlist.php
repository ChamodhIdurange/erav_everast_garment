<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'tbl_employee_target';

// Table's primary key
$primaryKey = 'idtbl_employee_target';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_employee_target`', 'dt' => 'idtbl_employee_target', 'field' => 'idtbl_employee_target' ),
	array( 'db' => '`uc`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`ud`.`product_name`', 'dt' => 'product_name', 'field' => 'product_name' ),
	array( 'db' => '`u`.`month`', 'dt' => 'month', 'field' => 'month' ),
	array( 'db' => '`u`.`targetqty`', 'dt' => 'targetqty', 'field' => 'targetqty' ),
	array( 'db' => '`u`.`targetvalue`', 'dt' => 'targetvalue', 'field' => 'targetvalue' ),
	array( 'db' => '`u`.`targetqtycomplete`',   'dt' => 'targetqtycomplete', 'field' => 'targetqtycomplete' ),
	array( 'db' => '`u`.`targetvaluecomplete`',   'dt' => 'targetvaluecomplete', 'field' => 'targetvaluecomplete' ),
	array( 'db' => '`u`.`status`',   'dt' => 'status', 'field' => 'status' )
);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `tbl_employee_target` AS `u` LEFT JOIN `tbl_employee` AS `uc` ON (`uc`.`idtbl_employee` = `u`.`tbl_employee_idtbl_employee`) LEFT JOIN `tbl_product` AS `ud` ON (`ud`.`idtbl_product` = `u`.`tbl_product_idtbl_product`)";

$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);