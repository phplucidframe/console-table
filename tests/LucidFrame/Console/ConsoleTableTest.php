<?php

namespace LucidFrameTest\LucidFrame\Console;

use LucidFrame\Console\ConsoleTable;
use PHPUnit\Framework\TestCase;

class ConsoleTableTest extends TestCase
{
    public function testBorderedTableDefault()
    {
        $output = implode(PHP_EOL, array(
            '+----------+------+',
            '| Language | Year |',
            '+----------+------+',
            '| PHP      | 1994 |',
            '| C++      | 1983 |',
            '| C        | 1970 |',
            '+----------+------+',
        ));

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
                ->addColumn(1970);

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testBorderedTableWithHorizontalLines()
    {
        $output = implode(PHP_EOL, array(
            '+----------+------+',
            '| Language | Year |',
            '+----------+------+',
            '| PHP      | 1994 |',
            '+----------+------+',
            '| C++      | 1983 |',
            '+----------+------+',
            '| C        | 1970 |',
            '+----------+------+',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addBorderLine()
            ->addRow(array('C++', 1983))
            ->addBorderLine()
            ->addRow(array('C', 1970));

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testBorderedTableWithHorizontalLinesUsingShowAllBorders()
    {
        $output = implode(PHP_EOL, array(
            '+----------+------+',
            '| Language | Year |',
            '+----------+------+',
            '| PHP      | 1994 |',
            '+----------+------+',
            '| C++      | 1983 |',
            '+----------+------+',
            '| C        | 1970 |',
            '+----------+------+',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->showAllBorders();

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testBorderedTableWithPaddingWidth2()
    {
        $output = implode(PHP_EOL, array(
            '+------------+--------+',
            '|  Language  |  Year  |',
            '+------------+--------+',
            '|  PHP       |  1994  |',
            '|  C++       |  1983  |',
            '|  C         |  1970  |',
            '+------------+--------+',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->setPadding(2);

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testBorderedTableWithLeftMarginWidth4()
    {
        $output = implode(PHP_EOL, array(
            '    +----------+------+',
            '    | Language | Year |',
            '    +----------+------+',
            '    | PHP      | 1994 |',
            '    | C++      | 1983 |',
            '    | C        | 1970 |',
            '    +----------+------+',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->setIndent(4);

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testNonBorderedTableWithHeader()
    {
        $output = implode(PHP_EOL, array(
            ' Language  Year ',
            '----------------',
            ' PHP       1994 ',
            ' C++       1983 ',
            ' C         1970 ',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->hideBorder();

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testNonBorderedTableWithoutHeader()
    {
        $output = implode(PHP_EOL, array(
            ' PHP  1994 ',
            ' C++  1983 ',
            ' C    1970 ',
        ));

        $table = new ConsoleTable();
        $table
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->hideBorder();

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testTableWithHeaderAlignment()
    {
        $output = implode(PHP_EOL, array(
            '+---+---------------------+------+',
            '| A |                   B | C    |',
            '+---+---------------------+------+',
            '| X |               Hello | Nice |',
            '| Y | Hello, how are you? |   OK |',
            '+---+---------------------+------+',
        ));

        $table = new ConsoleTable();
        $table
            ->addHeader('A')
            ->addHeader('B', ConsoleTable::ALIGN_RIGHT)
            ->addHeader('C')
            ->addRow()
                ->addColumn('X')
                ->addColumn('Hello', null, null, ConsoleTable::ALIGN_RIGHT)
                ->addColumn('Nice')
            ->addRow()
                ->addColumn('Y')
                ->addColumn('Hello, how are you?')
                ->addColumn('OK', null, null, ConsoleTable::ALIGN_RIGHT);


        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testBorderedTableWithHeaderAndFooter()
    {
        $output = implode(PHP_EOL, array(
            '+-------+-----+',
            '| Name  | Age |',
            '+-------+-----+',
            '| John  |  25 |',
            '| Jane  |  23 |',
            '+-------+-----+',
            '| Total |  48 |',
            '+-------+-----+',
        ));

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
            ->addFooter('48', ConsoleTable::ALIGN_RIGHT);

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testNonBorderedTableWithHeaderAndFooter()
    {
        $output = implode(PHP_EOL, array(
            ' Name   Age ',
            '------------',
            ' John   25  ',
            ' Jane   23  ',
            '------------',
            ' Total  48  ',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Name', 'Age'))
            ->addRow(array('John', 25))
            ->addRow(array('Jane', 23))
            ->setFooters(array('Total', 48))
            ->hideBorder();

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testWithHeaderUsingKeys()
    {
        $output = implode(PHP_EOL, array(
            '+------+-----+',
            '| Name | Age |',
            '+------+-----+',
            '| John | 25  |',
            '+------+-----+',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('name' => 'Name', 'age' => 'Age'))
            ->addRow(array('John', '25'));

        $this->assertEquals(trim($output), trim($table->getTable()));
    }

    public function testWithRowUsingKeys()
    {
        $output = implode(PHP_EOL, array(
            '+------+-----+',
            '| Name | Age |',
            '+------+-----+',
            '| John | 25  |',
            '+------+-----+',
        ));

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Name', 'Age'))
            ->addRow(array('name' => 'John', 'age' => 25));

        $this->assertEquals(trim($output), trim($table->getTable()));
    }
}
