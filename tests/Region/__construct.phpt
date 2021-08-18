--TEST--
Cairo\Region->__construct() 
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../skipif.inc';
?>
--FILE--
<?php
$region = new Cairo\Region();
var_dump($region);

$rectangle = new Cairo\Rectangle(0, 0, 100, 100);
$region2 = new Cairo\Region($rectangle);
var_dump($region2);

/* Wrong number args */
try {
    new Cairo\Region([]);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg-types */
try {
    new Cairo\Region([1]);
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Region)#%d (0) {
}
object(Cairo\Region)#%d (0) {
}
Cairo\Region::__construct() expects parameter 1 to be empty or an object|array of Cairo\Rectangle.
