<?php
$helperDir = dirname(__FILE__) . "/helpers";

if (!is_dir($helperDir))
    \wp_die("Helpers dir does not exist! '{$helperDir}'");

$helperFiles = glob($helperDir . "/*.php");

foreach ($helperFiles as $helperFile) {
    require_once $helperFile;
}
