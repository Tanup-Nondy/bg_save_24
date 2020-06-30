<?php
$recommended_slider = \Webkul\CMS\Models\HomeSlider::GetRecommendedSlider();
$slider = [];
$slider_name = "";
foreach ($recommended_slider as $key => $value) {
    $slider_name = $value->slider_name;
    $slider[$value->id]['category_name'] = $value->category_name;
    $slider[$value->id]['products'][] = $value;
}
?>
@if (count($slider) > 0)
    <section class="recommended_title_top">
        <span class="title">{{ $slider_name }}</span>
        <a href="#" class="btn-home btn_view_all">{{ __('velocity::app.home.view-all') }}</a>
    </section>
    <section class="recommended_cat_list">
        <ul >
            <?php $i = 0; ?>
            @foreach($slider as $key => $value)
                <li data-id="cat_recom_{{ $key }}" class="click_to_switch_slider {{ $i == 0 ? 'active' : '' }}">
                    {{ $value['category_name'] }}</li>
                <?php $i += 1; ?>
            @endforeach
        </ul>
    </section>
    <?php $i = 0; ?>
    @foreach($slider as $key => $value)
        <section id="cat_recom_{{ $key }}" class="{{ $i == 0 ? 'active' : '' }} regular slider recommended">
            @foreach($value['products'] as $key => $product)
                <div class="regular_slider_inner">
                    <a title="{{ $product->product_name }}" class="regular_slider_href" href="/{{ $product->url_key }}">
                        <img src="{{ \Webkul\CMS\Models\HomeSlider::GetProductImage($product->product_id) }}">
                        <button class="slider_quick_view_btn" >{{ __('velocity::app.products.quick-view') }}</button>
                    </a>
                </div>
            @endforeach
        </section>
        <?php $i += 1; ?>
    @endforeach
@endif

@push('scripts')
<script>
    $(document).ready(function () {
        $(".click_to_switch_slider").on("click", function (e) {
            var parent = $(this);
            var width = "";
            var max = 0;
            $(".regular.recommended").each(function() {
                if ($(this).find(".slick-track").css('width').length > max) {
                    max = $(this).find(".slick-track").css('width').length;
                    width = $(this).find(".slick-track").css('width');
                }
                $(this).removeClass("active")
            });
            $("li.click_to_switch_slider").each(function() {
                $(this).removeClass("active")
            });
            // slick-track
            $("#"+parent.attr('data-id')).find(".slick-track").css('width', width);
            console.log(width)
            parent.addClass("active");
            $("#"+parent.attr('data-id')).slick('slickPlay');
            $("#"+parent.attr('data-id')).addClass("active");

        });


        $(".regular").slick({
            draggable: true,
//            autoplay: true, /* this is the new line */
            autoplaySpeed: 2000,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            touchThreshold: 1000,
        });

        $(".regular.active").slick({
            draggable: true,
//            autoplay: true, /* this is the new line */
            autoplaySpeed: 2000,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            touchThreshold: 1000,
        });

        const ws = new WebSocket('ws://localhost:8080/chat')

        console.log(ws)


    })

</script>
@endpush