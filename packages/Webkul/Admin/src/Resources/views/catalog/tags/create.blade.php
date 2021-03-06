@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.catalog.tags.add-title') }}
@stop

@section('content')
    <div class="content">

        <form method="POST" action="{{ route('admin.catalog.tags.store') }}" @submit.prevent="onSubmit" >

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('admin::app.catalog.tags.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.catalog.tags.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.general.before') !!}

                    <accordian :title="'{{ __('admin::app.catalog.tags.general') }}'" :active="true">
                        <div slot="body">

                            {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.general.controls.before') !!}

                            <div class="control-group" :class="[errors.has('admin_name') ? 'has-error' : '']">
                                <label for="admin_name" class="required">{{ __('admin::app.catalog.tags.admin_name') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" data-vv-as="&quot;{{ __('admin::app.catalog.tags.admin_name') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('admin_name')">@{{ errors.first('admin_name') }}</span>
                            </div>
                            <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                                <label for="status" class="required">{{ __('admin::app.catalog.tags.status') }}</label>
                                <select class="control" v-validate="'required'" id="status" name="status" data-vv-as="&quot;{{ __('admin::app.catalog.tags.status') }}&quot;">
                                    <option value="1">
                                        {{ __('admin::app.catalog.tags.yes') }}
                                    </option>
                                    <option value="0">
                                        {{ __('admin::app.catalog.tags.no') }}
                                    </option>
                                </select>
                                <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                            </div>
                            

                            {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.general.controls.after') !!}

                        </div>
                    </accordian>

                    {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.general.after') !!}
                    {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.label.before') !!}

                    <accordian :title="'{{ __('admin::app.catalog.attributes.label') }}'" :active="true">
                        <div slot="body">

                            {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.label.controls.before') !!} 

                            @foreach (app('Webkul\Core\Repositories\LocaleRepository')->all() as $locale)

                                <div class="control-group">
                                    <label for="locale-{{ $locale->code }}">{{ $locale->name . ' (' . $locale->code . ')' }}</label>
                                    <input type="text" class="control" id="locale-{{ $locale->code }}" name="<?php echo $locale->code; ?>[name]" value="{{ old($locale->code)['name'] ?? '' }}"/>
                                </div>

                            @endforeach

                            {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.label.controls.after') !!}

                        </div>
                    </accordian>

                    {!! view_render_event('bagisto.admin.catalog.attribute.create_form_accordian.label.after') !!}

                </div>
            </div>

        </form>
    </div>
@stop

