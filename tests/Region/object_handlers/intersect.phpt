--TEST--
Cairo\Region->intersect() method
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

$rectangle = new Cairo\Rectangle(1,1,100,100);
$region2 = new Cairo\Region($rectangle);
var_dump( $region2->getNumRectangles() );
$region->intersect($region2);
var_dump( $region->getExtents() );

$rectangle2 = new Cairo\Rectangle(20,20,100,100);
$region3 = new Cairo\Region($rectangle2);
var_dump( $region3->getNumRectangles() );
var_dump( $region2->getExtents() );
$region2->intersect($region3);
var_dump( $region2->getExtents() );
var_dump( $region2->getNumRectangles() );

/* Wrong number args */
try {
    $region->intersect(1);
    trigger_error('equal intersect arg 1 of type Cairo\Region');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region->intersect($region2, 'foo');
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
  int(1)
  ["y"]=>
  int(1)
  ["width"]=>
  int(100)
  ["height"]=>
  int(100)
}
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(20)
  ["y"]=>
  int(20)
  ["width"]=>
  int(81)
  ["height"]=>
  int(81)
}
int(1)
Cairo\Region::intersect(): Argument #1 ($region) must be of type Cairo\Region, int given
Cairo\Region::intersect() expects exactly 1 argument, 2 given