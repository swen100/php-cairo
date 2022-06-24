--TEST--
Cairo\Context->pushGroupWithContent() method
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

$context->pushGroupWithContent(Cairo\Surface\Content::COLOR);

/* Wrong number args - needs 1 */
try {
    $context->pushGroupWithContent();
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - needs 1 */
try {
    $context->pushGroupWithContent(1, 1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type, needs int */
try {
    $context->pushGroupWithContent(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
Cairo\Context::pushGroupWithContent() expects exactly 1 argument, 0 given
Cairo\Context::pushGroupWithContent() expects exactly 1 argument, 2 given
Cairo\Context::pushGroupWithContent(): Argument #1 ($content) must be of type int, array given