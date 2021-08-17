--TEST--
Cairo\Region->containsPoint() method
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

var_dump( $region->containsPoint(1, 1) );

$rectangle = new Cairo\Rectangle(1,1,100,100);
$region2 = new Cairo\Region($rectangle);
var_dump( $region2->containsPoint(10, 10) );

/* Wrong number args */
try {
    $region->containsPoint();
    trigger_error('containsPoint requires two args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->containsPoint('foo');
    trigger_error('containsPoint requires two args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
bool(false)
bool(true)
Cairo\Region::containsPoint() expects exactly 2 arguments, 0 given
Cairo\Region::containsPoint() expects exactly 2 arguments, 1 given