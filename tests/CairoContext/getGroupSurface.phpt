--TEST--
Cairo\Context->getGroupTarget() method
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

$surface2 = $context->getGroupSurface();
var_dump($surface2);
var_dump($surface2 == $surface);

/* wrong params */
try {
    $context->getGroupSurface(1);	
}
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\Surface\Image)#%d (0) {
}
bool(true)
Cairo\Context::getGroupSurface() expects exactly 0 arguments, 1 given