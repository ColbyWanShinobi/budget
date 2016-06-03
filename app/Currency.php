<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the accounts for the currency.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
