--TEST--
Cairo\version()
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/skipif.inc';
?>
--FILE--
<?php
$version = Cairo\version();
var_dump($version);

try {
    Cairo\version('foo');
} catch (ArgumentCountError $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
int(%d)
Cairo\version() expects exactly 0 arguments, 1 given