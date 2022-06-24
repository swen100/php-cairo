--TEST--
Cairo\Surface\Pdf->setPageLabel() method
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
$surface->setPageLabel("blubber");

/* Wrong number args 0*/
try {
    $surface->setPageLabel();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->setPageLabel("bla", "bla");
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->setPageLabel([]);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Pdf)#%d (0) {
}
Cairo\Surface\Pdf::setPageLabel() expects exactly 1 argument, 0 given
Cairo\Surface\Pdf::setPageLabel() expects exactly 1 argument, 2 given
Cairo\Surface\Pdf::setPageLabel(): Argument #1 ($label) must be of type string, array given