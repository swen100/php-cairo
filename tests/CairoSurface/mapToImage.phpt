--TEST--
Cairo\Surface->mapToImage() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 250, 250);
var_dump($surface);

$image = $surface->mapToImage();
var_dump($image);

$surface2 = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 250, 250);
$rectangle = new Cairo\Rectangle(10, 10, 90, 90);
$image2 = $surface2->mapToImage($rectangle);
var_dump($image2);

/* Wrong arg type */
try {
    $surface->mapToImage('foo');
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    $surface->mapToImage($rectangle, []);
    trigger_error('We should bomb here');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface::mapToImage(): Argument #1 ($rectangle) must be of type Cairo\Rectangle, string given
Cairo\Surface::mapToImage() expects at most 1 argument, 2 given