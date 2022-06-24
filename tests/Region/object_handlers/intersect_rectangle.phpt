--TEST--
Cairo\Region->intersectRectangle() method
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
var_dump( $region->intersectRectangle($rectangle2) == \CAIRO\STATUS::SUCCESS );
var_dump( $region->getNumRectangles() );
var_dump( $region->getExtents() );

/* Wrong number args */
try {
    $region->intersectRectangle(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->intersectRectangle($rectangle1, 'foo');
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
  int(25)
  ["y"]=>
  int(10)
  ["width"]=>
  int(25)
  ["height"]=>
  int(40)
}
Cairo\Region::intersectRectangle(): Argument #1 ($rectangle) must be of type Cairo\Rectangle, int given
Cairo\Region::intersectRectangle() expects exactly 1 argument, 2 given