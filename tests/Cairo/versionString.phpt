--TEST--
Cairo::versionString() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$version = \Cairo\version_string();
var_dump($version);

$version = \Cairo::versionString();
var_dump($version);

/* Wrong number args */
try {
    \Cairo\version_string('foo');
    //trigger_error('Cairo::versionString should take no arguments');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    \Cairo::versionString('foo');
    //trigger_error('Cairo::versionString should take no arguments');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
string(%d) %s
string(%d) %s
Cairo\version_string() expects exactly 0 arguments, 1 given
Cairo::versionString() expects exactly 0 arguments, 1 given