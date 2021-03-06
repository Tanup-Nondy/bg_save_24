@extends('shop::customers.account.index')

@section('page_title')
    {{ __('admin::app.catalog.products.edit-title') }}
@stop

@section('page-detail-wrapper')
    <div class="account-head mb-10">
      <span class="back-icon">
          <a href="{{ route('customer.account.index') }}">
              <i class="icon icon-menu-back"></i>
          </a>
      </span>

      <span class="account-heading">
          {{ __('admin::app.catalog.products.edit-title') }}
      </span>
    </div>

    <?php $locale = request()->get('locale') ?: app()->getLocale(); ?>
    <?php $channel = request()->get('channel') ?: core()->getDefaultChannelCode(); ?>

    {!! view_render_event('bagisto.admin.catalog.product.edit.before', ['product' => $product]) !!}

    <form method="post" action="{{ route('seller.product.edit', $product->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

        <div class="account-table-content">
            @csrf

            <input name="_method" type="hidden" value="PUT">
            <input name="channel" type="hidden"  value="{{ $channel }}">
            <input name="locale" type="hidden"  value="{{ $locale }}">

            @foreach ($product->attribute_family->attribute_groups as $index => $attributeGroup)
              <?php $customAttributes = $product->getEditableAttributes($attributeGroup); ?>

              @if (count($customAttributes))

                  {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.before', ['product' => $product]) !!}

                  <accordian :title="'{{ __($attributeGroup->name) }}'"
                              :active="{{$index == 0 ? 'true' : 'false'}}">
                      <div slot="body">
                          {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.controls.before', ['product' => $product]) !!}

                          @foreach ($customAttributes as $attribute)

                              <?php
                                  if ($attribute->code == 'guest_checkout' && ! core()->getConfigData('catalog.products.guest-checkout.allow-guest-checkout')) {
                                      continue;
                                  }

                                  $validations = [];

                                  if ($attribute->is_required) {
                                      array_push($validations, 'required');
                                  }

                                  if ($attribute->type == 'price') {
                                      array_push($validations, 'decimal');
                                  }

                                  array_push($validations, $attribute->validation);

                                  $validations = implode('|', array_filter($validations));
                              ?>

                              @if (view()->exists($typeView = 'admin::catalog.products.field-types.' . $attribute->type))

                                  <div class="control-group {{ $attribute->type }}"
                                        @if ($attribute->type == 'multiselect') :class="[errors.has('{{ $attribute->code }}[]') ? 'has-error' : '']"
                                        @else :class="[errors.has('{{ $attribute->code }}') ? 'has-error' : '']" @endif>

                                      <label
                                          for="{{ $attribute->code }}" {{ $attribute->is_required ? 'class=required' : '' }}>
                                          {{ $attribute->admin_name }}

                                          @if ($attribute->type == 'price')
                                              <span class="currency-code">({{ core()->currencySymbol(core()->getBaseCurrencyCode()) }})</span>
                                          @endif

                                          <?php
                                          $channel_locale = [];

                                          if ($attribute->value_per_channel) {
                                              array_push($channel_locale, $channel);
                                          }

                                          if ($attribute->value_per_locale) {
                                              array_push($channel_locale, $locale);
                                          }
                                          ?>

                                          @if (count($channel_locale))
                                              <span class="locale">[{{ implode(' - ', $channel_locale) }}]</span>
                                          @endif
                                      </label>

                                      @include ($typeView)

                                      <span class="control-error"
                                            @if ($attribute->type == 'multiselect') v-if="errors.has('{{ $attribute->code }}[]')"
                                            @else  v-if="errors.has('{{ $attribute->code }}')"  @endif>
                                          @if ($attribute->type == 'multiselect')
                                              @{{ errors.first('{!! $attribute->code !!}[]') }}
                                          @else
                                              @{{ errors.first('{!! $attribute->code !!}') }}
                                          @endif
                                      </span>
                                  </div>

                              @endif

                          @endforeach

                          @if ($attributeGroup->name == 'Price')

                              @include ('admin::catalog.products.accordians.customer-group-price')

                          @endif

                          {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.controls.after', ['product' => $product]) !!}
                      </div>
                  </accordian>

                  {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.after', ['product' => $product]) !!}

              @endif

          @endforeach

          {!! view_render_event(
            'bagisto.admin.catalog.product.edit_form_accordian.additional_views.before',
              ['product' => $product])
          !!}

          @foreach ($product->getTypeInstance()->getAdditionalViews() as $view)
              @include ($view)
          @endforeach

          {!! view_render_event(
            'bagisto.admin.catalog.product.edit_form_accordian.additional_views.after',
              ['product' => $product])
          !!}

          <div class="button-group">
              <button type="submit" class="theme-btn">{{ __('admin::app.catalog.products.save-btn-title') }}</button>
          </div>
        </div>
    </form>

    {!! view_render_event('bagisto.admin.catalog.product.edit.after', ['product' => $product]) !!}

@endsection

@push('scripts')
    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#channel-switcher, #locale-switcher').on('change', function (e) {
                $('#channel-switcher').val()
                var query = '?channel=' + $('#channel-switcher').val() + '&locale=' + $('#locale-switcher').val();

                window.location.href = "{{ route('admin.catalog.products.edit', $product->id)  }}" + query;
            })

            tinymce.init({
                selector: 'textarea#description, textarea#short_description',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat | code',
                image_advtab: true
            });
        });
    </script>
@endpush
