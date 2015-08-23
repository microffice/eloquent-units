<?php namespace Microffice\EloquentUnits;

use Microffice\Contracts\Units\Unit;
use Microffice\Core\Traits\EloquentModelResourceTrait;

/**
 * EloquentUnitHandler
 *
 */ 

class EloquentUnitHandler implements Unit {
    use EloquentModelResourceTrait;

    public function __construct()
    {
        $this->setModelName('EloquentUnitModel', 'Microffice\EloquentUnits');
    }
}