<?php

echo "Open basedir: ";
var_dump(ini_get('open_basedir'));

echo "<br>";

echo "Disabled functions: ";
var_dump(ini_get('disable_functions'));

echo "<br>";

echo "PHP SAPI: ";
var_dump(php_sapi_name());

?>
