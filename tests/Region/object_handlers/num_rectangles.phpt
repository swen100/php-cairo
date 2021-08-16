--TEST--
Cairo\Region->getStatus() method
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
var_dump( $region->getNumRectangles() );

$rectangle = new Cairo\Rectangle(1,1,100,100);
$region2 = new Cairo\Region($rectangle);
var_dump( $region2->getNumRectangles() );

$rectangle2 = new Cairo\Rectangle(2,2,200,200);
$region3 = new Cairo\Region([$rectangle, $rectangle2]);
var_dump( $region3->getNumRectangles() );

$rectangle3 = new Cairo\Rectangle(3,3,300,300);
$region4 = new Cairo\Region([$rectangle, $rectangle2, $rectangle3]);
var_dump( $region4->getNumRectangles() );

/* Wrong number args */
try {
    $region->getNumRectangles('foo');
    trigger_error('getNumRectangles requires only one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
int(0)
int(1)
int(2)
int(3)
Cairo\Region::getNumRectangles() expects exactly 0 arguments, 1 given