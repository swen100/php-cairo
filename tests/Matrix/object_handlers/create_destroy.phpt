--TEST--
Cairo\Matrix object create/destroy handlers;
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
use Cairo\Matrix;

$matrix = new Matrix();
unset($matrix);

class neo extends Matrix{
    public $xx = 1;
    public $xy = 2;
}

$mr_andersen = new neo();
var_dump($mr_andersen);
?>
--EXPECTF--
object(neo)#%d (6) {
  ["xx"]=>
  float(1)
  ["xy"]=>
  float(0)
  ["x0"]=>
  float(0)
  ["yx"]=>
  float(0)
  ["yy"]=>
  float(1)
  ["y0"]=>
  float(0)
}