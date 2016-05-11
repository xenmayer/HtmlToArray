<?php

/**
 * Class convert html table to array
 */
class HtmlToArray
{
    /**
     * If you want to show parse errors set this
     * constant to false
     *
     * @var bool
     */
    const NOT_SHOW_HTML_PARSE_ERRORS = true;

    /**
     * html charset constant
     *
     * @var string
     */
    const CHARSET = 'UTF-8';

    /**
     * Extra charset constant
     *
     * @var string
     */
    const META_CONTENT_TYPE = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';

    /**
     * Keeps HTML
     *
     * @var string
     */
    private static $html;


    /**
     * Parses html and gives array of tables
     *
     * @param string $html
     * @return array
     */
    public static function setHtml($html = null)
    {
        if (!$html) {
            return array('error' => 'empty $html param');
        }

        self::$html = $html;
    }


    /**
     * Returns array of tables
     *
     * @param bool $get_only_text (optional)
     * @return array
     */
    public static function getArrayOfTables($get_only_text = false)
    {
        if (!self::$html) {
            return array('error' => 'Please call SetHtml()');
        }

        return self::getArrayByXPath(self::$html, '//table', $get_only_text);
    }


    /**
     * Returns array of rows of each table
     *
     * @param bool $get_only_text (optional)
     * @return array
     */
    public static function getArrayOfTr($get_only_text = false)
    {
        if (!self::$html) {
            return array('error' => 'Please call SetHtml()');
        }

        $tables_array = self::getArrayByXPath(self::$html, '//table');

        $out_array = [];
        foreach ($tables_array as $item) {
            $out_array[] = self::getArrayByXPath($item, '//tr', $get_only_text);
        }

        return $out_array;
    }


    /**
     * Returns array of columns of each row
     *
     * @param bool $get_only_text (optional)
     * @return array
     */
    public static function getArrayOfTd($get_only_text = false)
    {
        if (!self::$html) {
            return array('error' => 'Please call SetHtml()');
        }

        $tables_array = self::getArrayByXPath(self::$html, '//table');

        $out_array = [];
        foreach ($tables_array as $key => $item) {
            foreach(self::getArrayByXPath($item, '//tr') as $child_key => $child_item) {
                $parsed_tr = self::getArrayByXPath($child_item, '//td', $get_only_text);
                if (!$parsed_tr ) {
                    continue;
                }
                $out_array[$key][$child_key] = $parsed_tr;
            }
        }

        return $out_array;
    }


    /**
     * Returns array of table headers of each table
     *
     * @param bool $get_only_text (optional)
     * @return array
     */
    public static function getArrayOfTh($get_only_text = false)
    {
        if (!self::$html) {
            return array('error' => 'Please call SetHtml()');
        }

        $tables_array = self::getArrayByXPath(self::$html, '//table');

        $out_array = [];
        foreach ($tables_array as $key => $item) {
            foreach(self::getArrayByXPath($item, '//tr') as $child_key => $child_item) {
                $parsed_th = self::getArrayByXPath($child_item, '//th', $get_only_text);
                if (!$parsed_th ) {
                    continue;
                }
                $out_array[$key][$child_key] = $parsed_th;
            }
        }

        return $out_array;
    }


    /**
     * Parse service
     *
     * @param string $html
     * @param string $x_path_string
     * @param  bool $get_only_text
     * @return array|null
     */
    private static function getArrayByXPath($html = null, $x_path_string = null, $get_only_text = false)
    {
        if (!$html || !$x_path_string) {
            return null;
        }

        /**
         * to prevent show xml, html warnings
         */
        libxml_use_internal_errors(self::NOT_SHOW_HTML_PARSE_ERRORS);

        $dom = new DomDocument('1.0', self::CHARSET);
        $dom->loadHTML(self::META_CONTENT_TYPE . $html);
        $x_path = new DOMXPath($dom);

        $out_array = array();
        foreach ($x_path->query($x_path_string) as $item) {
            if ($get_only_text) {
                $out_array[] = $item->textContent;
                continue;
            }
            $out_array[] = $dom->saveHTML($item);
        }

        return $out_array;
    }
}