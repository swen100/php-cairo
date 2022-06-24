--TEST--
Cairo\Context->getFillRule() method
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

var_dump($context->getFillRule());

/* Wrong number args */
try {
    $context->getFillRule('foobar');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\FillRule)#%d (2) {
  ["__elements"]=>
  array(2) {
    ["WINDING"]=>
    int(0)
    ["EVEN_ODD"]=>
    int(1)
  }
  ["__value"]=>
  int(0)
}
Cairo\Context::getFillRule() expects exactly 0 %s, 1 given