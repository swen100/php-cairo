--TEST--
Cairo\Surface::writeToJpeg() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('JPEG', Cairo::availableSurfaces())) {
    die('skip - JPEG support not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$surface->writeToJpeg(dirname(__FILE__) . '/test.jpg');

$fp = fopen(dirname(__FILE__) . '/stream.jpg', 'wb');
$surface->writeToJpeg($fp);

/* Wrong number args - 1 */
try {
    $surface->writeToJpeg();
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Empty arg */
try {
    $surface->writeToJpeg('');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    $surface->writeToJpeg('dummy', 1, 'dummy');
    trigger_error('We should bomb here');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg */
try {
    $surface->writeToJpeg([]);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/test.jpg');
unlink(dirname(__FILE__) . '/stream.jpg');
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface::writeToJpeg() expects at least 1 argument, 0 given
Cairo\Surface::writeToJpeg() expects parameter 1 to be a (not empty) string or a stream resource
Cairo\Surface::writeToJpeg() expects at most 2 arguments, 3 given
Cairo\Surface::writeToJpeg() expects parameter 1 to be a (not empty) string or a stream resource