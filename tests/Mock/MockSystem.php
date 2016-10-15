<?php
namespace Test\Mock;

class MockSystem
{

    public static function getReferData()
    {
        return unserialize(@$_SESSION['systemReferData']);
    }
}
