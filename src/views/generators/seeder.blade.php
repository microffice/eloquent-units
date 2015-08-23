use Illuminate\Database\Seeder;
use Microffice\EloquentUnits\EloquentUnitModel as Unit;

class UnitsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table_name = \Config::get('units.table_name');
        //Empty the units table
        \DB::table($table_name)->delete();
        \DB::statement("ALTER TABLE {$table_name} AUTO_INCREMENT = 1");

        // Fill the units table
        Unit::create(['unit' => 'm']);
    }
}
