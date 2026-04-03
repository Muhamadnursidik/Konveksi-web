<?php

require 'vendor/autoload.php';

if (interface_exists('Maatwebsite\Excel\Concerns\FromCollection')) {
    echo "FromCollection interface EXISTS\n";
} else {
    echo "FromCollection interface NOT FOUND\n";
}

if (interface_exists('Maatwebsite\Excel\Concerns\WithHeadings')) {
    echo "WithHeadings interface EXISTS\n";
} else {
    echo "WithHeadings interface NOT FOUND\n";
}

if (interface_exists('Maatwebsite\Excel\Concerns\WithMapping')) {
    echo "WithMapping interface EXISTS\n";
} else {
    echo "WithMapping interface NOT FOUND\n";
}

// Check which version is installed
echo "\nChecking installed version...\n";
if (file_exists('vendor/maatwebsite/excel/composer.json')) {
    $composer = json_decode(file_get_contents('vendor/maatwebsite/excel/composer.json'), true);
    echo "Version: " . $composer['version'] . "\n";
}
