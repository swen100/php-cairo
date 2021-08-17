--TEST--
Cairo\Region->subtractRectangle() method
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
$rectangle1 = new Cairo\Rectangle(10,10,40,40);
$region = new Cairo\Region($rectangle1);
var_dump( $region );

$rectangle2 = new Cairo\Rectangle(25,10,40,40);
var_dump( $region->subtractRectangle($rectangle2) == \CAIRO\STATUS::SUCCESS );
var_dump( $region->getNumRectangles() );
var_dump( $region->getExtents() );

/* Wrong number args */
try {
    $region->subtractRectangle(1);
    trigger_error('Cairo\Region::unionRectangle(): Argument #1 ($region) must be of type Cairo\Region');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->subtractRectangle($rectangle1, 'foo');
    trigger_error('Cairo\Region::unionRectangle() expects exactly 1 argument, 2 given');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
bool(true)
int(1)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(10)
  ["y"]=>
  int(10)
  ["width"]=>
  int(15)
  ["height"]=>
  int(40)
}
Cairo\Region::subtractRectangle(): Argument #1 ($rectangle) must be of type Cairo\Rectangle, int given
Cairo\Region::subtractRectangle() expects exactly 1 argument, 2 given