--TEST--
Cairo\Surface\Pdf::getVersions() method
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
var_dump(Cairo\Surface\Pdf::getVersions());

/* Wrong number args */
try {
    Cairo\Surface\Pdf::getVersions('foo');
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
array(2) {
  [0]=>
  int(0)
  [1]=>
  int(1)
}
Cairo\Surface\Pdf::getVersions() expects exactly 0 %s, 1 given