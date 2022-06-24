--TEST--
Cairo\Surface->setFallbackResolution() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$surface->setFallbackResolution(10, 10);

/* Wrong number args - 1 */
try {
    $surface->setFallbackResolution();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $surface->setFallbackResolution(10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    $surface->setFallbackResolution(10, 10, 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $surface->setFallbackResolution(array(), 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $surface->setFallbackResolution(10, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface::setFallbackResolution() expects exactly 2 arguments, 0 given
Cairo\Surface::setFallbackResolution() expects exactly 2 arguments, 1 given
Cairo\Surface::setFallbackResolution() expects exactly 2 arguments, 3 given
Cairo\Surface::setFallbackResolution(): Argument #1 ($x) must be of type float, array given
Cairo\Surface::setFallbackResolution(): Argument #2 ($y) must be of type float, array given