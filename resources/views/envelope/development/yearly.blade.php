<div class="panel panel-default">
    <div class="panel-heading text-center">
        {!! Html::linkAction(
            'Envelope\DevelopmentController@getYearly',
            '<i class="fa fa-fw fa-arrow-left"></i> '.$prevYear->formatLocalized('%Y'),
            [$envelope, $prevYear->toDateString()],
            [
                'class' => 'routable btn btn-xs btn-default pull-left',
                'data-target' => '#envelope-development-yearly',
            ]
        ) !!}
        {{ $date->formatLocalized('%Y') }}
        {!! Html::linkAction(
            'Envelope\DevelopmentController@getYearly',
            $nextYear->formatLocalized('%Y').' <i class="fa fa-fw fa-arrow-right"></i>',
            [$envelope, $nextYear->toDateString()],
            [
                'class' => 'routable btn btn-xs btn-default pull-right',
                'data-target' => '#envelope-development-yearly',
            ]
        ) !!}
    </div>
    <div class="panel-body">
        <div id="envelope-development-yearly-chart"></div>
    </div>
</div>

<script type="text/javascript">

    $('#envelope-development-yearly-chart').get(0).chart = Morris.Area({
        element: 'envelope-development-yearly-chart',
        data: {!! $data !!},
        xkey: 'date',
        ykeys: [
            'income',
            'outcome',
        ],
        labels: [
            "@lang('operation.type.income')",
            "@lang('operation.type.outcome')",
        ],
        lineColors: {!! $colors !!},
        dateFormat: function (date) { return require('moment')(date).format("MMMM"); },
        xLabelFormat: function (date) {return require('moment')(date).subtract(1, 'months').format("MMMM"); },
        yLabelFormat: function (val) { return FormatModule.price(val); },
        smooth: false,
        resize: true,
        behaveLikeLine: true,
    });

</script>