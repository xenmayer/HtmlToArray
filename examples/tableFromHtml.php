<?php
/**
 * Test&Example of static method getTableFromHtml()
 */

/**
 * Get html source from tablesorter.com
 */
$html = file_get_contents('http://tablesorter.com/docs/');

require_once ('../HtmlToArray.php');

/**
 * Set HTML source string
 */
HtmlToArray::setHtml($html);

/**
 * Print array of table rows for each table
 */
print_r(HtmlToArray::getArrayOfTr());

/**
 * Print array of table columns for each table
 */
print_r(HtmlToArray::getArrayOfTd(true));

/**
 * Print array of table headers for each table
 */
print_r(HtmlToArray::getArrayOfTh(true));