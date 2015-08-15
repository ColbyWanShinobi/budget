<td class="text-{{ $operation->context }}">
    @lang(
        'operation.type.'.$operation->type,
        ['date' => $operation->date->diffForHumans()]
    )
</td>

<td class="text-{{ $operation->context }}">
    {!! $operation->envelope !!}
</td>

<td class="text-{{ $operation->context }}">
    {{ $operation->date->formatLocalized('%A %e') }}
</td>

<td class="text-{{ $operation->context }}">
    {{ $operation->name }}
</td>

<td class="text-{{ $operation->context }} text-right">
    {{ Html::formatPrice(
        $operation instanceof App\Outcome ? -$operation->amount : $operation->amount,
        true
    ) }}
</td>

<td class="text-{{ $operation->context }} text-right">
    {!! Html::linkAction(
        "Account\OperationsController@getUpdate",
        '<i class="fa fa-fw fa-pencil" title="'.trans('app.button.update').'"></i>',
        [$account, $operation->type, $operation],
        [
            'class' => 'routable btn btn-xs btn-primary',
            'title' => trans('app.button.update'),
            'data-target' => '#row-'.$operation->type.'-'.$operation->id,
        ]
    ) !!}
</td>

<script type="text/javascript">
    OperationModule.initRow($('#row-{{ $operation->type }}-{{ $operation->id }}'));
</script>
