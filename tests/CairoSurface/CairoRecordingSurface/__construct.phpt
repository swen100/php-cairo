--TEST--
new Cairo\Surface\Recording [__construct() method ]
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('RECORDING', Cairo::availableSurfaces())) {
    die('skip - RECORDING surface not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Recording(\Cairo\Surface\Content::COLOR_ALPHA);
var_dump($surface);

$extents = ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 400];
$surface2 = new Cairo\Surface\Recording(\Cairo\Surface\Content::COLOR_ALPHA, $extents);
var_dump($surface2);

/* Wrong number args - 1 */
try {
    new Cairo\Surface\Recording();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Surface\Recording(NULL, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Surface\Recording([], 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Surface\Recording(0, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Recording)#%d (0) {
}
object(Cairo\Surface\Recording)#%d (0) {
}
Cairo\Surface\Recording::__construct() expects at least 1 argument, 0 given
Cairo\Surface\Recording::__construct() expects at most 2 arguments, 4 given
Cairo\Surface\Recording::__construct(): Argument #1 ($content) must be of type int, array given
Cairo\Surface\Recording::__construct(): Argument #2 ($extents) must be of type array, int given
