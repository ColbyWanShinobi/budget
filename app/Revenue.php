<?php namespace App;

use App\Operation;
use Html;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property App\Account $account
 * @property string $name
 * @property float $amount
 * @property Carbon\Carbon $date
 */
class Revenue extends Operation
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'amount', 'date'];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['date', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'amount' => 'float',
    ];

    /**
     * Array of field name to watch for changed on updated event
     * @var [type]
     */
    protected $watchedFieldInEvent = [
        'name',
        'amount',
        'date',
    ];

    /**
     * Convert the model to its string representation.
     * @return string
     */
    public function __toString()
    {
        return trans('operation.object.revenue', [
            'name' => $this->name,
            'amount' => Html::formatPrice($this->amount),
            'date' => $this->date->format('d/m/Y'),
        ]);
    }

    public function link() {
        return Html::linkAction(
            'AccountController@getIndex',
            $this,
            [$this->account, 'operations'],
            ['class' => 'routable', 'data-target' => '#page-wrapper']
        );
    }

    public function account() {
        return $this->belongsTo('App\Account')
            ->withTrashed();
    }

    public function getContextAttribute() {
        return 'success';
    }

    public function getTypeAttribute() {
        return 'revenue';
    }
}
