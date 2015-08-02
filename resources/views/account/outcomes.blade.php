@extends('account.index')

@section('tabcontent')

    <div class='col-md-12'>
        <div class="panel panel-default table-responsive">
            <div class="panel-heading text-center">
                {!! Html::linkAction(
                    'AccountController@getOutcomes',
                    '<i class="fa fa-fw fa-arrow-left"></i> '.$prevMonth->formatLocalized('%B %Y'),
                    [$account, $prevMonth->toDateString()],
                    ['class' => 'link-to-page btn btn-xs btn-default pull-left']
                ) !!}
                {{ $month->formatLocalized('%B %Y') }}
                {!! Html::linkAction(
                    'AccountController@getOutcomes',
                    $nextMonth->formatLocalized('%B %Y').' <i class="fa fa-fw fa-arrow-right"></i>',
                    [$account, $nextMonth->toDateString()],
                    ['class' => 'link-to-page btn btn-xs btn-default pull-right']
                ) !!}
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('outcome.fields.date')</th>
                        <th>@lang('outcome.fields.envelope_id')</th>
                        <th>@lang('outcome.fields.name')</th>
                        <th class="text-right">@lang('outcome.fields.amount')</th>
                        <th class="text-right">@lang('outcome.fields.effective')</th>
                    </tr>
                </thead>
                @if ($outcomes->count())
                    @foreach ($outcomes as $outcome)
                        <tr class="{{ $outcome->effective_status }}">
                            <td>{{ $outcome->date->formatLocalized('%A %e') }}</td>
                            <td>{!! $outcome->envelope !!}</td>
                            <td>{{ $outcome->name }}</td>
                            <td class="text-right">{{ Html::formatPrice($outcome->amount) }}</td>
                            <td class="text-right">
                                @lang(
                                    'outcome.fields.effectiveStatus.'.$outcome->effective_status,
                                    ['date' => $outcome->date->diffForHumans()]
                                )
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class='text-center'>@lang('outcome.emptyMessage')</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

@endsection
