--TEST--
Cairo\Context->setPattern() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$context = new Cairo\Context();
$context->setSurface($surface);
var_dump($context);

$pattern = new Cairo\Pattern\Solid(0.3, 0.3, 0.3);
var_dump($pattern);

$context->setPattern($pattern);
var_dump($context->getPattern()->getRGBA());

$pattern = new Cairo\Pattern\Solid(0.3, 0.3, 0.3);
var_dump($pattern);

$context->setPattern($pattern);

var_dump($context->getPattern()->getRGBA());

/* Wrong number args */
try {
    $context->setPattern();
    trigger_error('setPattern requires only one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    $context->setPattern($pattern, 1);
    trigger_error('setPattern requires only one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $context->setPattern(new stdClass());
    trigger_error('setPattern expects instanceof \Cairo\Pattern');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $context->setPattern(array());
    trigger_error('setPattern expects instanceof \Cairo\Pattern');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

// DO NOT REMOVE: workaround for GC-related bug in 5.3
die;
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\Pattern\Solid)#%d (0) {
}
array(4) {
  ["red"]=>
  float(0.3)
  ["green"]=>
  float(0.3)
  ["blue"]=>
  float(0.3)
  ["alpha"]=>
  float(1)
}
object(Cairo\Pattern\Solid)#%d (0) {
}
array(4) {
  ["red"]=>
  float(0.3)
  ["green"]=>
  float(0.3)
  ["blue"]=>
  float(0.3)
  ["alpha"]=>
  float(1)
}
Cairo\Context::setPattern() expects exactly 1 argument, 0 given
Cairo\Context::setPattern() expects exactly 1 argument, 2 given
Cairo\Context::setPattern(): Argument #1 ($pattern) must be of type Cairo\Pattern, stdClass given
Cairo\Context::setPattern(): Argument #1 ($pattern) must be of type Cairo\Pattern, array given
