--TEST--
Cairo\version_string()
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/skipif.inc';
?>
--FILE--
<?php
$version = Cairo\version_string();
var_dump($version);

try {
    Cairo\version_string('foo');
} catch (ArgumentCountError $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
string(%d) "%d.%d.%d"
Cairo\version_string() expects exactly 0 arguments, 1 given