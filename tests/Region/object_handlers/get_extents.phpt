--TEST--
Cairo\Region->getExtents() method
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

var_dump($region->getExtents());

$rectangle = new Cairo\Rectangle(1,1,100,100);
$rectangle2 = new Cairo\Rectangle(2,2,200,200);
$region2 = new Cairo\Region([$rectangle, $rectangle2]);
$extents = $region2->getExtents();
var_dump($extents);

/* Wrong number args */
try {
    $region->getExtents('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
object(Cairo\Rectangle)#2 (4) {
  ["x"]=>
  int(0)
  ["y"]=>
  int(0)
  ["width"]=>
  int(0)
  ["height"]=>
  int(0)
}
object(Cairo\Rectangle)#5 (4) {
  ["x"]=>
  int(1)
  ["y"]=>
  int(1)
  ["width"]=>
  int(201)
  ["height"]=>
  int(201)
}
Cairo\Region::getExtents() expects exactly 0 arguments, 1 given