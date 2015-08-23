<?php namespace Microffice\EloquentUnits\Tests;

use Microffice\EloquentUnits\MigrationCommand;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Tester\CommandTester;

class EloquentUnitsMigrationCommandTest extends EloquentUnitsBaseTest {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * Tear the test environment down.
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test checkMigrationsDirectoriesExists.
     *
     * @test
     */
    public function testCheckMigrationsDirectoriesExists()
    {
        $path = __DIR__."/pathForUnittesting";

        $object = new \Microffice\EloquentUnits\MigrationCommand();
        $method = $this->getPrivateMethod( 'Microffice\EloquentUnits\MigrationCommand', 'checkMigrationsDirectoriesExists');

        $result = $method->invokeArgs( $object, array( $path ) );

        $this->assertTrue(file_exists($path));

        if(file_exists($path))
        {
            $this->emptyDirectory($path);
            rmdir($path);
        }/**/
    }

    /**
     * Test running migration with --path option flag.
     *
     * @test
     */
    public function testRunningCommandWithPathOption()
    {
        $basePath = 'dummy';

        $this->artisan('eloquent-units:migration', [
            '-p'  => $basePath,
        ]);

        $dbPath = __DIR__;

        $path = $dbPath . '/' . $basePath . '/seeds';
        $this->assertTrue(file_exists($path.'/UnitsSeeder.php'));
        $this->emptyDirectory($path);
        rmdir($path);

        $path = $dbPath .'/'.$basePath.'/migrations';
        $array = iterator_to_array(new \GlobIterator($path.'/*_create_units_table.php', \GlobIterator::CURRENT_AS_PATHNAME));
        $this->assertNotEmpty($array);
        $this->emptyDirectory($path);
        rmdir($path);

        rmdir($dbPath.'/'.$basePath);/**/
    }

    /**
     * Test running migration with --no-seeder option flag.
     *
     * @test
     */
    public function testRunningCommandWithNoSeederOption()
    {
        $basePath = 'dummy';;
        $this->artisan('eloquent-units:migration', [
            '-ns'  => null,
            '-p'   => $basePath
        ]);

        $path = __DIR__ . "/$basePath/migrations";
        $array = iterator_to_array(new \GlobIterator($path.'/*_create_units_table.php', \GlobIterator::CURRENT_AS_PATHNAME));
        $this->assertNotEmpty($array);
        $this->emptyDirectory($path);
        rmdir($path);

        $this->emptyDirectory(__DIR__ . '/' . $basePath);
        rmdir(__DIR__ . '/' . $basePath);/**/
    }

    /**
     * Test running migration with --only-seeder option flag.
     *
     * @test
     */
    public function testRunningCommandWithOnlySeederOption()
    {
        $basePath = 'dummy';;
        $this->artisan('eloquent-units:migration', [
            '-os'  => null,
            '-p'   => $basePath
        ]);

        $path = __DIR__ . "/$basePath/seeds";
        $this->assertTrue(file_exists($path.'/UnitsSeeder.php'));
        $this->emptyDirectory($path);
        rmdir($path);

        $this->emptyDirectory(__DIR__ . '/' . $basePath);
        rmdir(__DIR__ . '/' . $basePath);/**/
    }
}
