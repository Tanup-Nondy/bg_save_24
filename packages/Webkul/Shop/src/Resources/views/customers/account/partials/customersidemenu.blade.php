<div class="customer-sidebar row no-margin no-padding">
    <div class="account-details col-12">
        <div class="customer-name col-12 text-uppercase">
            {{ substr(auth('customer')->user()->first_name, 0, 1) }}
        </div>
        <div class="col-12 customer-name-text text-capitalize text-break">{{ auth('customer')->user()->first_name . ' ' . auth('customer')->user()->last_name}}</div>
        <div class="customer-email col-12 text-break">{{ auth('customer')->user()->email }}</div>
    </div>

    @foreach ($menu->items as $menuItem)
    <ul type="none" class="navigation">
        {{-- rearrange menu items --}}
        @php
            $subMenuCollection = [];
            try {
                $subMenuCollection['profile'] = $menuItem['children']['profile'];
                $subMenuCollection['orders'] = $menuItem['children']['orders'];
                $subMenuCollection['downloadables'] = $menuItem['children']['downloadables'];
                $subMenuCollection['wishlist'] = $menuItem['children']['wishlist'];
                $subMenuCollection['compare'] = $menuItem['children']['compare'];
                $subMenuCollection['reviews'] = $menuItem['children']['reviews'];
                $subMenuCollection['address'] = $menuItem['children']['address'];
                unset(
                    $menuItem['children']['profile'],
                    $menuItem['children']['orders'],
                    $menuItem['children']['downloadables'],
                    $menuItem['children']['wishlist'],
                    $menuItem['children']['compare'],
                    $menuItem['children']['reviews'],
                    $menuItem['children']['address']
                );
                foreach ($menuItem['children'] as $key => $remainingChildren) {
                    $subMenuCollection[$key] = $remainingChildren;
                }
            } catch (\Exception $exception) {
                $subMenuCollection = $menuItem['children'];
            }
        @endphp

        @foreach ($subMenuCollection as $index => $subMenuItem)
            <li class="{{ $menu->getActive($subMenuItem) }}" title="{{ trans($subMenuItem['name']) }}">
                <a class="unset fw6 full-width" href="{{ $subMenuItem['url'] }}">
                    <i class="icon {{ $index }} text-down-3"></i>
                    <span>{{ trans($subMenuItem['name']) }}<span>
                    <i class="rango-arrow-right pull-right text-down-3"></i>
                </a>
            </li>
        @endforeach
    </ul>
    {{-- <div class="menu-block">
        <div class="menu-block-title">
            {{ trans($menuItem['name']) }}

            <i class="icon icon-arrow-down right" id="down-icon"></i>
        </div>

        <div class="menu-block-content">
            <ul class="menubar">
                @foreach ($menuItem['children'] as $subMenuItem)
                <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                    <a href="{{ $subMenuItem['url'] }}">
                        {{ trans($subMenuItem['name']) }}
                    </a>

                    <i class="icon angle-right-icon"></i>
                </li>
                @endforeach
            </ul>
        </div>
    </div> --}}
    @endforeach
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $(".icon.icon-arrow-down.right").on('click', function(e){
            var currentElement = $(e.currentTarget);
            if (currentElement.hasClass('icon-arrow-down')) {
                $(this).parents('.menu-block').find('.menubar').show();
                currentElement.removeClass('icon-arrow-down');
                currentElement.addClass('icon-arrow-up');
            } else {
                $(this).parents('.menu-block').find('.menubar').hide();
                currentElement.removeClass('icon-arrow-up');
                currentElement.addClass('icon-arrow-down');
            }
        });
    });
</script>
@endpush
