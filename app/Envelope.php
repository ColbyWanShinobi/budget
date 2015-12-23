<?php

namespace App;

use App\Collections\OperationCollection;
use App\Services\Eloquent\HasEvents;
use Html;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Envelope belonging to an account
 * @property integer $id
 * @property string $name
 * @property float $default_income
 * @property string $icon
 * @property App\Account $account
 */
class Envelope extends Model
{
    use SoftDeletes;
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'default_income', 'icon'];

    /**
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'default_income' => 'float',
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Array of field name to watch for changed on updated event
     * @var array
     */
    protected $watchedFieldInEvent = [
        'name',
        'default_income',
        'icon',
    ];

    /**
     * Convert the model to its string representation.
     * @return string
     */
    public function __toString()
    {
        if ($this->icon) {
            return '<i class="fa fa-fw '.$this->icon.'" title="'.$this->name.'"></i> '.$this->name;
        }

        return $this->name;
    }

    /**
     * Get a link to the envelope page
     * @param  string|null $text Override link text
     * @param  array  $moreAttributes Additional html attributes
     * @return string HTML anchor
     */
    public function link($text = null, $moreAttributes = []) {
        $attributes = ['class' => 'routable', 'data-target' => '#page-wrapper'];

        if (is_null($text)) {
            $text = $this;
        }

        foreach ($moreAttributes as $key => $value) {
            if (isset($attributes[$key])) {
                $attributes[$key] .= ' '.$moreAttributes[$key];
            } else {
                $attributes[$key] = $moreAttributes[$key];
            }
        }

        return Html::linkAction('EnvelopeController@getView', $text, $this, $attributes);
    }

    /**
     * Query events related to envelope
     * @return \Illuminate\Database\Eloquent\Builder Query
     */
    public function relatedEvents()
    {
        return Event::where(function(EloquentBuilder $query) {
            $query->where('entity_type', 'App\Envelope')->where('entity_id', $this->id);
        })->orWhere(function(EloquentBuilder $query) {
            $query->where('entity_type', 'App\Income')->whereIn('entity_id', function(QueryBuilder $query) {
                $query->select('id')->from('incomes')->where('envelope_id', $this->id);
            });
        })->orWhere(function(EloquentBuilder $query) {
            $query->where('entity_type', 'App\Revenue')->whereIn('entity_id', function(QueryBuilder $query) {
                $query->select('id')->from('revenues')->where('envelope_id', $this->id);
            });
        })->orWhere(function(EloquentBuilder $query) {
            $query->where('entity_type', 'App\Outcome')->whereIn('entity_id', function(QueryBuilder $query) {
                $query->select('id')->from('outcomes')->where('envelope_id', $this->id);
            });
        })->orderBy('id', 'desc');
    }

    /**
     * Query account related to envelope
     * @return \Illuminate\Database\Eloquent\Builder Query
     */
    public function account() {
        return $this->belongsTo('App\Account')
            ->withTrashed();
    }

    /**
     * Query incomes related to envelope
     * @return \Illuminate\Database\Eloquent\Builder Query
     */
    public function incomes() {
        return $this->hasMany('App\Income')
            ->orderBy('date');
    }

    /**
     * Query revenues related to envelope
     * @return \Illuminate\Database\Eloquent\Builder Query
     */
    public function revenues() {
        return $this->hasMany('App\Revenue')
            ->orderBy('date');
    }

    /**
     * Query outcomes related to envelope
     * @return \Illuminate\Database\Eloquent\Builder Query
     */
    public function outcomes() {
        return $this->hasMany('App\Outcome')
            ->orderBy('date');
    }

    /**
     * Query operations related to account for a given operation type
     * @param string $type Operation type (singular form)
     * @return \Illuminate\Database\Eloquent\Builder Query
     */
    public function operationType($type) {
        return $this->{$type.'s'}();
    }

    /**
     * Get related operations in a given period
     * @param  \Carbon\Carbon $after Start of period
     * @param  \Carbon\Carbon $before End of period
     * @return OperationCollection
     */
    public function operationsInPeriod($after, $before) {
        $operations = new OperationCollection();

        $incomes = $this->incomes()->inPeriod($after, $before)->get();
        foreach ($incomes as $income) {
            $operations->push($income);
        }

        $revenues = $this->revenues()->inPeriod($after, $before)->get();
        foreach ($revenues as $revenue) {
            $operations->push($revenue);
        }

        $outcomes = $this->outcomes()->inPeriod($after, $before)->get();
        foreach ($outcomes as $outcome) {
            $operations->push($outcome);
        }

        return $operations->sortByDateThenCreatedAt();
    }

    /**
     * Get balance for a given period
     * @param  \Carbon\Carbon|null $after Start of period
     * @param  \Carbon\Carbon|null $before End of period
     * @return float Balance
     */
    public function getBalanceAttribute($after = null, $before = null) {
        $income  = $this->incomes()->inPeriod($after, $before)->sum('amount');
        $revenue = $this->revenues()->inPeriod($after, $before)->sum('amount');
        $outcome = $this->outcomes()->inPeriod($after, $before)->sum('amount');

        $balance = $income + $revenue - $outcome;

        return floatval($balance);
    }

    /**
     * Get context color based on balance for a given period
     * @param  \Carbon\Carbon|null $after Start of period
     * @param  \Carbon\Carbon|null $before End of period
     * @return string Context color
     */
    public function getStatusAttribute($after = null, $before = null) {
        $balance = $this->getBalanceAttribute($after, $before);

        return $balance < 0 ? 'danger' : 'success';
    }

    /**
     * Get currency based on owner currency
     * @return string Currency
     */
    public function getCurrencyAttribute() {
        return $this->account->currency;
    }

}
