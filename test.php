<?php
/**
 * Name:        Test.php
 * Description: A place for temporary tests of code
 * Date:        11/27/13
 * Programmer:  Liam Kelly
 */

//Includes
require_once('./path.php');
include_once(ABSPATH.'includes/models/settings.php');
include_once(ABSPATH.'includes/models/protected_settings.php');
include_once(ABSPATH.'includes/models/pdo.php');
include_once(ABSPATH.'includes/models/tables/media.table.php');

$test = new db;
echo $test->get_errors();


$media = new media;

$media->media_id = '3';
$media->filename = 'testing';
$media->server_adderess = 'http://localhost/';
$media->resolution = '3280p';

echo '<pre>';
var_dump($media);
echo ' </pre>';
$media->insert();


