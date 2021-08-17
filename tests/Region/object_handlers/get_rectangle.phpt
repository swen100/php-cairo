--TEST--
Cairo\Region->getRectangle() method
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
$rectangle1 = new Cairo\Rectangle(1,1,100,100);
$rectangle2 = new Cairo\Rectangle(2,2,200,200);
$rectangle3 = new Cairo\Rectangle(3,3,300,300);

$region1 = new Cairo\Region($rectangle1);
var_dump( $region1 );
var_dump( $region1->getNumRectangles() );
var_dump( $region1->getRectangle(1) );

$region2 = new Cairo\Region([$rectangle1, $rectangle2, $rectangle3]);
var_dump( $region2 );
var_dump( $region2->getNumRectangles() );
var_dump( $region2->getRectangle(2) );
var_dump( $region1->getRectangle(99) );

/* Wrong number args */
try {
    $region1->getRectangle('foo');
    trigger_error('getRectangle requires only one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
int(1)
object(Cairo\Rectangle)#5 (4) {
  ["x"]=>
  int(1)
  ["y"]=>
  int(1)
  ["width"]=>
  int(100)
  ["height"]=>
  int(100)
}
object(Cairo\Region)#%d (0) {
}
int(3)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(2)
  ["y"]=>
  int(2)
  ["width"]=>
  int(200)
  ["height"]=>
  int(200)
}
bool(false)
Cairo\Region::getRectangle(): Argument #1 ($number) must be of type int, string given