--TEST--
Cairo\Region->subtract() method
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
var_dump( $region->getExtents() );

$rectangle = new Cairo\Rectangle(10,10,100,100);
$region2 = new Cairo\Region($rectangle);
var_dump( $region2->getNumRectangles() );
var_dump( $region->subtract($region2) == \CAIRO\STATUS::SUCCESS );
var_dump( $region->getExtents() );

$rectangle2 = new Cairo\Rectangle(80,10,40,110);
$region3 = new Cairo\Region($rectangle2);
var_dump( $region3->getNumRectangles() );
var_dump( $region2->getExtents() );
var_dump( $region2->subtract($region3) == \CAIRO\STATUS::SUCCESS );
var_dump( $region2->getExtents() );
var_dump( $region2->getNumRectangles() );

/* Wrong number args */
try {
    $region->subtract(1);
    trigger_error('equal intersect arg 1 of type Cairo\Region');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->subtract($region2, 'foo');
    trigger_error('equal intersect arg 1 of type Cairo\Region');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
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
int(1)
bool(true)
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
int(1)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(10)
  ["y"]=>
  int(10)
  ["width"]=>
  int(100)
  ["height"]=>
  int(100)
}
bool(true)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(10)
  ["y"]=>
  int(10)
  ["width"]=>
  int(70)
  ["height"]=>
  int(100)
}
int(1)
Cairo\Region::subtract(): Argument #1 ($region) must be of type Cairo\Region, int given
Cairo\Region::subtract() expects exactly 1 argument, 2 given