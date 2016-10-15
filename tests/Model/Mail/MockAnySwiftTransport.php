<?php
namespace Test\Model\Mail;

class MockAnySwiftTransport
{
    public static $array = [];

    public static function newInstance(
        string $serverOrCommand = "",
        int $port = null,
        string $ssl = ""
    ): \Swift_Transport {
    
        $array = [];
        if ($serverOrCommand !== "") {
            $array['serverOrCommand'] = $serverOrCommand;
        }
        if ($port !== null) {
            $array['port'] = $port;
        }
        if ($ssl !== "") {
            $array['ssl'] = $ssl;
        }
        self::$array = $array;
        return \Mockery::mock('alias:\Swift_Transport');
    }
}
