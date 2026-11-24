<?php

$path = '/home/mahnoor/public_html/gymnasietarbete/uploads/';

echo "PHP user: ";
echo posix_geteuid();

echo "<br>";

echo "Writable: ";
var_dump(is_writable($path));

echo "<br>";

$result = file_put_contents($path . 'test_from_apache.txt', 'Hello');

var_dump($result);

echo "<br>";

echo error_get_last() ? error_get_last()['message'] : 'No error';

?>
