<?php
// URL rewriting test
$get = $_GET['p'];

echo '$_GET[p] = ';
print_r($get);
echo '<br>';

// Build parameters test
$parameters = array_filter(explode('/', $get));

echo '$parameters = ';
print_r($parameters);
echo '<br>';
