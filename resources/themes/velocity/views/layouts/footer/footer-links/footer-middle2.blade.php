<div class="col-lg-2 col-md-12 col-sm-12 footer-ct-content">
    <span class="contact_main">SAFESHOP METHODS</span>
    <ul class="footer_middle_content">
        <li><a href="{{ route('shop.methods.payment') }}">Payment Method</a></li>
        <li><a href="{{ route('shop.methods.shipping') }}">Shippng Method</a></li>
    </ul>
	{{--<div class="row">--}}

        {{--@if ($velocityMetaData)--}}
            {{--{!! DbView::make($velocityMetaData)->field('footer_middle_content')->render() !!}--}}
        {{--@else--}}
            {{--<div class="col-lg-6 col-md-12 col-sm-12 no-padding">--}}
                {{--<ul type="none">--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/">About Us</a></li>--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/">Customer Service</a></li>--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/">What&rsquo;s New</a></li>--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/">Contact Us </a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="col-lg-6 col-md-12 col-sm-12 no-padding">--}}
                {{--<ul type="none">--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/"> Order and Returns </a></li>--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/"> Payment Policy </a></li>--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/"> Shipping Policy</a></li>--}}
                    {{--<li><a href="https://webkul.com/about-us/company-profile/"> Privacy and Cookies Policy </a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--@endif--}}
	{{--</div>--}}
</div>
