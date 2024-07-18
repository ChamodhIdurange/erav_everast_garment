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
$table = 'tbl_product';

// Table's primary key
$primaryKey = 'idtbl_product';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db' => '`s`.`product_code`', 'dt' => 'product_code', 'field' => 'product_code'),
	array('db' => '`s`.`product_name`', 'dt' => 'product_name', 'field' => 'product_name'),
	array('db' => '`s`.`saleprice`', 'dt' => 'saleprice', 'field' => 'saleprice'),
	array('db' => '`s`.`retail`', 'dt' => 'retail', 'field' => 'retail'),
	array('db' => '`s`.`qty`',   'dt' => 'qty', 'field' => 'qty'),
	array('db' => '`s`.`last_month`',   'dt' => 'last_month', 'field' => 'last_month'),
	array('db' => '`s`.`current_month`',   'dt' => 'current_month', 'field' => 'current_month')
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

$joinQuery = "FROM (
    SELECT
        `u`.`product_code`,
        `u`.`product_name`,
        `u`.`saleprice`,
        `u`.`retail`,
        `ua`.`qty`,
        CASE 
            WHEN MONTH(`ua`.`update`) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) THEN `ua`.`qty` 
            ELSE 0 
        END AS `last_month`,
        CASE 
            WHEN MONTH(`ua`.`update`) = MONTH(CURRENT_DATE()) THEN `ua`.`qty` 
            ELSE 0 
        END AS `current_month`
    FROM
        `tbl_product` AS `u`
    LEFT JOIN
        `tbl_stock` AS `ua` ON (`ua`.`tbl_product_idtbl_product` = `u`.`idtbl_product`)
) AS `s`";


// $extraWhere = "WHERE `u`.`status` ='1'";

echo json_encode(
	SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);
