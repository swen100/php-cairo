--TEST--
Cairo\Surface\ImageFormat::strideForWidth() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!method_exists('Cairo\Surface\ImageFormat', 'strideForWidth')) die('skip - Cairo\Surface\ImageFormat::strideForWidth not available');
?>
--FILE--
<?php
echo Cairo\Surface\ImageFormat::strideForWidth(1, 5), PHP_EOL;

/* Wrong number args */
try {
    Cairo\Surface\ImageFormat::strideForWidth();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    Cairo\Surface\ImageFormat::strideForWidth(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    Cairo\Surface\ImageFormat::strideForWidth(1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    Cairo\Surface\ImageFormat::strideForWidth(array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    Cairo\Surface\ImageFormat::strideForWidth(1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
20
Cairo\Surface\ImageFormat::strideForWidth() expects exactly 2 %s, 0 given
Cairo\Surface\ImageFormat::strideForWidth() expects exactly 2 %s, 1 given
Cairo\Surface\ImageFormat::strideForWidth() expects exactly 2 %s, 3 given
Cairo\Surface\ImageFormat::strideForWidth(): Argument #1 ($format) must be of type int, array given
Cairo\Surface\ImageFormat::strideForWidth(): Argument #2 ($width) must be of type int, array given