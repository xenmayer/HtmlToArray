# HtmlToArray
Easy DomDocument wrapper with conversion methods.

### Initialize

```php
require_once ('HtmlToArray.php');
HtmlToArray::setHtml($html);
```

### Public methods
```php
/**
 * Returns array of tables
 *
 * @param bool $get_only_text (optional)
 * @return array
 */
getArrayOfTables($get_only_text = false);


/**
 * Returns array of rows of each table
 *
 * @param bool $get_only_text (optional)
 * @return array
 */
getArrayOfTr($get_only_text = false);


/**
 * Returns array of table columns of each row
 *
 * @param bool $get_only_text (optional)
 * @return array
 */
getArrayOfTd($get_only_text = false)


/**
 * Returns array of table headers of each table
 *
 * @param bool $get_only_text (optional)
 * @return array
 */
getArrayOfTh($get_only_text = false)
```