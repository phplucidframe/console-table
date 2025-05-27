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

_pr('Table with Some Emojis');
# addressing the issue https://github.com/phplucidframe/console-table/issues/15
$table = new ConsoleTable();
$table
    ->addHeader('A')
    ->addHeader('B')
    ->addHeader('C')
    ->addRow()
        ->addColumn('📚')
        ->addColumn('Hello 👋')
        ->addColumn('Nice')
    ->addRow()
        ->addColumn('X')
        ->addColumn('Hello 👋, how are you 😊?')
        ->addColumn('OK')
    ->display();

_pr('Table with Column Alignment');
# addressing the issue https://github.com/phplucidframe/console-table/issues/19
$table = new ConsoleTable();
$table
    ->addHeader('A')
    ->addHeader('B', ConsoleTable::ALIGN_RIGHT) # ALIGN_LEFT or ALIGN_RIGHT (ALIGN_LEFT is default
    ->addHeader('C')
    ->addRow()
        ->addColumn('X')
        ->addColumn('Hello', null, null, ConsoleTable::ALIGN_RIGHT)
        ->addColumn('Nice')
    ->addRow()
        ->addColumn('Y')
        ->addColumn('Hello, how are you?')
        ->addColumn('OK', null, null, ConsoleTable::ALIGN_RIGHT)
    ->display();

_pr('Bordered Table with Header & Footer');
# addressing the issue https://github.com/phplucidframe/console-table/issues/20
$table = new ConsoleTable();
$table
    ->addHeader('Name')
    ->addHeader('Age')
    ->addRow()
        ->addColumn('John')
        ->addColumn(25, null, null, ConsoleTable::ALIGN_RIGHT)
    ->addRow()
        ->addColumn('Jane')
        ->addColumn(23, null, null, ConsoleTable::ALIGN_RIGHT)
    ->addFooter('Total')
    ->addFooter('48', ConsoleTable::ALIGN_RIGHT)
    ->display();

_pr('Non-bordered Table with Header & Footer');
$table = new ConsoleTable();
$table
    ->setHeaders(array('Name', 'Age'))
    ->addRow(array('John', 25))
    ->addRow(array('Jane', 23))
    ->setFooters(array('Total', 48))
    ->hideBorder()
    ->display();
