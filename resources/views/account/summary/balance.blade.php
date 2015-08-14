
<div class="panel panel-{{ $account->status }}">
    <div class="panel-heading text-right">
        <i class="fa fa-fw fa-pie-chart pull-left"></i>
        @lang('account.summary.balance.title', ['balance' => Html::formatPrice($account->balance, true)])
    </div>
    <div class="panel-body">
        <div id="account-summary-balance-chart"></div>
    </div>
</div>

<script type="text/javascript">

    $('#account-summary-balance-chart').get(0).chart = Morris.Donut({
        element: 'account-summary-balance-chart',
        data: {!! $data !!},
        colors: {!! $colors !!},
        formatter: function (val, data) { return FormatModule.price(val); },
        resize: true
    });

</script>