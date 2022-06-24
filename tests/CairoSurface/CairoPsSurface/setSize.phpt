--TEST--
Cairo\Surface\Ps->setSize() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Ps(NULL, 50, 50);
var_dump($surface);

$surface->setSize(10, 10);

/* Wrong number args 1*/
try {
    $surface->setSize();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->setSize(10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    $surface->setSize(10, 10, 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $surface->setSize(array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $surface->setSize(1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Ps)#%d (0) {
}
Cairo\Surface\Ps::setSize() expects exactly 2 arguments, 0 given
Cairo\Surface\Ps::setSize() expects exactly 2 arguments, 1 given
Cairo\Surface\Ps::setSize() expects exactly 2 arguments, 3 given
Cairo\Surface\Ps::setSize(): Argument #1 ($width) must be of type float, array given
Cairo\Surface\Ps::setSize(): Argument #2 ($height) must be of type float, array given