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
$table = 'tbl_material';

// Table's primary key
$primaryKey = 'idtbl_material';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_material`', 'dt' => 'idtbl_material', 'field' => 'idtbl_material' ),
	array( 'db' => '`u`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`u`.`materialbarcode`', 'dt' => 'materialbarcode', 'field' => 'materialbarcode' ),
	array( 'db' => '`u`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice' ),
	array( 'db' => '`u`.`saleprice`', 'dt' => 'saleprice', 'field' => 'saleprice' ),
	array( 'db' => '`u`.`reorderlevel`', 'dt' => 'reorderlevel', 'field' => 'reorderlevel' ),
	array( 'db' => '`u`.`retail`', 'dt' => 'retail', 'field' => 'retail' ),
	array( 'db' => '`u`.`retaildiscount`', 'dt' => 'retaildiscount', 'field' => 'retaildiscount' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
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
require('ssp.customized.class.php');

$joinQuery = "FROM `tbl_material` AS `u` WHERE `status` IN (1,2)";



echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);

