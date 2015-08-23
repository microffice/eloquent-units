<?php namespace Microffice\EloquentUnits\Tests;

class EloquentUnitHandlerTest extends EloquentUnitsBaseTest {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
        
        /*$path = __DIR__.'/migrations';
        $array = iterator_to_array(new \GlobIterator($path.'/*_create_units_table.php', \GlobIterator::CURRENT_AS_PATHNAME));
        // Create migrations if they do not exist and renew seeder everytime
        if(count($array) == 0)
        {
            $this->artisan('eloquent-units:migration');
        }else{
            $this->artisan('eloquent-units:migration', [
                '-os' => null
            ]);
        }/**/
    }

    /**
     * Test .
     *
     * @test
     */
    public function test()
    {
        
    }
}
