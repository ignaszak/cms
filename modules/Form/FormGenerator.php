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
     * @var string[]
     */
    private static $formElementsArray = [
        'text' => 'input type="text"',
        'email' => 'input type="email"',
        'password' => 'input type="password"'
    ];

    /**
     *
     * @var string[]
     */
    private static $formItemsArray = [];

    /**
     *
     * @param string $formElementName
     */
    public static function start(string $formElementName)
    {
        self::$formContent = '<' . @self::$formElementsArray[$formElementName];
        self::$formItemsArray = [];
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
        $itemArray = [];

        foreach (self::$formItemsArray as $key => $value) {
            $itemArray[] = $key . '="' . $value . '"';
        }

        self::$formContent .= ' ' . implode(' ', $itemArray);
    }
}
