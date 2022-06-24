--TEST--
Cairo\Region->isEmpty() method
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
$region = new Cairo\Region();
var_dump($region);

$status = $region->isEmpty();
var_dump($status);

var_dump($status == TRUE);

/* Wrong number args */
try {
    $region->isEmpty('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
bool(true)
bool(true)
Cairo\Region::isEmpty() expects exactly 0 arguments, 1 given