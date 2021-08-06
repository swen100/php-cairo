--TEST--
Cairo::statusToString() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(\Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$context = new Cairo\Context($surface);
var_dump($context);

var_dump($context->getStatus()->getMessage());

/* Wrong number args */
try {
    $context->getStatus()->getMessage('test');
    //trigger_error('Cairo::statusToString should take 1 argument');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
string(21) "no error has occurred"
Cairo\Status::getMessage() expects exactly 0 arguments, 1 given