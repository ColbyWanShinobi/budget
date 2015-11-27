<div id="envelope-add"
    class='row'
    data-horizontal-url="{{ action('AccountController@getIndex', $account) }}"
    data-vertical-url="{{ action('EnvelopeController@getAdd', $account) }}"
    data-account-id="{{ $account->id }}">

    @include('blocks.alerts')

    <div class='col-md-12'>
        <h1 class="page-header">
            <i class="fa fa-fw fa-plus" title="@lang('envelope.add.title')"></i>
            @lang('envelope.add.title')
            <small>
                {{ $account }}
            </small>
        </h1>
    </div>

    <div class="col-md-10 col-md-offset-1">
        <div class='row'>

            {!! Form::open([
                'action' => ['EnvelopeController@postAdd', $account],
                'class' => 'routable col-md-12',
                'data-target' => '#page-wrapper',
            ]) !!}
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title text-right">
                            <i class="fa fa-fw fa-plus pull-left"></i>
                            @lang('envelope.add.title')
                        </h3>
                    </div>

                    <div class="panel-body">

                        <div class="col-md-6 col-sm-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::text(
                                'name',
                                null,
                                ['class' => 'form-control', 'id' => 'input-name', 'placeholder' => trans('envelope.fields.name')]
                            ) !!}
                            @if ($errors->has('name'))
                                {!! Html::ul($errors->get('name'), ['class' => 'help-block text-right']) !!}
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 form-group {{ $errors->has('default_income') ? 'has-error' : '' }}">
                            <div class='input-group'>
                                {!! Form::text(
                                    'default_income',
                                    null,
                                    ['class' => 'form-control text-right', 'id' => 'input-default_income', 'placeholder' => trans('envelope.fields.default_income')]
                                ) !!}
                                <span class="input-group-addon">
                                    {{ $account->currency }}
                                </span>
                            </div>
                            @if ($errors->has('default_income'))
                                {!! Html::ul($errors->get('default_income'), ['class' => 'help-block text-right']) !!}
                            @endif
                        </div>

                        <div class="col-sm-12 form-group {{ $errors->has('icon') ? 'has-error' : '' }}"
                            data-placement="inline"
                            data-selected="{{ Input::old('icon') }}"
                            id="container-icon">
                            {!! Form::hidden('icon', null, ['id' => 'input-icon']) !!}
                            @if ($errors->has('icon'))
                                {!! Html::ul($errors->get('icon'), ['class' => 'help-block text-right']) !!}
                            @endif
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        {!! Form::button(
                            trans('app.button.add'),
                            ['type' => 'submit', 'class' => 'btn btn-xs btn-success']
                        ) !!}
                    </div>

                </div>
            {!! Form::close() !!}

        </div>
    </div>

    <script type="text/javascript">
        $('#container-icon').iconpicker({
            templates: {
                search: '<div class="input-group"><span class="input-group-addon"><i class="fa {{ Input::old('icon') }}"></i></span><input type="search" class="form-control iconpicker-search" placeholder="@lang('envelope.fields.filterIcon')" /></div>',
            }
        }).on('iconpickerSetValue', function (e) {
            $('#input-icon').val(e.iconpickerValue);
            $('#container-icon .input-group-addon i').attr('class', '').attr('class', 'fa '+e.iconpickerValue);
        });
    </script>

</div>
