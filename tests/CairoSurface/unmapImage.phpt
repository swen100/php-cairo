--TEST--
Cairo\Surface->unmapImage() method
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

$rectangle = new Cairo\Rectangle(10, 10, 90, 90);
$image = $surface->mapToImage($rectangle);
var_dump($image);

$surface->unmapImage($image);

/* Wrong arg type */
try {
    $surface->unmapImage('foo');
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 0 */
try {
    $surface->unmapImage();
    trigger_error('We should bomb here');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $image = $surface->mapToImage($rectangle);
    $surface->unmapImage($image, []);
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
Cairo\Surface::unmapImage(): Argument #1 ($image_surface) must be of type Cairo\Surface, string given
Cairo\Surface::unmapImage() expects exactly 1 argument, 0 given
Cairo\Surface::unmapImage() expects exactly 1 argument, 2 given