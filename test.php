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

$settings = new protected_settings;
$results = $settings->fetch();

var_dump($results);