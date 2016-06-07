<?php

namespace App;

use App\Factories\Carbon;

class Account extends Container
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'currency_id', 'deleted_at'];

    /**
     * Get the currency for the account.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the revenues for the account.
     */
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }

    /**
     * Get the outcomes for the account.
     */
    public function outcomes()
    {
        return $this->hasMany(Outcome::class);
    }

    /**
     * Get the incoming transfers for the account.
     */
    public function incomingTransfers()
    {
        return $this->hasMany(Transfer::class, 'to_account_id');
    }

    /**
     * Get the outgoing transfers for the account.
     */
    public function outgoingTransfers()
    {
        return $this->hasMany(Transfer::class, 'from_account_id');
    }

    /**
     * Calculate account balance at the given date
     * @return float Account balance
     */
    public function getBalanceAttribute(Currency $currency, $date = null)
    {
        $revenues = $this->getRevenuesAttribute($currency, null, $date);
        $outcomes = $this->getOutcomesAttribute($currency, null, $date);
        $incomingTransfers = $this->getIncomingTransfersAttribute($currency, null, $date);
        $outgoingTransfers = $this->getOutgoingTransfersAttribute($currency, null, $date);

        return round($revenues + $incomingTransfers - $outcomes - $outgoingTransfers, 2);
    }

    /**
     * Calculate account revenues for the given period
     * @return float Account revenues
     */
    public function getRevenuesAttribute(Currency $currency, $dateFrom = null, $dateTo = null)
    {
        $query = $this->revenues();

        if ($dateFrom && $dateTo) {
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        } else if ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        } else if ($dateTo) {
            $query->where(function ($query) use($dateTo) {
                $query->where('date', '<=', $dateTo);
                $query->orWhere('date', null);
            });
        }

        return $query->sumConvertedTo($currency)->get()[0]['converted_total'];
    }

    /**
     * Calculate account outcomes for the given period
     * @return float Account outcomes
     */
    public function getOutcomesAttribute(Currency $currency, $dateFrom = null, $dateTo = null)
    {
        $query = $this->outcomes()
            ->select(app('db')->raw('SUM(amount) as total'));

        if ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('date', '<=', $dateTo);
        }

        return floatval($query->get()[0]['total']);
    }

    /**
     * Calculate account incoming tranfers for the given period
     * @return float Account incoming transfers
     */
    public function getIncomingTransfersAttribute(Currency $currency, $dateFrom = null, $dateTo = null)
    {
        $query = $this->incomingTransfers()
            ->select(app('db')->raw('SUM(amount) as total'));

        if ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('date', '<=', $dateTo);
        }

        return floatval($query->get()[0]['total']);
    }

    /**
     * Calculate account outgoing tranfers for the given period
     * @return float Account outgoing transfers
     */
    public function getOutgoingTransfersAttribute(Currency $currency, $dateFrom = null, $dateTo = null)
    {
        $query = $this->outgoingTransfers()
            ->select(app('db')->raw('SUM(amount) as total'));

        if ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('date', '<=', $dateTo);
        }

        return floatval($query->get()[0]['total']);
    }

    /**
     * Calculate main account metrics for the given day
     * @return array Account metrics
     */
    public function getDailySnapshotAttribute($date = null)
    {
        $date = Carbon::startOfDay($date);

        return [
            'balance' => $this->getBalanceAttribute($date),
            'revenues' => $this->getRevenuesAttribute($date, $date),
            'outcomes' => $this->getOutcomesAttribute($date, $date),
            'incomingTransfers' => $this->getIncomingTransfersAttribute($date, $date),
            'outgoingTransfers' => $this->getOutgoingTransfersAttribute($date, $date),
        ];
    }

    /**
     * Calculate account main metrics for the given month
     * @return array Account metrics
     */
    public function getMonthlySnapshotAttribute($date = null)
    {
        $dateFrom = Carbon::startOfMonth($date);
        $dateTo = Carbon::endOfMonth($date);

        return [
            'balance' => $this->getBalanceAttribute($dateTo),
            'revenues' => $this->getRevenuesAttribute($dateFrom, $dateTo),
            'outcomes' => $this->getOutcomesAttribute($dateFrom, $dateTo),
            'incomingTransfers' => $this->getIncomingTransfersAttribute($dateFrom, $dateTo),
            'outgoingTransfers' => $this->getOutgoingTransfersAttribute($dateFrom, $dateTo),
        ];
    }
}
