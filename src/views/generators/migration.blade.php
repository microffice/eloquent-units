use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // If there already exist a units table, delete it
        Schema::dropIfExists(\Config::get('units.table_name'));
        
        // Creates the units table
        Schema::create(\Config::get('units.table_name'), function($table)
        {           
            $table->increments('id');
            $table->string('unit', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(\Config::get('units.table_name'));
    }

}