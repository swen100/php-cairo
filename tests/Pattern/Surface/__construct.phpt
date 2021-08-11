--TEST--
Cairo\Pattern\Surface->__construct()
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
use Cairo\Surface\Image;
use Cairo\Pattern\Surface;

$surface = new Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$pattern = new Surface($surface);
var_dump($pattern);

/* Total number of args needed = 0 */
try {
    var_dump(new Surface());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    new Surface($surface, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be instanceof Cairo\Surface */
try {
    new Surface(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
Cairo\Pattern\Surface::__construct() expects at most 1 argument, 2 given
Cairo\Pattern\Surface::__construct(): Argument #1 ($surface) must be of type Cairo\Surface, int given