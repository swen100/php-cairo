--TEST--
Cairo\Surface\Ps->restrictToLevel() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
if(!method_exists('Cairo\Surface\Ps', 'restrictToLevel')) die('skip - Cairo\Surface\Ps->restrictToLevel not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Ps(NULL, 50, 50);
var_dump($surface);

$surface->restrictToLevel(Cairo\Surface\Ps\Level::LEVEL_2);

/* Wrong number args */
try {
    $surface->restrictToLevel();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->restrictToLevel(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->restrictToLevel(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Ps)#%d (0) {
}
Cairo\Surface\Ps::restrictToLevel() expects exactly 1 argument, 0 given
Cairo\Surface\Ps::restrictToLevel() expects exactly 1 argument, 2 given
Cairo\Surface\Ps::restrictToLevel(): Argument #1 ($level) must be of type int, array given