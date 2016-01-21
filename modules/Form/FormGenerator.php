<?php
namespace Form;

/**
 *
 * @author tomek
 *
 */
class FormGenerator
{

    /**
     *
     * @var string
     */
    private static $formContent;

    /**
     *
     * @var array
     */
    private static $formElementsArray = array(
        'text' => 'input type="text"',
        'email' => 'input type="email"',
        'password' => 'input type="password"'
    );

    /**
     *
     * @var array
     */
    private static $formItemsArray = array();

    /**
     *
     * @param string $formElementName
     */
    public static function start(string $formElementName)
    {
        self::$formContent = '<' . @self::$formElementsArray[$formElementName];
        self::$formItemsArray = array();
    }

    /**
     *
     * @param string $name
     */
    public static function addName(string $name)
    {
        self::$formContent .= ' name="' . $name . '"';
    }

    /**
     *
     * @param array $itemArray
     */
    public static function addItem(array $itemArray = null)
    {
        $formItemsArray = self::$formItemsArray;
        
        if (! empty($itemArray)) {
            foreach ($itemArray as $key => $item) {
                $formItemsArray[$key] = $item;
            }
        }
        
        self::$formItemsArray = $formItemsArray;
    }

    public static function required()
    {
        self::$formContent .= ' required';
    }

    /**
     *
     * @return string
     */
    public static function render(): string
    {
        self::addItemsToElement();
        return self::$formContent .= '>';
    }

    private static function addItemsToElement()
    {
        $itemArray = array();
        
        foreach (self::$formItemsArray as $key => $value) {
            $itemArray[] = $key . '="' . $value . '"';
        }
        
        self::$formContent .= ' ' . implode(' ', $itemArray);
    }
}
