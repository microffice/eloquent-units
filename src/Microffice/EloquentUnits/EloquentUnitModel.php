<?php namespace Microffice\EloquentUnits;

use Illuminate\Database\Eloquent\Model;

/**
 * EloquentUnitModel
 *
 */ 

class EloquentUnitModel extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['unit'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Indicates if te model should be timestamped
     *
     * @var bool
     */
    public $timestamps = true;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->table = \Config::get('units.table_name');
    }

}