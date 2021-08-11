--TEST--
Cairo\Pattern->setFilter() method [using Surface]
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$pattern = new Cairo\Pattern\Surface($surface);
var_dump($pattern);

$pattern->setFilter(Cairo\Filter::NEAREST);
$filter = $pattern->getFilter();
var_dump($filter);
var_dump($filter == Cairo\Filter::NEAREST);

$pattern->setFilter(new Cairo\Filter('FAST'));
$filter = $pattern->getFilter();
var_dump($filter == Cairo\Filter::FAST);

$pattern->setFilter(1);
$filter = $pattern->getFilter();
var_dump($filter);
var_dump($filter == Cairo\Filter::GOOD);

/* Total number of args needed = 1 */
try {
    $pattern->setFilter();
    trigger_error('setFilter with no args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->setFilter(1, 1);
    trigger_error('setFilter with too many args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be int or castable to int */
try {
    $pattern->setFilter([]);
    trigger_error('Arg 1 must be int');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->setFilter($surface);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* int must be in enum */
try {
    $pattern->setFilter(999);
    trigger_error('Arg 1 must be int');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
object(Cairo\Filter)#%d (2) {
  ["__elements"]=>
  array(6) {
    ["FAST"]=>
    int(0)
    ["GOOD"]=>
    int(1)
    ["BEST"]=>
    int(2)
    ["NEAREST"]=>
    int(3)
    ["BILINEAR"]=>
    int(4)
    ["GAUSSIAN"]=>
    int(5)
  }
  ["__value"]=>
  int(3)
}
bool(true)
bool(true)
object(Cairo\Filter)#%d (2) {
  ["__elements"]=>
  array(6) {
    ["FAST"]=>
    int(0)
    ["GOOD"]=>
    int(1)
    ["BEST"]=>
    int(2)
    ["NEAREST"]=>
    int(3)
    ["BILINEAR"]=>
    int(4)
    ["GAUSSIAN"]=>
    int(5)
  }
  ["__value"]=>
  int(1)
}
bool(true)
Cairo\Pattern::setFilter() expects exactly 1 argument, 0 given
Cairo\Pattern::setFilter() expects exactly 1 argument, 2 given
Cairo\Pattern::setFilter(): Argument #1 ($filter) must be of type int, array given
Cairo\Pattern::setFilter(): Argument #1 ($filter) must be of type int, Cairo\Surface\Image given
Value 999 provided is not a const in enum Cairo\Filter