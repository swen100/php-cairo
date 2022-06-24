--TEST--
Cairo\Surface\Image::createForData() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = Cairo\Surface\Image::createForData('', Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

/* Wrong number args - 1 */
try {
    Cairo\Surface\Image::createForData();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    Cairo\Surface\Image::createForData('');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    Cairo\Surface\Image::createForData('', Cairo\Surface\ImageFormat::ARGB32);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    Cairo\Surface\Image::createForData('', Cairo\Surface\ImageFormat::ARGB32, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 5 */
try {
    Cairo\Surface\Image::createForData('', Cairo\Surface\ImageFormat::ARGB32, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    Cairo\Surface\Image::createForData(array(), 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    Cairo\Surface\Image::createForData('', array(), 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    Cairo\Surface\Image::createForData('', 1, array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 4 */
try {
    Cairo\Surface\Image::createForData('', 1, 1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface\Image::createForData() expects exactly 4 %s, 0 given
Cairo\Surface\Image::createForData() expects exactly 4 %s, 1 given
Cairo\Surface\Image::createForData() expects exactly 4 %s, 2 given
Cairo\Surface\Image::createForData() expects exactly 4 %s, 3 given
Cairo\Surface\Image::createForData() expects exactly 4 %s, 5 given
Cairo\Surface\Image::createForData(): Argument #1 ($data) must be of type string, array given
Cairo\Surface\Image::createForData(): Argument #2 ($format) must be of type int, array given
Cairo\Surface\Image::createForData(): Argument #3 ($width) must be of type int, array given
Cairo\Surface\Image::createForData(): Argument #4 ($height) must be of type int, array given
