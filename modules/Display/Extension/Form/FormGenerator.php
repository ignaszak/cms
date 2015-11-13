<?php

namespace Display\Extension\Form;

/**
 *
 * @author tomek
 *
 */
class FormGenerator
{

    private static $formContent;

    private static $formElementsArray = array(
        'text'      => 'input type="text"',
        'email'     => 'input type="email"',
        'password'  => 'input type="password"'
    );

    private static $formItemsArray = array();

    public static function start($formElementName)
    {
        self::$formContent = '<' . self::returnElementFromName($formElementName);
        self::$formItemsArray = array();
    }

    private static function returnElementFromName($name)
    {
        return self::$formElementsArray[$name];
    }

    public static function addName($name)
    {
        self::$formContent .= ' name="' . $name . '"';
    }

    public static function addItem(array $itemArray = null)
    {
        $formItemsArray = self::$formItemsArray;

        if (!empty($itemArray)) {
            foreach ($itemArray as $key=>$item) {
                $formItemsArray[$key] = $item;
            }
        }

        self::$formItemsArray = $formItemsArray;
    }

    public static function required()
    {
        self::$formContent .= ' required';
    }

    public static function render()
    {
        self::addItemsToElement();
        return self::$formContent .= '>';
    }

    private static function addItemsToElement()
    {
        $itemArray = array();

        foreach (self::$formItemsArray as $key=>$value) {
            $itemArray[] = $key . '="' . $value . '"';
        }

        self::$formContent .= ' ' . implode(' ', $itemArray);
    }
}
