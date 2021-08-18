--TEST--
Cairo\Surface\Svg\Version class constants
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('SVG', Cairo::availableSurfaces())) {
    die('skip - SVG surface not available');
}
?>
--FILE--
<?php
$constants = [
    'Cairo\Surface\Svg\Version::VERSION_1_1',
    'Cairo\Surface\Svg\Version::VERSION_1_2',
];

if (\Cairo\VERSION >= 11600) {
    $constants = array_merge($constants, [
        'Cairo\Surface\Svg\Unit::USER',
        'Cairo\Surface\Svg\Unit::EM',
        'Cairo\Surface\Svg\Unit::EX',
        'Cairo\Surface\Svg\Unit::PX',
        'Cairo\Surface\Svg\Unit::IN',
        'Cairo\Surface\Svg\Unit::CM',
        'Cairo\Surface\Svg\Unit::MM',
        'Cairo\Surface\Svg\Unit::PT',
        'Cairo\Surface\Svg\Unit::PC',
        'Cairo\Surface\Svg\Unit::PERCENT'
    ]);
}

$error = false;
foreach ($constants as $constant) {
    if (!defined($constant)) {
        $error = true;
        echo 'Missing Constant: ' . $constant . "\n";
    }
}
if (!$error) {
    echo "No missing constants, checked " . sizeof($constants) . "!\n";
}
echo "Done\n";
?>
--EXPECTF--
No missing constants, checked %d!
Done