<?php
/**
 * Test&Example of static method getTableFromHtml()
 */

/**
 * Get html source from tablesorter.com
 */
$html = file_get_contents('http://tablesorter.com/docs/');

require_once ('../HtmlToArray.php');

var_dump(HtmlToArray::getTableFromHtml($html));