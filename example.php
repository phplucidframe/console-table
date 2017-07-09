<?php

require 'src/LucidFrame/Console/ConsoleTable.php';

use LucidFrame\Console\ConsoleTable;

function _pr($string)
{
    if (PHP_SAPI == 'cli') {
        echo "\n";
        echo '### '.$string.' ###';
        echo "\n\n";
    } else {
        echo '<h2>'.$string.'</h2>';
    }
}

_pr('Bordered Table (Default)');

$table = new ConsoleTable();
$table
    ->addHeader('Language')
    ->addHeader('Year')
    ->addRow()
        ->addColumn('PHP')
        ->addColumn(1994)
    ->addRow()
        ->addColumn('C++')
        ->addColumn(1983)
    ->addRow()
        ->addColumn('C')
        ->addColumn(1970)
    ->display()
;

_pr('Bordered Table with Horizontal Lines');

$table = new ConsoleTable();
$table
    ->setHeaders(array('Language', 'Year'))
    ->addRow(array('PHP', 1994))
    ->addBorderLine()
    ->addRow(array('C++', 1983))
    ->addBorderLine()
    ->addRow(array('C', 1970))
    ->display()
;

_pr('Bordered Table with Horizontal Lines using showAllBorders()');

$table = new ConsoleTable();
$table
    ->setHeaders(array('Language', 'Year'))
    ->addRow(array('PHP', 1994))
    ->addRow(array('C++', 1983))
    ->addRow(array('C', 1970))
    ->showAllBorders()
    ->display()
;

_pr('Bordered Table with Padding Width 2');

$table = new ConsoleTable();
$table
    ->setHeaders(array('Language', 'Year'))
    ->addRow(array('PHP', 1994))
    ->addRow(array('C++', 1983))
    ->addRow(array('C', 1970))
    ->setPadding(2)
    ->display()
;

_pr('Bordered Table with Left Margin Width 4');

$table = new ConsoleTable();
$table
    ->setHeaders(array('Language', 'Year'))
    ->addRow(array('PHP', 1994))
    ->addRow(array('C++', 1983))
    ->addRow(array('C', 1970))
    ->setIndent(4)
    ->display()
;

_pr('Non-bordered Table with Header');

$table = new ConsoleTable();
$table
    ->setHeaders(array('Language', 'Year'))
    ->addRow(array('PHP', 1994))
    ->addRow(array('C++', 1983))
    ->addRow(array('C', 1970))
    ->hideBorder()
    ->display()
;

_pr('Non-bordered Table without Header');

$table = new ConsoleTable();
$table
    ->addRow(array('PHP', 1994))
    ->addRow(array('C++', 1983))
    ->addRow(array('C', 1970))
    ->hideBorder()
    ->display()
;
