<?php
namespace Gergely\SlabBackendTeszt;

use Illuminate\Database\Eloquent\Model;

class Fighter extends Model {
    protected $table = 'fighter';
    public $timestamps = false;

    //Vagy az egyik, vagy a masik
    protected $fillable = ['type', 'details', 'level', 'hp', 'attack', 'summon_cost']; //Mit lehet; összetebb szituációkban hasznos
    protected $guarded = ['id']; // Mit nem lehet; egyszerűbb -||-
}