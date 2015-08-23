<?php namespace Microffice\EloquentUnits;

use Illuminate\Database\Console\Migrations\BaseCommand;
use Symfony\Component\Console\Input\InputOption;

class MigrationCommand extends BaseCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'eloquent-units:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration for the Eloquent Unit Handler package for Microffice Units.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $app = app();
        $app['view']->addNamespace('eloquent-units',substr(__DIR__,0,-8).'views');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->line('');
        $this->info('The migration process will create a migration file and a seeder for the units list');

        $this->line('');
        // We check if the migrations are for unit testing purposes.
        // If it is we skip confirmation.
        if (env('APP_ENV') == 'testing' || $this->confirm("Proceed with the migration creation? [Yes|no]") )
        {
            $this->line('');

            $this->info( "Creating migration and seeder..." );
            if( $this->createMigration( 'units' ) )
            {
                $this->line('');
                
                $this->info( "Migration successfully created!" );
            }
            else{
                $basePath = $this->getBasePath();
                $this->error( 
                    "Coudn't create migration.\n Check the write permissions".
                    " within the " . $basePath . "/migrations directory."
                );
            }

            $this->line('');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('path', 'p', InputOption::VALUE_OPTIONAL, 'Path to the directory where \'migration/\' an \'seed/\' subdirectories reside or have to be created.'),
            array('only-seeder', 'os', InputOption::VALUE_NONE, 'Only create the UnitsSeeder'),
            array('no-seeder', 'ns', InputOption::VALUE_NONE, 'Prevent creation of the UnitsSeeder'),/**/
        );
    }

    /**
     * Create the migration
     *
     * @param  string $name
     * @return bool
     */
    protected function createMigration()
    {
        $app = app();

        // Check which files have to be created
        $migrations = ($this->input->getOption('only-seeder')) ? false : true;
        $seeder = ($this->input->getOption('no-seeder')) ? false : true;

        // Get the base path based on the environment and path option
        $basePath = $this->getBasePath();

        // Check existence and writability off target directories
        $this->checkMigrationsDirectoriesExists($basePath);
        $basePath = realpath($basePath);

        $seconds = 0;

        //Create the migration
        if($migrations)
        {
            $migrationFiles = array(
                $basePath.'/migrations/*_create_units_table.php' => 'eloquent-units::generators.migration'
            );
            foreach ($migrationFiles as $migrationFile => $outputFile) {            
                if (sizeof(glob($migrationFile)) == 0) {
                    $migrationFile = str_replace('*', date('Y_m_d_His', strtotime('+' . $seconds . ' seconds')), $migrationFile);
                    
                    $fs = fopen($migrationFile, 'x');
                    if ($fs) {
                        $output = "<?php\n\n" .$app['view']->make($outputFile)->with(array('table' => 'units'))->render();
                        
                        fwrite($fs, $output);
                        fclose($fs);
                    } else {
                        return false;
                    }

                    $seconds++;
                }
            }   
        }

        //Create the seeder
        if($seeder)
        {
            $seeder_file = $basePath.'/seeds/UnitsSeeder.php';

            $output = "<?php\n\n" .$app['view']->make('eloquent-units::generators.seeder')->render();
            
            $file_option = (file_exists( $seeder_file )) ? 'w' : 'x';

            $fs = fopen($seeder_file, $file_option);
            if ($fs) {
                fwrite($fs, $output);
                fclose($fs);
            } else {
                return false;
            }/**/
        }
        return true;/**/
    }

    /**
     * Get the base path
     *
     * @return string $basePath
     */
    protected function getBasePath()
    {
        // Initialising to default database path
        $basePath = $this->laravel->databasePath();

        if($this->laravel->environment('testing'))
        {
            $basePath = __DIR__ . '/../../tests';
        }
        $basePath .=  ( $this->input->getOption('path') ? '/' . $this->input->getOption('path') : '');

        return $basePath;
    }

    /**
     * Check if "migrations/" and "seeds/" subdirectories exists in $basePath
     * and create them if necessary
     *
     * @param  string $basePath
     * @return void
     */
    protected function checkMigrationsDirectoriesExists($basePath)
    {
        if(! file_exists($basePath."/seeds"))
        {
            mkdir($basePath."/seeds", 0777, true);
        }

        if(! file_exists($basePath."/migrations"))
        {
            mkdir($basePath."/migrations", 0777, true);
        }
    }

}