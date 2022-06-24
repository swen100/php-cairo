--TEST--
Cairo\Region->equal() method
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
var_dump( $region->equal(null) );

$region2 = new Cairo\Region();
var_dump( $region->equal($region2) );

$rectangle = new Cairo\Rectangle(1,1,100,100);
$region3 = new Cairo\Region($rectangle);
var_dump( $region->equal($region3) );

$region4 = new Cairo\Region($rectangle);
var_dump( $region3->equal($region4) );

$rectangle2 = new Cairo\Rectangle(2,2,200,200);
$region5 = new Cairo\Region([$rectangle, $rectangle2]);
var_dump( $region4->equal($region5) );

/* Wrong number args */
try {
    $region->equal(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->equal($region2, 'foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
bool(true)
bool(true)
bool(false)
bool(true)
bool(false)
Cairo\Region::equal(): Argument #1 ($region) must be of type ?Cairo\Region, int given
Cairo\Region::equal() expects exactly 1 argument, 2 given