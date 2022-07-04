--TEST--
new Cairo\Surface\Image [__construct() method ]
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

/* Wrong number args - 0 */
try {
    new Cairo\Surface\Image();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 1 */
try {
    new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Surface\Image(array(), 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface\Image::__construct() expects exactly 3 %s, 0 given
Cairo\Surface\Image::__construct() expects exactly 3 %s, 1 given
Cairo\Surface\Image::__construct() expects exactly 3 %s, 2 given
Cairo\Surface\Image::__construct() expects exactly 3 %s, 4 given
Cairo\Surface\Image::__construct(): Argument #1 ($format) must be of type int, array given
Cairo\Surface\Image::__construct(): Argument #2 ($width) must be of type int, array given
Cairo\Surface\Image::__construct(): Argument #3 ($height) must be of type int, array given