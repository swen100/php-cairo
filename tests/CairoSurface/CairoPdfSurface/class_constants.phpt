--TEST--
Cairo\Pdf class constants
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php

if (\Cairo\VERSION >= 11600) {
    $constants = [
        '\Cairo\Surface\Pdf\Outline::ROOT',
        
        '\Cairo\Surface\Pdf\OutlineFlags::OPEN',
        '\Cairo\Surface\Pdf\OutlineFlags::BOLD',
        '\Cairo\Surface\Pdf\OutlineFlags::ITALIC',
        
        '\Cairo\Surface\Pdf\Metadata::TITLE',
        '\Cairo\Surface\Pdf\Metadata::AUTHOR',
        '\Cairo\Surface\Pdf\Metadata::SUBJECT',
        '\Cairo\Surface\Pdf\Metadata::KEYWORDS',
        '\Cairo\Surface\Pdf\Metadata::CREATOR',
        '\Cairo\Surface\Pdf\Metadata::CREATE_DATE',
        '\Cairo\Surface\Pdf\Metadata::MOD_DATE',
        
        '\Cairo\Surface\Pdf\Version::VERSION_1_4',
        '\Cairo\Surface\Pdf\Version::VERSION_1_5'
    ];
} else {
    $constants = [];
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