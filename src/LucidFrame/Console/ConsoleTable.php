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
    const HR = 'HR';

    /** @var array Array of table data */
    protected $data = array();
    /** @var boolean Border shown or not */
    protected $border = true;
    /** @var boolean All borders shown or not */
    protected $allBorders = false;
    /** @var integer Table padding */
    protected $padding = 1;
    /** @var integer Table left margin */
    protected $indent = 0;
    /** @var integer */
    private $rowIndex = -1;
    /** @var array */
    private $columnWidths = array();

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
     * Set headers for the columns in one-line
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
    public function addRow(array $data = null)
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
     * Show all table borders
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function showAllBorders()
    {
        $this->showBorder();
        $this->allBorders = true;

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
     * Add horizontal border line
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addBorderLine()
    {
        $this->rowIndex++;
        $this->data[$this->rowIndex] = self::HR;

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
            if ($row === self::HR) {
                if (!$this->allBorders) {
                    $output .= $this->getBorderLine();
                    unset($this->data[$y]);
                }

                continue;
            }

            foreach ($row as $x => $cell) {
                $output .= $this->getCellOutput($x, $row);
            }
            $output .= PHP_EOL;

            if ($y === self::HEADER_INDEX) {
                $output .= $this->getBorderLine();
            } else {
                if ($this->allBorders) {
                    $output .= $this->getBorderLine();
                }
            }
        }

        if (!$this->allBorders) {
            $output .= $this->border ? $this->getBorderLine() : '';
        }

        if (PHP_SAPI !== 'cli') {
            $output = '<pre>'.$output.'</pre>';
        }

        return $output;
    }

    /**
     * Get the printable border line
     * @return string
     */
    private function getBorderLine()
    {
        $output = '';

        if (isset($this->data[0])) {
            $columnCount = count($this->data[0]);
        } elseif (isset($this->data[self::HEADER_INDEX])) {
            $columnCount = count($this->data[self::HEADER_INDEX]);
        } else {
            return $output;
        }

        for ($col = 0; $col < $columnCount; $col++) {
            $output .= $this->getCellOutput($col);
        }

        if ($this->border) {
            $output .= '+';
        }
        $output .= PHP_EOL;

        return $output;
    }

    /**
     * Get the printable cell content
     *
     * @param integer $index The column index
     * @param array   $row   The table row
     * @return string
     */
    private function getCellOutput($index, $row = null)
    {
        $cell       = $row ? $row[$index] : '-';
        $width      = $this->columnWidths[$index];
        $pad        = $row ? $width - mb_strlen($cell, 'UTF-8') : $width;
        $padding    = str_repeat($row ? ' ' : '-', $this->padding);

        $output = '';

        if ($index === 0) {
            $output .= str_repeat(' ', $this->indent);
        }

        if ($this->border) {
            $output .= $row ? '|' : '+';
        }

        $output .= $padding; # left padding
        $cell    = trim(preg_replace('/\s+/', ' ', $cell)); # remove line breaks
        $content = preg_replace('#\x1b[[][^A-Za-z]*[A-Za-z]#', '', $cell);
        $delta   = mb_strlen($cell, 'UTF-8') - mb_strlen($content, 'UTF-8');
        $output .= $this->strPadUnicode($cell, $width + $delta, $row ? ' ' : '-'); # cell content
        $output .= $padding; # right padding
        if ($row && $index == count($row) - 1 && $this->border) {
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
            if (is_array($row)) {
                foreach ($row as $x => $col) {
                    $content = preg_replace('#\x1b[[][^A-Za-z]*[A-Za-z]#', '', $col);
                    if (!isset($this->columnWidths[$x])) {
                        $this->columnWidths[$x] = mb_strlen($content, 'UTF-8');
                    } else {
                        if (mb_strlen($content, 'UTF-8') > $this->columnWidths[$x]) {
                            $this->columnWidths[$x] = mb_strlen($content, 'UTF-8');
                        }
                    }
                }
            }
        }

        return $this->columnWidths;
    }

    /**
     * Multibyte version of str_pad() function
     * @source http://php.net/manual/en/function.str-pad.php
     */
    private function strPadUnicode($str, $padLength, $padString = ' ', $dir = STR_PAD_RIGHT)
    {
        $strLen     = mb_strlen($str, 'UTF-8');
        $padStrLen  = mb_strlen($padString, 'UTF-8');

        if (!$strLen && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
            $strLen = 1;
        }

        if (!$padLength || !$padStrLen || $padLength <= $strLen) {
            return $str;
        }

        $result = null;
        $repeat = ceil($strLen - $padStrLen + $padLength);
        if ($dir == STR_PAD_RIGHT) {
            $result = $str . str_repeat($padString, $repeat);
            $result = mb_substr($result, 0, $padLength, 'UTF-8');
        } elseif ($dir == STR_PAD_LEFT) {
            $result = str_repeat($padString, $repeat) . $str;
            $result = mb_substr($result, -$padLength, null, 'UTF-8');
        } elseif ($dir == STR_PAD_BOTH) {
            $length = ($padLength - $strLen) / 2;
            $repeat = ceil($length / $padStrLen);
            $result = mb_substr(str_repeat($padString, $repeat), 0, floor($length), 'UTF-8')
                . $str
                . mb_substr(str_repeat($padString, $repeat), 0, ceil($length), 'UTF-8');
        }

        return $result;
    }
}
