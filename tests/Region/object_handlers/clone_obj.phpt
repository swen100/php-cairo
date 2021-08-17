--TEST--
Cairo\Region clone handler
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
use Cairo\Region;

$region = new Region();
$copy = clone $region;

var_dump($region);
var_dump($copy);

$rectangle = new Cairo\Rectangle(1,1,100,100);
$region2 = new Cairo\Region($rectangle);
var_dump( $region->containsPoint(10,10) );
var_dump( $region2->containsPoint(10,10) );

$region3 = clone $region2;
var_dump( $region3->containsPoint(10,10) );

?>
--EXPECT--
object(Cairo\Region)#1 (0) {
}
object(Cairo\Region)#2 (0) {
}
bool(false)
bool(true)
bool(true)