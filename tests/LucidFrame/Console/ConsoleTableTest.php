<?php

namespace LucidFrameTest\Console\ConsoleTable;

use LucidFrame\Console\ConsoleTable;
use PHPUnit\Framework\TestCase;

class ConsoleTableTest extends TestCase
{
    public function testBorderedTableDefault()
    {
        $borderedTableDefault = '
+----------+------+
| Language | Year |
+----------+------+
| PHP      | 1994 |
| C++      | 1983 |
| C        | 1970 |
+----------+------+';

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

        $this->assertEquals(trim($borderedTableDefault), trim($table->getTable()));
    }

    public function testBorderedTableWithHorizontalLines()
    {
        $borderedTableWithHorizontalLines = '
+----------+------+
| Language | Year |
+----------+------+
| PHP      | 1994 |
+----------+------+
| C++      | 1983 |
+----------+------+
| C        | 1970 |
+----------+------+';

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addBorderLine()
            ->addRow(array('C++', 1983))
            ->addBorderLine()
            ->addRow(array('C', 1970));

        $this->assertEquals(trim($borderedTableWithHorizontalLines), trim($table->getTable()));
    }

    public function testBorderedTableWithHorizontalLinesUsingShowAllBorders()
    {
        $borderedTableWithHorizontalLines = '
+----------+------+
| Language | Year |
+----------+------+
| PHP      | 1994 |
+----------+------+
| C++      | 1983 |
+----------+------+
| C        | 1970 |
+----------+------+';

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->showAllBorders();

        $this->assertEquals(trim($borderedTableWithHorizontalLines), trim($table->getTable()));
    }

    public function testBorderedTableWithPaddingWidth2()
    {
        $borderedTableWithPaddingWidth2 = '
+------------+--------+
|  Language  |  Year  |
+------------+--------+
|  PHP       |  1994  |
|  C++       |  1983  |
|  C         |  1970  |
+------------+--------+';

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->setPadding(2);

        $this->assertEquals(trim($borderedTableWithPaddingWidth2), trim($table->getTable()));
    }

    public function testBorderedTableWithLeftMarginWidth4()
    {
        $borderedTableWithLeftMarginWidth4 = '
    +----------+------+
    | Language | Year |
    +----------+------+
    | PHP      | 1994 |
    | C++      | 1983 |
    | C        | 1970 |
    +----------+------+';

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->setIndent(4);

        $this->assertEquals(trim($borderedTableWithLeftMarginWidth4), trim($table->getTable()));
    }

    public function testNonBorderedTableWithHeader()
    {
        $nonBorderedTableWithHeader = '
 Language  Year 
----------------
 PHP       1994 
 C++       1983 
 C         1970 ';

        $table = new ConsoleTable();
        $table
            ->setHeaders(array('Language', 'Year'))
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->hideBorder();

        $this->assertEquals(trim($nonBorderedTableWithHeader), trim($table->getTable()));
    }

    public function testNonBorderedTableWithoutHeader()
    {
        $nonBorderedTableWithoutHeader = '
 PHP  1994 
 C++  1983 
 C    1970 ';

        $table = new ConsoleTable();
        $table
            ->addRow(array('PHP', 1994))
            ->addRow(array('C++', 1983))
            ->addRow(array('C', 1970))
            ->hideBorder();

        $this->assertEquals(trim($nonBorderedTableWithoutHeader), trim($table->getTable()));
    }
}
