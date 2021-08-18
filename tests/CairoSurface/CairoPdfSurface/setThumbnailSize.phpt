--TEST--
Cairo\Surface\Pdf->setThumbnailSize() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('PDF', Cairo::availableSurfaces())) {
    die('skip - PDF surface not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Pdf(NULL, 50, 50);
var_dump($surface);

$surface->setSize(10, 10);
$surface->setThumbnailSize(5, 5);

/* Wrong number args 1*/
try {
    $surface->setThumbnailSize();
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->setThumbnailSize(10);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    $surface->setThumbnailSize(10, 10, 10);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $surface->setThumbnailSize([], 1);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $surface->setThumbnailSize(1, []);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Pdf)#%d (0) {
}
Cairo\Surface\Pdf::setThumbnailSize() expects exactly 2 %s, 0 given
Cairo\Surface\Pdf::setThumbnailSize() expects exactly 2 %s, 1 given
Cairo\Surface\Pdf::setThumbnailSize() expects exactly 2 %s, 3 given
Cairo\Surface\Pdf::setThumbnailSize(): Argument #1 ($width) must be of type float, array given
Cairo\Surface\Pdf::setThumbnailSize(): Argument #2 ($height) must be of type float, array given