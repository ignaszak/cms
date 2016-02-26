<?php
namespace Form;

class Message
{

    /**
     *
     * @var array
     */
    private $errorArray = [];

    /**
     *
     * @var string[]
     */
    private $pattern = [
        'valid'  => "Inccorect %s.",
        'unique' => "%s already exists.",
        'find'   => "%s not found."
    ];

    /**
     *
     * @param Form $_form
     */
    public function __construct(Form $_form)
    {
        $this->errorArray = $_form->getFormResponseData('error');
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        $array = [];
        if (is_array($this->errorArray)) {
            foreach ($this->errorArray as $error => $value) {
                $m = [];
                preg_match("/^([a-z]*)([A-Z][a-z_]*)$/", $error, $m);
                if (array_key_exists(1, $m) && array_key_exists(2, $m)) {
                    $array[] = ucfirst(
                        sprintf(
                            $this->pattern[$m[1]],
                            str_replace('_', ' ', strtolower($m[2]))
                        )
                    );
                }
            }
        }
        return implode('<br />', $array);
    }
}
