--TEST--
Cairo\Context->popGroupToSource() method
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

$context->pushGroup();
$context->popGroupToSource();

var_dump($context->getPattern());

/* wrong params */
try {
    $context->popGroupToSource(1);	
}
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
Cairo\Context::popGroupToSource() expects exactly 0 arguments, 1 given