<?php

require_once('./db.php');
require_once( "./adodb/adodb-xmlschema03.inc.php");

$db->debug=1;

$xml_file_name = 'tables.xml';

$schemaFile  = $xml_file_name;

$schema = new adoSchema( $db );

$schema->SetUpgradeMethod('ALTER');
$schema->continueOnError = true;
$sql = $schema->ParseSchema($schemaFile);
$result = $schema->ExecuteSchema();

$sql = $schema->sqlArray;

echo "<pre>";
 print_r($sql);
echo "</pre>";

