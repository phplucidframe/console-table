<?php
/**
 * This file is part of the PHPLucidFrame library.
 * The class makes you easy to build console style tables
 *
 * @package     PHPLucidFrame\Console
 * @since       PHPLucidFrame v 1.12.0
 * @copyright   Copyright (c), PHPLucidFrame.
 * @author      Sithu <sithu@phplucidframe.com>
 * @link        http://phplucidframe.com
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE
 */

namespace LucidFrame\Console;

/**
 * The class makes you easy to build console style tables
 */
class ConsoleTable
{
    const HEADER_INDEX = -1;
    const FOOTER_INDEX = -2;
    const HR = 'HR';

    const ALIGN_LEFT = 'left';
    const ALIGN_RIGHT = 'right';

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
    /** @var int */
    private $maxColumnCount = 0;
    /** @var array */
    private $headerColumnAligns = [];
    /** @var array */
    private $columnAligns = [];
    /** @var array */
    private $footerColumnAligns = [];

    /**
     * Add a column to the table header
     * @param  mixed $content Header cell content
     * @param  string $align The text alignment ('left' or 'right')
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addHeader($content = '', $align = self::ALIGN_LEFT)
    {
        $this->data[self::HEADER_INDEX][] = $content;
        $this->headerColumnAligns[self::HEADER_INDEX][] = $align === self::ALIGN_RIGHT ? STR_PAD_LEFT : STR_PAD_RIGHT;

        return $this;
    }

    /**
     * Set headers for the columns in one-line
     * @param  array $content Array of header cell content
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
        return $this->data[self::HEADER_INDEX] ?? null;
    }

    /**
     * Adds a row to the table
     * @param array|null $data The row data to add
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addRow(?array $data = null)
    {
        $this->rowIndex++;

        if (is_array($data)) {
            foreach ($data as $col => $content) {
                $this->data[$this->rowIndex][$col] = $content;
            }

            $this->setMaxColumnCount(count($this->data[$this->rowIndex]));
        }

        return $this;
    }

    /**
     * Adds a column to the table
     * @param  mixed    $content The data of the column
     * @param  integer  $col     The column index to populate
     * @param  integer  $row     If starting row is not zero, specify it here
     * @param  string   $align   The text alignment ('left' or 'right')
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addColumn($content, $col = null, $row = null, $align = self::ALIGN_LEFT)
    {
        $row = $row ?? $this->rowIndex;
        if ($col === null) {
            $col = isset($this->data[$row]) ? count($this->data[$row]) : 0;
        }

        $this->data[$row][$col] = $content;
        $this->setMaxColumnCount(count($this->data[$row]));

        // Set column alignment if specified
        if (!isset($this->columnAligns[$col]) && $align === self::ALIGN_RIGHT) {
            $this->columnAligns[$col] = STR_PAD_LEFT;
        }

        return $this;
    }

    /**
     * Set alignment for a specific column
     * @param  integer $col   The column index
     * @param  string  $align The alignment ('left' or 'right')
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function setColumnAlign($col, $align = self::ALIGN_LEFT)
    {
        $this->columnAligns[$col] = $align === self::ALIGN_RIGHT ? STR_PAD_LEFT : STR_PAD_RIGHT;

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
     * Add horizontal borderline
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addBorderLine()
    {
        $this->rowIndex++;
        $this->data[$this->rowIndex] = self::HR;

        return $this;
    }

    /**
     * Add a column to the table footer
     * @param  mixed $content Footer cell content
     * @param  string $align The text alignment ('left' or 'right')
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function addFooter($content = '', $align = self::ALIGN_LEFT)
    {
        $this->data[self::FOOTER_INDEX][] = $content;
        $this->footerColumnAligns[self::FOOTER_INDEX][] = $align === self::ALIGN_RIGHT ? STR_PAD_LEFT : STR_PAD_RIGHT;

        return $this;
    }

    /**
     * Set footers for the columns in one-line
     * @param  array $content Array of footer cell content
     * @return object LucidFrame\Console\ConsoleTable
     */
    public function setFooters(array $content)
    {
        $this->data[self::FOOTER_INDEX] = $content;

        return $this;
    }

    /**
     * Get the row of footer
     */
    public function getFooters()
    {
        return $this->data[self::FOOTER_INDEX] ?? null;
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
            if ($y === self::FOOTER_INDEX) {
                continue; // Skip footer here, we'll add it at the end
            }

            if ($row === self::HR) {
                if (!$this->allBorders) {
                    $output .= $this->getBorderLine();
                    unset($this->data[$y]);
                }

                continue;
            }

            if ($y === self::HEADER_INDEX && count($row) < $this->maxColumnCount) {
                $row += array_fill(count($row), $this->maxColumnCount - count($row), ' ');
            }

            foreach ($row as $x => $cell) {
                $output .= $this->getCellOutput($x, $y, $row);
            }
            $output .= PHP_EOL;

            if ($y === self::HEADER_INDEX) {
                $output .= $this->getBorderLine();
            } else if ($this->allBorders) {
                $output .= $this->getBorderLine();
            }
        }

        // Add footer if exists
        if (isset($this->data[self::FOOTER_INDEX])) {
            if (!$this->allBorders) {
                $output .= $this->getBorderLine();
            }

            $row = $this->data[self::FOOTER_INDEX];
            if (count($row) < $this->maxColumnCount) {
                $row += array_fill(count($row), $this->maxColumnCount - count($row), ' ');
            }

            foreach ($row as $x => $cell) {
                $output .= $this->getCellOutput($x, self::FOOTER_INDEX, $row);
            }
            $output .= PHP_EOL;
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
     * Get the printable borderline
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
     * @param int $colIndex The column index
     * @param int $rowIndex The row index
     * @param array $row   The table row
     * @return string
     */
    private function getCellOutput($colIndex, $rowIndex = null, $row = [])
    {
        $cell = $row ? $row[$colIndex] : '-';
        $padding = str_repeat($row ? ' ' : '-', $this->padding);
        $output = '';

        if ($colIndex === 0) {
            $output .= str_repeat(' ', $this->indent);
        }

        if ($this->border) {
            $output .= $row ? '|' : '+';
        }

        $output .= $padding; # left padding

        // Apply column alignment
        if ($rowIndex === self::HEADER_INDEX) {
            $alignment = $this->headerColumnAligns[$rowIndex][$colIndex] ?? STR_PAD_RIGHT;
        } elseif ($rowIndex === self::FOOTER_INDEX) {
            $alignment = $this->footerColumnAligns[$rowIndex][$colIndex] ?? STR_PAD_RIGHT;
        } else {
            $alignment = $this->columnAligns[$colIndex] ?? STR_PAD_RIGHT;
        }

        $output .= $this->strPadUnicode($cell, $this->getVisualWidth($colIndex, $cell), $row ? ' ' : '-', $alignment); # cell content
        $output .= $padding; # right padding
        if ($colIndex === count($row) - 1 && $this->border) {
            $output .= $row ? '|' : '+';
        }

        return $output;
    }

    /**
     * Get the visual width of the cell after the removal of invisible ANSI sequences.
     *
     * @param int $index The column index
     * @param string $content The cell content
     * @return int|mixed
     */
    private function getVisualWidth($index, $content)
    {
        $colWidth = $this->columnWidths[$index];
        # removes line breaks, tabs, and extra spaces
        $cell = trim(preg_replace('/\s+/', ' ', $content));
        # removes ANSI escape sequences (commonly used for terminal text color and formatting)
        $cleanContent = $this->clearTextFormatting($cell);

        $originalContentLen = mb_strlen($cell, 'UTF-8');
        $cleanContentLen = mb_strlen($cleanContent, 'UTF-8');

        # calculate the number of characters removed (i.e., length of the ANSI sequences).
        $delta = $originalContentLen - $cleanContentLen;

        return $colWidth + $delta - $this->countEmojis($cleanContent);
    }

    /**
     * Calculate maximum width of each column
     * @return array
     */
    private function calculateColumnWidth()
    {
        $maxEmojiCount = [];

        foreach ($this->data as $row) {
            if (!is_array($row)) {
                continue;
            }

            foreach ($row as $x => $cell) {
                $content = $this->clearTextFormatting($cell);
                $emojiCount = $this->countEmojis($content);
                if (!isset($maxEmojiCount[$x])) {
                    $maxEmojiCount[$x] = $emojiCount;
                } elseif ($emojiCount > $maxEmojiCount[$x]) {
                    $maxEmojiCount[$x] = $emojiCount;
                }
            }
        }

        foreach ($this->data as $row) {
            if (is_array($row)) {
                foreach ($row as $x => $cell) {
                    $content = $this->clearTextFormatting($cell);
                    $textLength = mb_strlen($content, 'UTF-8');
                    $colWidth = $textLength + $maxEmojiCount[$x];

                    if (!isset($this->columnWidths[$x])) {
                        $this->columnWidths[$x] = $colWidth;
                    } else {
                        if ($colWidth > $this->columnWidths[$x]) {
                            $this->columnWidths[$x] = $colWidth;
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

    /**
     * Set max column count
     * @param int $count The column count
     */
    private function setMaxColumnCount($count)
    {
        if ($count > $this->maxColumnCount) {
            $this->maxColumnCount = $count;
        }
    }

    /**
     * Remove ANSI escape codes (which are often used for terminal formatting) for plain text processing
     * ANSI escape codes are often used to control text formatting in terminals (e.g., colors, boldness).
     *
     * @param string $content The cell content
     * @return array|string|string[]|null
     */
    private function clearTextFormatting($content)
    {
        return preg_replace('#\x1b[[][^A-Za-z]*[A-Za-z]#', '', $content);
    }

    /**
     * Detect and count emojis from text
     * @param string $text
     * @return int
     */
    private function countEmojis($text)
    {
        $emojiPattern = '([*#0-9](?>\\xEF\\xB8\\x8F)?\\xE2\\x83\\xA3|\\xC2[\\xA9\\xAE]|\\xE2..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?(?>\\xEF\\xB8\\x8F)?|\\xE3(?>\\x80[\\xB0\\xBD]|\\x8A[\\x97\\x99])(?>\\xEF\\xB8\\x8F)?|\\xF0\\x9F(?>[\\x80-\\x86].(?>\\xEF\\xB8\\x8F)?|\\x87.\\xF0\\x9F\\x87.|..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?|(((?<zwj>\\xE2\\x80\\x8D)\\xE2\\x9D\\xA4\\xEF\\xB8\\x8F\k<zwj>\\xF0\\x9F..(\k<zwj>\\xF0\\x9F\\x91.)?|(\\xE2\\x80\\x8D\\xF0\\x9F\\x91.){2,3}))?))';

        preg_match_all($emojiPattern, $text, $matches);

        return count($matches[0]);
    }
}
