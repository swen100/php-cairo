--TEST--
Cairo\Surface\Ps->dscComment() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Ps(NULL, 50, 50);
var_dump($surface);

$surface->dscComment('%%Title: My excellent document');

/* Wrong number args */
try {
    $surface->dscComment();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->dscComment(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->dscComment(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Ps)#%d (0) {
}
Cairo\Surface\Ps::dscComment() expects exactly 1 argument, 0 given
Cairo\Surface\Ps::dscComment() expects exactly 1 argument, 2 given
Cairo\Surface\Ps::dscComment(): Argument #1 ($comment) must be of type string, array given