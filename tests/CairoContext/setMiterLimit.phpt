--TEST--
Cairo\Context->setMiterLimit() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$context = new Cairo\Context($surface);
var_dump($context);

$context->setMiterLimit(1);
var_dump($context->getMiterLimit());


/* Wrong number args - 1 */
try {
    $context->setMiterLimit();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $context->setMiterLimit(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong args */
try {
    $context->setMiterLimit(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
float(1)
Cairo\Context::setMiterLimit() expects exactly 1 argument, 0 given
Cairo\Context::setMiterLimit() expects exactly 1 argument, 2 given
Cairo\Context::setMiterLimit(): Argument #1 ($limit) must be of type float, array given