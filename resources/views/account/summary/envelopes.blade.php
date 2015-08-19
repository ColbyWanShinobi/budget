
<div class="panel panel-default">
    <div class="panel-heading text-right">
        <i class="fa fa-fw fa-pie-chart pull-left"></i>
        @lang('account.summary.envelopes.title')
    </div>
    <div class="panel-body">
        @if ($account->envelopes->count() === 0)
            <div class='alert alert-info'>
                @lang('account.summary.envelopes.emptyMessage', [
                    'link' => Html::linkAction(
                        'EnvelopeController@getAdd',
                        '<i class="fa fa-fw fa-plus" title="'.trans('envelope.add.title').'"></i> '.trans('envelope.add.title'),
                        $account,
                        ['class' => 'routable', 'data-target' => '#page-wrapper']
                    )
                ])
            </div>
        @else
            <div id="account-envelopes-balance-chart"></div>
        @endif
    </div>
</div>

<script type="text/javascript">

    $('#account-envelopes-balance-chart').each(function () {
        $(this).get(0).chart = Morris.Donut({
            element: $(this).attr('id'),
            data: {!! $data !!},
            colors: {!! $colors !!},
            formatter: function (val, data) { return FormatModule.price(data.negative ? -val : val, true); },
            resize: true
        });
    });

</script>
