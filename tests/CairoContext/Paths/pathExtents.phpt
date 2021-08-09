--TEST--
Cairo\Context->pathExtents() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!method_exists('Cairo\Context', 'getPathExtents')) die('skip - Cairo\Context->getPathExtents extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$context = new Cairo\Context($surface);
var_dump($context);

var_dump($context->getPathExtents());

/* Wrong number args 10*/
try {
    $context->getPathExtents('foobar');
    trigger_error('textExtents requires no args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
array(4) {
  [0]=>
  float(0)
  [1]=>
  float(0)
  [2]=>
  float(0)
  [3]=>
  float(0)
}
Cairo\Context::getPathExtents() expects exactly 0 arguments, 1 given