--TEST--
Cairo\FontFace\Toy::getSlant() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!class_exists('Cairo\FontFace\Toy')) die('skip - Cairo\FontFace\Toy not enabled');
?>
--FILE--
<?php
// Test with all parameters
$c = new Cairo\FontFace\Toy("sans-serif", Cairo\FontSlant::NORMAL, Cairo\FontWeight::NORMAL);
var_dump($c->getSlant());

$c = new Cairo\FontFace\Toy("sans-serif", Cairo\FontSlant::ITALIC, Cairo\FontWeight::NORMAL);
var_dump($c->getSlant());
?>
--EXPECTF--
object(Cairo\FontSlant)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["NORMAL"]=>
    int(0)
    ["ITALIC"]=>
    int(1)
    ["OBLIQUE"]=>
    int(2)
  }
  ["__value"]=>
  int(0)
}
object(Cairo\FontSlant)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["NORMAL"]=>
    int(0)
    ["ITALIC"]=>
    int(1)
    ["OBLIQUE"]=>
    int(2)
  }
  ["__value"]=>
  int(1)
}