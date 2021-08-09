--TEST--
new Cairo\FontFace [ __construct method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
class test extends Cairo\FontFace {}

class test2 extends Cairo\FontFace {
    public function __construct() {}
}
try {
    $fontFace = new test();
    echo 'Attempting to use constructor should throw an exception';
} catch (Cairo\Exception $e) {
    echo $e->getMessage();
}
echo "\n";
try {
    $fontFace = new test2();
    $fontFace->getType();
} catch (Cairo\Exception $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
Cairo\FontFace cannot be constructed
Internal font face object missing in test2, you must call parent::__construct in extended classes