--TEST--
Cairo\Surface->createSimilar() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$newsurface = $surface->createSimilar(Cairo\Surface\Content::COLOR, 10, 10);
var_dump($newsurface);

/* Wrong number args - 1 */
try {
    $surface->createSimilar();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $surface->createSimilar(Cairo\Surface\Content::COLOR);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    $surface->createSimilar(Cairo\Surface\Content::COLOR, 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    $surface->createSimilar(Cairo\Surface\Content::COLOR, 10, 10, 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $surface->createSimilar(array(), 10, 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $surface->createSimilar(Cairo\Surface\Content::COLOR, array(), 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    $surface->createSimilar(Cairo\Surface\Content::COLOR, 10, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Surface::createSimilar() expects exactly 3 arguments, 0 given
Cairo\Surface::createSimilar() expects exactly 3 arguments, 1 given
Cairo\Surface::createSimilar() expects exactly 3 arguments, 2 given
Cairo\Surface::createSimilar() expects exactly 3 arguments, 4 given
Cairo\Surface::createSimilar(): Argument #1 ($content) must be of type int, array given
Cairo\Surface::createSimilar(): Argument #2 ($width) must be of type float, array given
Cairo\Surface::createSimilar(): Argument #3 ($height) must be of type float, array given