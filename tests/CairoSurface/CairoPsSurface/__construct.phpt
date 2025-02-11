--TEST--
new Cairo\Surface\Ps [__construct() method ]
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('PS', Cairo::availableSurfaces())) {
    die('skip - PS surface not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Ps(NULL, 50, 50);
var_dump($surface);

$surface = new Cairo\Surface\Ps(dirname(__FILE__) . '/nametest.ps', 50, 50);
var_dump($surface);

$fp = fopen(dirname(__FILE__) . '/streamtest.ps', 'wb');
$surface = new Cairo\Surface\Ps($fp, 50, 50);
var_dump($surface);

/* Wrong number args - 1 */
try {
    new Cairo\Surface\Ps();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    new Cairo\Surface\Ps(NULL);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    new Cairo\Surface\Ps(NULL, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Surface\Ps(NULL, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Surface\Ps([], 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Surface\Ps(NULL, [], 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Cairo\Surface\Ps(NULL, 1, []);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/nametest.ps');
unlink(dirname(__FILE__) . '/streamtest.ps');
?>
--EXPECTF--
object(Cairo\Surface\Ps)#%d (0) {
}
object(Cairo\Surface\Ps)#%d (0) {
}
object(Cairo\Surface\Ps)#%d (0) {
}
Cairo\Surface\Ps::__construct() expects exactly 3 arguments, 0 given
Cairo\Surface\Ps::__construct() expects exactly 3 arguments, 1 given
Cairo\Surface\Ps::__construct() expects exactly 3 arguments, 2 given
Cairo\Surface\Ps::__construct() expects exactly 3 arguments, 4 given
Cairo\Surface\Ps::__construct() expects parameter 1 to be null, a string, or a stream resource
Cairo\Surface\Ps::__construct(): Argument #2 ($width) must be of type float, array given
Cairo\Surface\Ps::__construct(): Argument #3 ($height) must be of type float, array given