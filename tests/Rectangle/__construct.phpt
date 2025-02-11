--TEST--
Cairo\Rectangle->__construct() 
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../skipif.inc';
?>
--FILE--
<?php
use Cairo\Rectangle;

$rectangle = new Rectangle();
var_dump($rectangle);

/* Wrong number args - can only have too many, any number between 0 and 4 is fine */
try {
    new Rectangle(1, 1, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Rectangle(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Rectangle(1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Rectangle(1, 1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 4 */
try {
    new Rectangle(1, 1, 1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
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
Cairo\Rectangle::__construct() expects at most 4 arguments, 5 given
Cairo\Rectangle::__construct(): Argument #1 ($x) must be of type int, array given
Cairo\Rectangle::__construct(): Argument #2 ($y) must be of type int, array given
Cairo\Rectangle::__construct(): Argument #3 ($width) must be of type int, array given
Cairo\Rectangle::__construct(): Argument #4 ($height) must be of type int, array given
