--TEST--
Cairo\Surface::writeToPng() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('PNG', Cairo::availableSurfaces())) {
    die('skip - PNG support not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$surface->writeToPng(dirname(__FILE__) . '/test.png');

$fp = fopen(dirname(__FILE__) . '/stream.png', 'wb');
$surface->writeToPng($fp);

/* Wrong number args - 1 */
try {
    $surface->writeToPng();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Empty arg */
try {
    $surface->writeToPng('');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $surface->writeToPng('', 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg */
try {
    $surface->writeToPng([]);
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/test.png');
unlink(dirname(__FILE__) . '/stream.png');
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface::writeToPng() expects exactly 1 argument, 0 given
Cairo\Surface::writeToPng() expects parameter 1 to be a (not empty) string or a stream resource
Cairo\Surface::writeToPng() expects exactly 1 argument, 2 given
Cairo\Surface::writeToPng() expects parameter 1 to be a (not empty) string or a stream resource