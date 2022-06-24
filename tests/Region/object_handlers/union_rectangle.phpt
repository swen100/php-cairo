--TEST--
Cairo\Region->unionRectangle() method
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
$region = new Cairo\Region();
var_dump( $region );
var_dump( $region->getNumRectangles() );
var_dump( $region->getExtents() );

$rectangle1 = new Cairo\Rectangle(10,10,10,10);
var_dump( $region->unionRectangle($rectangle1) == \CAIRO\STATUS::SUCCESS );
var_dump( $region->getNumRectangles() );
var_dump( $region->getExtents() );

$rectangle2 = new Cairo\Rectangle(10,10,20,20);
var_dump( $region->unionRectangle($rectangle2) == \CAIRO\STATUS::SUCCESS );
var_dump( $region->getNumRectangles() );
var_dump( $region->getExtents() );

/* Wrong number args */
try {
    $region->unionRectangle(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->unionRectangle($rectangle1, 'foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
int(0)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(0)
  ["y"]=>
  int(0)
  ["width"]=>
  int(0)
  ["height"]=>
  int(0)
}
bool(true)
int(1)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(10)
  ["y"]=>
  int(10)
  ["width"]=>
  int(10)
  ["height"]=>
  int(10)
}
bool(true)
int(1)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(10)
  ["y"]=>
  int(10)
  ["width"]=>
  int(20)
  ["height"]=>
  int(20)
}
Cairo\Region::unionRectangle(): Argument #1 ($rectangle) must be of type Cairo\Rectangle, int given
Cairo\Region::unionRectangle() expects exactly 1 argument, 2 given