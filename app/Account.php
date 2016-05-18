<?php

namespace App;

class Account extends Container
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'currency', 'deleted_at'];

    /**
     * Calculate current container balance
     * @return float Current balance
     */
    public function getBalanceAttribute()
    {
        return 1024.3;
    }
}