--TEST--
Cairo\Context->setAntialias() method
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

$context->setAntialias(Cairo\Antialias::GRAY);
var_dump($context->getAntialias());

/* Wrong number args - 1 */
try {
    $context->setAntialias(1, 1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong args */
try {
    $context->setAntialias(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\Antialias)#%d (2) {
  ["__elements"]=>
  array(7) {
    ["DEFAULT"]=>
    int(0)
    ["NONE"]=>
    int(1)
    ["GRAY"]=>
    int(2)
    ["SUBPIXEL"]=>
    int(3)
    ["FAST"]=>
    int(4)
    ["GOOD"]=>
    int(5)
    ["BEST"]=>
    int(6)
  }
  ["__value"]=>
  int(2)
}
Cairo\Context::setAntialias() expects at most 1 argument, 2 given
Cairo\Context::setAntialias(): Argument #1 ($antialias) must be of type int, array given