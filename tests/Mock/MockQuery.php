<?php
namespace Test\Mock;

class MockQuery
{

    public static function getQuery($return)
    {
        $stub = \Mockery::mock('Query');
        $stub->shouldReceive([
            'setQuery' => $stub,
            'findBy' => $stub,
            'limit' => $stub,
            'paginate' => $stub,
            'force' => $stub,
            'getQuery' => $return,
            'getStaticQuery' => $return
        ]);
        return $stub;
    }
}
