<?php
namespace Test\Mock;

class MockQueryContent
{

    public static function getContent($return)
    {
        $stub = \Mockery::mock('Content');
        $stub->shouldReceive(array(
            'setContent' => $stub,
            'findBy' => $stub,
            'limit' => $stub,
            'paginate' => $stub,
            'force' => $stub,
            'getContent' => $return
        ));
        return $stub;
    }
}
