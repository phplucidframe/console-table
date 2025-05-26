# PHP ConsoleTable

**ConsoleTabe** makes you easy to build console style tables. It helps you to display tabular data in terminal/shell. This is a component of [PHPLucidFrame](https://github.com/phplucidframe/phplucidframe).

License: [MIT](https://opensource.org/licenses/MIT)

## Composer Installation

    composer require phplucidframe/console-table

## Example 1: Bordered Table (Default)

    $table = new LucidFrame\Console\ConsoleTable();
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

You can also print the table using `getTable` method such as `echo $table->getTable();`

**Output**:

    +----------+------+
    | Language | Year |
    +----------+------+
    | PHP      | 1994 |
    | C++      | 1983 |
    | C        | 1970 |
    +----------+------+

## Example 2: Bordered Table with Padding Width 2

You can also use `setHeaders()` and `addRow` with Arrays.

    $table = new LucidFrame\Console\ConsoleTable();
    $table
        ->setHeaders(array('Language', 'Year'))
        ->addRow(array('PHP', 1994))
        ->addRow(array('C++', 1983))
        ->addRow(array('C', 1970))
        ->setPadding(2)
        ->display()
    ;

**Output**:

    +------------+--------+
    |  Language  |  Year  |
    +------------+--------+
    |  PHP       |  1994  |
    |  C++       |  1983  |
    |  C         |  1970  |
    +------------+--------+

## Example 3: Bordered Table with Left Margin Width 4

    $table = new LucidFrame\Console\ConsoleTable();
    $table
        ->setHeaders(array('Language', 'Year'))
        ->addRow(array('PHP', 1994))
        ->addRow(array('C++', 1983))
        ->addRow(array('C', 1970))
        ->setIndent(4)
        ->display()
    ;

**Output**:

        +----------+------+
        | Language | Year |
        +----------+------+
        | PHP      | 1994 |
        | C++      | 1983 |
        | C        | 1970 |
        +----------+------+

## Example 4: Non-bordered Table with Header

    $table = new LucidFrame\Console\ConsoleTable();
    $table
        ->setHeaders(array('Language', 'Year'))
        ->addRow(array('PHP', 1994))
        ->addRow(array('C++', 1983))
        ->addRow(array('C', 1970))
        ->hideBorder()
        ->display()
    ;

**Output**:

     Language  Year
    ----------------
     PHP       1994
     C++       1983
     C         1970

## Example 5: Non-bordered Table without Header

    $table = new LucidFrame\Console\ConsoleTable();
    $table
        ->addRow(array('PHP', 1994))
        ->addRow(array('C++', 1983))
        ->addRow(array('C', 1970))
        ->hideBorder()
        ->display()
    ;

**Output**:

     PHP  1994
     C++  1983
     C    1970

## Example 6: Table with all borders

    $table = new LucidFrame\Console\ConsoleTable();
    $table
        ->setHeaders(array('Language', 'Year'))
        ->addRow(array('PHP', 1994))
        ->addRow(array('C++', 1983))
        ->addRow(array('C', 1970))
        ->showAllBorders()
        ->display()
    ;

Alternatively, you can use `addBorderLine()` for each row.

    $table
        ->setHeaders(array('Language', 'Year'))
        ->addRow(array('PHP', 1994))
        ->addBorderLine()
        ->addRow(array('C++', 1983))
        ->addBorderLine()
        ->addRow(array('C', 1970))
        ->display()
    ;

**Output**

    +----------+------+
    | Language | Year |
    +----------+------+
    | PHP      | 1994 |
    +----------+------+
    | C++      | 1983 |
    +----------+------+
    | C        | 1970 |
    +----------+------+

## Example 7: Table with Column Alignment

    $table = new LucidFrame\Console\ConsoleTable();
    $table
        ->addHeader('A')
        ->addHeader('B', ConsoleTable::ALIGN_RIGHT) # ALIGN_LEFT or ALIGN_RIGHT (ALIGN_LEFT is default)
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

**Output**

    +---+---------------------+------+
    | A |                   B | C    |
    +---+---------------------+------+
    | X |               Hello | Nice |
    | Y | Hello, how are you? |   OK |
    +---+---------------------+------+

## Test

With PHPUnit, you can run this in your terminal.

    composer install
    vendor\bin\phpunit tests

Without PHPUnit, you can simply run this in your terminal.

    php example.php
