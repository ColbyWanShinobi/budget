
<td class="row form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    {!! Form::select(
        'type',
        $operation instanceof App\Revenue ?
            ['revenue' => trans('operation.type.revenue')]
            : ['outcome' => trans('operation.type.outcome')],
        $operation->type,
        [
            'class' => 'form-control',
            'id' => 'operation-'.$operation->id.'-select-type'
        ]
    ) !!}
    @if ($errors->has('type'))
        {!! Html::ul($errors->get('type'), ['class' => 'help-block text-right']) !!}
    @endif
</td>

<td class="row form-group {{ $errors->has('envelope_id') ? 'has-error' : '' }}">
    {!! Form::select(
        'envelope_id',
        ['' => ''] + $envelope->account->envelopes()->lists('name', 'id')->toArray(),
        $operation->envelope_id,
        [
            'class' => 'form-control',
            'id' => 'operation-'.$operation->id.'-select-envelope_id',
            'data-placeholder-revenue' => trans('operation.placeholder.envelope_id_for_revenue'),
            'data-placeholder-outcome' => trans('operation.placeholder.envelope_id_for_outcome'),
        ]
    ) !!}
    @if ($errors->has('envelope_id'))
        {!! Html::ul($errors->get('envelope_id'), ['class' => 'help-block text-right']) !!}
    @endif
</td>

<td class="row form-group {{ $errors->has('date') ? 'has-error' : '' }}">
    {!! Form::text(
        'date',
        $operation->date->format(trans('app.date.short')),
        [
            'class' => 'form-control datepicker',
            'id' => 'operation-'.$operation->id.'-input-date',
            'placeholder' => trans('operation.fields.date'),
        ]
    ) !!}
    @if ($errors->has('date'))
        {!! Html::ul($errors->get('date'), ['class' => 'help-block text-right']) !!}
    @endif
</td>

<td class="row form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    {!! Form::text(
        'name',
        $operation->name,
        [
            'class' => 'form-control',
            'id' => 'operation-'.$operation->id.'-input-name',
            'placeholder' => trans('operation.fields.name')
        ]
    ) !!}
    @if ($errors->has('name'))
        {!! Html::ul($errors->get('name'), ['class' => 'help-block text-right']) !!}
    @endif
</td>

<td class="row form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <div class='input-group pull-right'>
        {!! Form::text(
            'amount',
            $operation->amount,
            [
                'class' => 'form-control text-right',
                'id' => 'operation-'.$operation->id.'-input-amount',
                'placeholder' => trans('operation.fields.amount')
            ]
        ) !!}
        <span class="input-group-addon">
            {{ $envelope->currency }}
        </span>
    </div>
    @if ($errors->has('amount'))
        {!! Html::ul($errors->get('amount'), ['class' => 'help-block text-right']) !!}
    @endif
</td>

<td class="text-right">

    {!! Form::token() !!}

    {!! Html::linkAction(
        "Envelope\OperationsController@postUpdate",
        '<i class="fa fa-fw fa-pencil" title="'.trans('app.button.update').'"></i>',
        [$envelope, $operation->type, $operation],
        ['class' => 'btn btn-xs btn-success', 'title' => trans('app.button.update')]
    ) !!}

    {!! Html::linkAction(
        "Envelope\OperationsController@postDelete",
        '<i class="fa fa-fw fa-trash" title="'.trans('app.button.delete').'"></i>',
        [$envelope, $operation->type, $operation],
        ['class' => 'btn btn-xs btn-danger', 'title' => trans('app.button.delete')]
    ) !!}

    <script type="text/javascript">
        OperationModule.initRow($('#row-{{ $operation->type }}-{{ $operation->id }}'));
    </script>

</td>

