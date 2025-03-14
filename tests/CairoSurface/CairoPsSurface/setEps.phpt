--TEST--
Cairo\Surface\Ps->setEps() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
if(!method_exists('Cairo\Surface\Ps', 'setEps')) die('skip - Cairo\Surface\Ps->setEps not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Ps(NULL, 50, 50);
var_dump($surface);

$surface->setEps(true);

/* Wrong number args */
try {
    $surface->setEps();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->setEps(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->setEps(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Ps)#%d (0) {
}
Cairo\Surface\Ps::setEps() expects exactly 1 argument, 0 given
Cairo\Surface\Ps::setEps() expects exactly 1 argument, 2 given
Cairo\Surface\Ps::setEps(): Argument #1 ($level) must be of type bool, array given