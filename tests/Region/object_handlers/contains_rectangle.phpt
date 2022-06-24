--TEST--
Cairo\Region->containsRectangle() method
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
$rectangle1 = new Cairo\Rectangle(1,1,100,100);
$rectangle2 = new Cairo\Rectangle(20,20,20,20);
$rectangle3 = new Cairo\Rectangle(20,20,100,100);
$rectangle4 = new Cairo\Rectangle(110,110,20,20);

$region1 = new Cairo\Region();
var_dump($region1);

$region2 = new Cairo\Region($rectangle1);
var_dump($region2);

$contains = $region1->containsRectangle($rectangle1);
var_dump( $contains );
var_dump( $contains == \CAIRO\REGION\OVERLAP::OUT );

$contains = $region2->containsRectangle($rectangle2);
var_dump( $contains );
var_dump( $contains == \CAIRO\REGION\OVERLAP::IN );
$contains = $region2->containsRectangle($rectangle3);
var_dump( $contains );
var_dump( $contains == \CAIRO\REGION\OVERLAP::PART );
$contains = $region2->containsRectangle($rectangle4);
var_dump( $contains );
var_dump( $contains == \CAIRO\REGION\OVERLAP::OUT );


/* Wrong number args */
try {
    $region1->containsRectangle();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region1->containsRectangle(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $region1->containsRectangle($rectangle1, 'foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
object(Cairo\Region)#%d (0) {
}
object(Cairo\Region\Overlap)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["IN"]=>
    int(0)
    ["OUT"]=>
    int(1)
    ["PART"]=>
    int(2)
  }
  ["__value"]=>
  int(1)
}
bool(true)
object(Cairo\Region\Overlap)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["IN"]=>
    int(0)
    ["OUT"]=>
    int(1)
    ["PART"]=>
    int(2)
  }
  ["__value"]=>
  int(0)
}
bool(true)
object(Cairo\Region\Overlap)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["IN"]=>
    int(0)
    ["OUT"]=>
    int(1)
    ["PART"]=>
    int(2)
  }
  ["__value"]=>
  int(2)
}
bool(true)
object(Cairo\Region\Overlap)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["IN"]=>
    int(0)
    ["OUT"]=>
    int(1)
    ["PART"]=>
    int(2)
  }
  ["__value"]=>
  int(1)
}
bool(true)
Cairo\Region::containsRectangle() expects exactly 1 argument, 0 given
Cairo\Region::containsRectangle(): Argument #1 ($rectangle) must be of type Cairo\Rectangle, int given
Cairo\Region::containsRectangle() expects exactly 1 argument, 2 given