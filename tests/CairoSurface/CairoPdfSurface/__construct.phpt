--TEST--
new Cairo\Surface\Pdf [__construct() method ]
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('PDF', Cairo::availableSurfaces())) {
    die('skip - PDF surface not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Pdf(NULL, 50, 50);
var_dump($surface);

$surface2 = new Cairo\Surface\Pdf(dirname(__FILE__) . '/nametest.pdf', 50, 50);
var_dump($surface2);

$fp = fopen(dirname(__FILE__) . '/streamtest.pdf', 'wb');
$surface3 = new Cairo\Surface\Pdf($fp, 50, 50);
var_dump($surface3);

/* Wrong number args - 1 */
try {
    new Cairo\Surface\Pdf();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    new Cairo\Surface\Pdf(NULL);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    new Cairo\Surface\Pdf(NULL, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Surface\Pdf(NULL, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Surface\Pdf([], 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Surface\Pdf(NULL, [], 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Cairo\Surface\Pdf(NULL, 1, []);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/nametest.pdf');
unlink(dirname(__FILE__) . '/streamtest.pdf');
?>
--EXPECTF--
object(Cairo\Surface\Pdf)#%d (0) {
}
object(Cairo\Surface\Pdf)#%d (0) {
}
object(Cairo\Surface\Pdf)#%d (0) {
}
Cairo\Surface\Pdf::__construct() expects exactly 3 arguments, 0 given
Cairo\Surface\Pdf::__construct() expects exactly 3 arguments, 1 given
Cairo\Surface\Pdf::__construct() expects exactly 3 arguments, 2 given
Cairo\Surface\Pdf::__construct() expects exactly 3 arguments, 4 given
Cairo\Surface\Pdf::__construct() expects parameter 1 to be null, a string, or a stream resource
Cairo\Surface\Pdf::__construct(): Argument #2 ($width) must be of type float, array given
Cairo\Surface\Pdf::__construct(): Argument #3 ($height) must be of type float, array given