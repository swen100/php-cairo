--TEST--
new Cairo\Surface\Svg [__construct() method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('SVG', Cairo::availableSurfaces())) die('skip - SVG surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Svg(NULL, 50, 50);
var_dump($surface);

$surface = new Cairo\Surface\Svg(dirname(__FILE__) . '/nametest.svg', 50, 50);
var_dump($surface);

$fp = fopen(dirname(__FILE__) . '/streamtest.svg', 'wb');
$surface = new Cairo\Surface\Svg($fp, 50, 50);
var_dump($surface);

/* Wrong number args - 1 */
try {
    new Cairo\Surface\Svg();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    new Cairo\Surface\Svg(NULL);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    new Cairo\Surface\Svg(NULL, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Surface\Svg(NULL, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Surface\Svg(array(), 1, 1);
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Surface\Svg(NULL, array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Cairo\Surface\Svg(NULL, 1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/nametest.svg');
unlink(dirname(__FILE__) . '/streamtest.svg');
?>
--EXPECTF--
object(Cairo\Surface\Svg)#%d (0) {
}
object(Cairo\Surface\Svg)#%d (0) {
}
object(Cairo\Surface\Svg)#%d (0) {
}
Cairo\Surface\Svg::__construct() expects exactly 3 arguments, 0 given
Cairo\Surface\Svg::__construct() expects exactly 3 arguments, 1 given
Cairo\Surface\Svg::__construct() expects exactly 3 arguments, 2 given
Cairo\Surface\Svg::__construct() expects exactly 3 arguments, 4 given
Cairo\Surface\Svg::__construct() expects parameter 1 to be null, a string, or a stream resource
Cairo\Surface\Svg::__construct(): Argument #2 ($width) must be of type float, array given
Cairo\Surface\Svg::__construct(): Argument #3 ($height) must be of type float, array given