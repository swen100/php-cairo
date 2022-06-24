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
$rectangle1 = new Cairo\Rectangle(0,0,100,100);
$rectangle2 = new Cairo\Rectangle(100,100,100,100);
$rectangle3 = new Cairo\Rectangle(200,200,100,100);
$rectangle4 = new Cairo\Rectangle(300,200,100,100);

$region1 = new Cairo\Region($rectangle1);
var_dump( $region1 );
var_dump( $region1->getNumRectangles() );
var_dump( $region1->getRectangle(1) );

$region2 = new Cairo\Region([$rectangle1, $rectangle2, $rectangle3, $rectangle4]);
var_dump( $region2 );
var_dump( $region2->getNumRectangles() );
var_dump( $region2->getRectangle(2) );
var_dump( $region2->getRectangle(3) );
var_dump( $region1->getRectangle(99) );

/* Wrong number args */
try {
    $region1->getRectangle('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
int(1)
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(0)
  ["y"]=>
  int(0)
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
  int(100)
  ["y"]=>
  int(100)
  ["width"]=>
  int(100)
  ["height"]=>
  int(100)
}
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(200)
  ["y"]=>
  int(200)
  ["width"]=>
  int(200)
  ["height"]=>
  int(100)
}
bool(false)
Cairo\Region::getRectangle(): Argument #1 ($number) must be of type int, string given