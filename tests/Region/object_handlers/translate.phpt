--TEST--
Cairo\Region->translate() method
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
$region->translate(1, 1);
var_dump( $region->containsPoint(1, 1) );

$rectangle = new Cairo\Rectangle(1,1,100,100);
$region2 = new Cairo\Region($rectangle);
var_dump( $region2->containsPoint(5, 5) );
$region2->translate(10.5, 10.5);
var_dump( $region2->containsPoint(5, 5) );
var_dump( $region2->containsPoint(50, 50) );


/* Wrong number args */
try {
    $region->translate();
    trigger_error('translate requires two args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->translate('foo');
    trigger_error('translate requires two args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->translate(1,2,3);
    trigger_error('translate requires two args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
bool(false)
bool(true)
bool(false)
bool(true)
Cairo\Region::translate() expects exactly 2 arguments, 0 given
Cairo\Region::translate() expects exactly 2 arguments, 1 given
Cairo\Region::translate() expects exactly 2 arguments, 3 given