--TEST--
Cairo\Matrix object get_properties handler;
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
use Cairo\Matrix;

$matrix = new Matrix(6, 5, 4, 3, 2, 1);
var_dump($matrix);
print_r($matrix);

?>
--EXPECTF--
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(6)
  ["xy"]=>
  float(4)
  ["x0"]=>
  float(2)
  ["yx"]=>
  float(5)
  ["yy"]=>
  float(3)
  ["y0"]=>
  float(1)
}
Cairo\Matrix Object
(
    [xx] => 6
    [xy] => 4
    [x0] => 2
    [yx] => 5
    [yy] => 3
    [y0] => 1
)