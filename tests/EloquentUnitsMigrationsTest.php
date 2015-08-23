<?php namespace Microffice\EloquentUnits\Tests;

class EloquentUnitsMigrationsTest extends EloquentUnitsBaseTest {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
        
        $path = __DIR__.'/migrations';
        $array = iterator_to_array(new \GlobIterator($path.'/*_create_units_table.php', \GlobIterator::CURRENT_AS_PATHNAME));
        // Create migrations if they do not exist and renew seeder everytime
        if(count($array) == 0)
        {
            $this->artisan('eloquent-units:migration');/**/
        }else{
            $this->artisan('eloquent-units:migration', [
                '-os' => null
            ]);/**/
        }/**/
    }

    /**
     * Test running migration.
     *
     * @test
     */
    public function testRunningMigration()
    {
        $this->artisan('migrate', [
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);

        $this->assertTrue(\Schema::hasTable(\Config::get('units.table_name')));

        \Schema::dropIfExists(\Config::get('units.table_name'));
        \Schema::dropIfExists('migrations');/**/
    }

    /**
     * Test running seed.
     *
     * @test
     */
    public function testRunningSeed()
    {
        \Config::set('database.default', 'testbench_mysql');
        $this->artisan('migrate', [
            '--realpath' => realpath(__DIR__.'/migrations')
        ]);
        $this->artisan('db:seed', [
            '--class' => 'UnitsSeeder'
        ]);

        $units = \DB::table(\Config::get('units.table_name'))->where('id', '=', 1)->first();
        $this->assertEquals('m', $units->unit);

        \Schema::dropIfExists(\Config::get('units.table_name'));
        \Schema::dropIfExists('migrations');/**/
    }

}
