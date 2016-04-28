<?php

/**
 * Class convert html table to array
 */
class HtmlToArray
{
    /**
     * If you want to show parse errors set this
     * param to false
     * @var bool
     */
    const NOT_SHOW_HTML_PARSE_ERRORS = true;


    /**
     * Method get HTML and return array of tables
     * @param null $html
     * @return array
     */
    public static function getTableFromHtml($html = null)
    {
        if (!html) {
            return array('error' => 'empty $html param');
        }

        /**
         * to prevent show xml, html warnings
         */
        libxml_use_internal_errors(self::NOT_SHOW_HTML_PARSE_ERRORS);

        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $html);
        $xPath = new DOMXPath($dom);

        $tableArray = array();
        foreach ($xPath->query('//table') as $tableItem) {
            $tableArray[] = $dom->saveHTML($tableItem);
        }

        return $tableArray;
    }
}