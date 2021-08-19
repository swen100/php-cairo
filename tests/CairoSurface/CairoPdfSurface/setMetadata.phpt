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

$surface->setMetadata(\Cairo\Surface\Pdf\Metadata::TITLE, "blubber");
$surface->setMetadata(\Cairo\Surface\Pdf\Metadata::CREATE_DATE, date("Y-m-d\TH:i:s"));
$surface->setMetadata(0, "blubber");
$surface->setMetadata(1);
$surface->setMetadata(5, date("Y-m-d\TH:i:s"));


/* invalid arg */
try {
    $surface->setMetadata(999, "bla");
    trigger_error('We should bomb here');
} catch (ValueError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 0 */
try {
    $surface->setMetadata();
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    $surface->setMetadata(\Cairo\Surface\Pdf\Metadata::TITLE, "bla", "bla");
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $surface->setMetadata([], "bla");
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $surface->setMetadata(\Cairo\Surface\Pdf\Metadata::TITLE, []);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Pdf)#%d (0) {
}
Cairo\Surface\Pdf::setMetadata(): Argument #1 ($metadata_constant) is not a valid Cairo\Surface\Pdf\Metadata constant.
Cairo\Surface\Pdf::setMetadata() expects at least 1 argument, 0 given
Cairo\Surface\Pdf::setMetadata() expects at most 2 arguments, 3 given
Cairo\Surface\Pdf::setMetadata(): Argument #1 ($metadata_constant) must be of type int, array given
Cairo\Surface\Pdf::setMetadata(): Argument #2 ($metadata) must be of type string, array given