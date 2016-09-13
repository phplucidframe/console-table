<?php
/**
 * This file is part of the PHPLucidFrame library.
 * The class makes you easy to build console style tables
 *
 * @package     PHPLucidFrame\Console
 * @since       PHPLucidFrame v 1.12.0
 * @copyright   Copyright (c), PHPLucidFrame.
 * @author      Sithu K. <cithukyaw@gmail.com>
 * @link        http://phplucidframe.github.io
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE
 */

namespace LucidFrame\Console;

class ConsoleTable
{
    const HEADER_INDEX = -1;

    /** @var array Array of table data **/
    protected $data = array();
    /** @var boolean Border shown or not **/
    protected $border = true;
    /** @var integer Table padding **/
    protected $padding = 1;
    /** @var integer Table left margin **/
    protected $indent = 0;
    /** @var integer **/
    private $rowIndex = -1;
    /** @var array **/
    private $columnWidths = array();

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Adds a column to the table header
     * @param  mixed  Header cell content
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addHeader($content = '')
    {
        $this->data[self::HEADER_INDEX][] = $content;

        return $this;
    }

    /**
     * Adds the headers for the columns
     * @param  array  Array of header cell content
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function setHeaders(array $content)
    {
        $this->data[self::HEADER_INDEX] = $content;

        return $this;
    }

    /**
     * Get the row of header
     */
    public function getHeaders()
    {
        return isset($this->data[self::HEADER_INDEX]) ? $this->data[self::HEADER_INDEX] : null;
    }

    /**
     * Adds a row to the table
     * @param  array  $data The row data to add
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addRow($data = null)
    {
        $this->rowIndex++;

        if (is_array($data)) {
            foreach ($data as $col => $content) {
                $this->data[$this->rowIndex][$col] = $content;
            }
        }

        return $this;
    }

    /**
     * Adds a column to the table
     * @param  mixed    $content The data of the column
     * @param  integer  $col     The column index to populate
     * @param  integer  $row     If starting row is not zero, specify it here
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addColumn($content, $col = null, $row = null)
    {
        $row = $row === null ? $this->rowIndex : $row;
        if ($col === null) {
            $col = isset($this->data[$row]) ? count($this->data[$row]) : 0;
        }

        $this->data[$row][$col] = $content;

        return $this;
    }

    /**
     * Show table border
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function showBorder()
    {
        $this->border = true;

        return $this;
    }

    /**
     * Hide table border
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function hideBorder()
    {
        $this->border = false;

        return $this;
    }

    /**
     * Set padding for each cell
     * @param  integer $value The integer value, defaults to 1
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function setPadding($value = 1)
    {
        $this->padding = $value;

        return $this;
    }

    /**
     * Set left indentation for the table
     * @param  integer $value The integer value, defaults to 1
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function setIndent($value = 0)
    {
        $this->indent = $value;

        return $this;
    }

    /**
     * Print the table
     * @return void
     */
    public function display()
    {
        echo $this->getTable();
    }

    /**
     * Get the printable table content
     * @return string
     */
    public function getTable()
    {
        $this->calculateColumnWidth();

        $output = $this->border ? $this->getBorderLine() : '';
        foreach ($this->data as $y => $row) {
            foreach ($row as $x => $cell) {
                $output .= $this->getCellOutput($x, $row);
            }
            $output .= "\n";

            if ($y === self::HEADER_INDEX) {
                $output .= $this->getBorderLine();
            }
        }
        $output .= $this->border ? $this->getBorderLine() : '';

        return $output;
    }

    /**
     * Get the printable border line
     * @return string
     */
    private function getBorderLine()
    {
        $output = '';
        $columnCount = count($this->data[0]);
        for ($col = 0; $col < $columnCount; $col++) {
            $output .= $this->getCellOutput($col);
        }

        if ($this->border) {
            $output .= '+';
        }
        $output .= "\n";

        return $output;
    }

    /**
     * Get the printable cell content
     * @param integer $index The column index
     * @param array   $row   The table row
     * @return string
     */
    private function getCellOutput($index, $row = null)
    {
        $cell       = $row ? $row[$index] : '-';
        $width      = $this->columnWidths[$index];
        $pad        = $row ? $width - strlen($cell) : $width;
        $padding    = str_repeat($row ? ' ' : '-', $this->padding);

        $output = '';

        if ($index === 0) {
            $output .= str_repeat(' ', $this->indent);
        }

        if ($this->border) {
            $output .= $row ? '|' : '+';
        }

        $output .= $padding; # left padding
        $output .= str_pad($cell, $width, $row ? ' ' : '-'); # cell content
        $output .= $padding; # right padding
        if ($index == count($row)-1 && $this->border) {
            $output .= $row ? '|' : '+';
        }

        return $output;
    }

    /**
     * Calculate maximum width of each column
     * @return array
     */
    private function calculateColumnWidth()
    {
        foreach ($this->data as $y => $row) {
            foreach ($row as $x => $col) {
                if (!isset($this->columnWidths[$x])) {
                    $this->columnWidths[$x] = strlen($col);
                } else {
                    if (strlen($col) > $this->columnWidths[$x]) {
                        $this->columnWidths[$x] = strlen($col);
                    }
                }
            }
        }

        return $this->columnWidths;
    }
}
