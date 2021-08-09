--TEST--
Cairo\Context->textExtents() method
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

var_dump($context->getTextExtents('foobar'));

/* Wrong number args 1 */
try {
    $context->getTextExtents();
    trigger_error('textExtents requires one arg');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 1 */
try {
    $context->getTextExtents('foo', 1);
    trigger_error('textExtents requires only one arg');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $context->getTextExtents([]);
    trigger_error('textExtents requires one arg');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
array(6) {
  ["x_bearing"]=>
  float(%f)
  ["y_bearing"]=>
  float(%f)
  ["width"]=>
  float(%f)
  ["height"]=>
  float(%f)
  ["x_advance"]=>
  float(%f)
  ["y_advance"]=>
  float(%f)
}
Cairo\Context::getTextExtents() expects exactly 1 argument, 0 given
Cairo\Context::getTextExtents() expects exactly 1 argument, 2 given
Cairo\Context::getTextExtents(): Argument #1 ($text) must be of type string, array given