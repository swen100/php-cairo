--TEST--
Cairo\Surface->createSimilarImage() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$newsurface = $surface->createSimilarImage(Cairo\Surface\ImageFormat::RGB24, 10, 10);
var_dump($newsurface);

/* Wrong number args - 1 */
try {
    $surface->createSimilarImage();
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $surface->createSimilarImage(Cairo\Surface\Content::COLOR);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    $surface->createSimilarImage(Cairo\Surface\Content::COLOR, 10);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    $surface->createSimilarImage(Cairo\Surface\Content::COLOR, 10, 10, 10);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $surface->createSimilarImage(array(), 10, 10);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $surface->createSimilarImage(Cairo\Surface\Content::COLOR, array(), 10);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    $surface->createSimilarImage(Cairo\Surface\Content::COLOR, 10, array());
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface::createSimilarImage() expects exactly 3 arguments, 0 given
Cairo\Surface::createSimilarImage() expects exactly 3 arguments, 1 given
Cairo\Surface::createSimilarImage() expects exactly 3 arguments, 2 given
Cairo\Surface::createSimilarImage() expects exactly 3 arguments, 4 given
Cairo\Surface::createSimilarImage(): Argument #1 ($format) must be of type int, array given
Cairo\Surface::createSimilarImage(): Argument #2 ($width) must be of type float, array given
Cairo\Surface::createSimilarImage(): Argument #3 ($height) must be of type float, array given