--TEST--
new Cairo\Surface\SubSurface [ __construct method ]
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php

class test extends Cairo\Surface\SubSurface {
    
}

class test2 extends Cairo\Surface\SubSurface {

    public function __construct() {
        
    }

}

try {
    $surface = new test();
    echo 'Attempting to use constructor should throw an exception';
} catch (Cairo\Exception $e) {
    echo $e->getMessage();
}

echo "\n";
try {
    $surface = new test2();
    $surface->finish();
    echo 'First call to any method should throw a fatal error';
} catch (Cairo\Exception $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
CairoSubSurface cannot be constructed
Internal surface object missing in test2, you must call parent::__construct in extended classes
