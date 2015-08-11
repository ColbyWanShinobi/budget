<div id="envelope-index"
    class='row'
    data-horizontal-url="{{ action('AccountController@getIndex', $envelope->account) }}"
    data-vertical-url="{{ action('EnvelopeController@getView', $envelope) }}"
    data-account-id="{{ $envelope->account->id }}">

    @include('blocks.alerts')

    <div class='col-md-12'>
        <h1 class="page-header">
            {!! $envelope !!}
            <small>
                {{ $envelope->account }}
            </small>
            <div class='pull-right'>
                {!! Html::linkAction(
                    'EnvelopeController@getUpdate',
                    '<i class="fa fa-fw fa-pencil" title="'.trans('app.button.update').'"></i> '.trans('app.button.update'),
                    $envelope,
                    [
                        'class' => 'routable btn btn-primary',
                        'data-target' => '#page-wrapper'
                    ]
                ) !!}
                @if ($envelope->trashed())
                    {!! Html::linkAction(
                        'EnvelopeController@getRestore',
                        '<i class="fa fa-fw fa-recycle" title="'.trans('app.button.restore').'"></i> '.trans('app.button.restore'),
                        $envelope,
                        [
                            'class' => 'routable btn btn-success',
                            'data-target' => '#page-wrapper'
                        ]
                    ) !!}
                @else
                {!! Html::linkAction(
                        'EnvelopeController@getDelete',
                        '<i class="fa fa-fw fa-archive" title="'.trans('app.button.archive').'"></i> '.trans('app.button.archive'),
                        $envelope,
                        [
                            'class' => 'routable btn btn-danger',
                            'data-target' => '#page-wrapper'
                        ]
                    ) !!}
                @endif
            </div>
        </h1>
    </div>

    <div class='col-md-12'>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class='active'>
                {!! Html::link(
                    '#summary',
                    '<i class="fa fa-fw fa-th-large"></i> '
                        .trans('envelope.summary.title'),
                    ['aria-controls' => 'summary', 'role' => 'tab', 'data-toggle' => 'tab']
                ) !!}
            </li>
            <li role="presentation">
                {!! Html::link(
                    '#operations',
                    '<i class="fa fa-fw fa-exchange"></i> '
                        .trans('operation.title'),
                    ['aria-controls' => 'operations', 'role' => 'tab', 'data-toggle' => 'tab']
                ) !!}
            </li>
            <li role="presentation">
                {!! Html::link(
                    '#development',
                    '<i class="fa fa-fw fa-area-chart"></i> '
                        .trans('envelope.development.title'),
                    ['aria-controls' => 'development', 'role' => 'tab', 'data-toggle' => 'tab']
                ) !!}
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane row active" id="summary">
                <div class='col-md-4' id='envelope-summary-balance' data-url='{{ action('Envelope\SummaryController@getBalance', $envelope) }}'></div>
                <div class='col-md-4' id='envelope-summary-events' data-url='{{ action('Envelope\SummaryController@getEvents', $envelope) }}'></div>
            </div>
            <div role="tabpanel" class="tab-pane row" id="operations">
                <div class='col-md-12' id='envelope-operations-table' data-url='{{ action('Envelope\OperationsController@getTable', $envelope) }}'></div>
            </div>
            <div role="tabpanel" class="tab-pane row" id="development">
                <div class='col-md-12' id='envelope-development-monthly' data-url='{{ action('Envelope\DevelopmentController@getMonthly', $envelope) }}'></div>
                <div class='col-md-12' id='envelope-development-yearly' data-url='{{ action('Envelope\DevelopmentController@getYearly', $envelope) }}'></div>
            </div>
        </div>

    </div>

    <script type="text/javascript">

        RouterModule.refresh($('#envelope-summary-balance'));
        RouterModule.refresh($('#envelope-summary-events'));
        RouterModule.refresh($('#envelope-operations-table'));

        $('#envelope-index > div > ul.nav-tabs a').on('shown.bs.tab', function (e) {
            if (e.target.hash === '#development' && $('#envelope-development-monthly').is(':empty')) {
                RouterModule.refresh($('#envelope-development-monthly'), function() {
                    RouterModule.refresh($('#envelope-development-yearly'));
                });
            }
        });

        $('.page-header .btn-danger, .page-header .btn-success').click(function () {
            NavbarModule.emptyVerticalMenu();
        });

    </script>

</div>
