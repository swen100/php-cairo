--TEST--
Cairo\Context->setFontFace() method
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

include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);

$context->setFontFace($fontface);
$fontface1 = $context->getFontFace();

var_dump($fontface === $fontface1);

include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);

$context->setFontFace($fontface);
$fontface1 = $context->getFontFace();

var_dump($fontface1 === $fontface);

try {
    $context->setFontFace();
    trigger_error('setFontFace requires one arg');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setFontFace(1, 1);
    trigger_error('setFontFace requires only one arg');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setFontFace(1);
    trigger_error('setFontFace requires instanceof Cairo\FontFace');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}


?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\FontFace\Toy)#%d (0) {
}
bool(true)
object(Cairo\FontFace\Toy)#%d (0) {
}
bool(true)
Cairo\Context::setFontFace() expects exactly 1 argument, 0 given
Cairo\Context::setFontFace() expects exactly 1 argument, 2 given
Cairo\Context::setFontFace(): Argument #1 ($fontface) must be of type Cairo\FontFace, int given