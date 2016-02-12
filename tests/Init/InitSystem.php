<?php
namespace Test\Init;

class InitSystem
{

    public static function getReferData()
    {
        return unserialize(@$_SESSION['systemReferData']);
    }
}
