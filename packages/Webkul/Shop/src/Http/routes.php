<?php

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
    //Store front home
    Route::get('/', 'Webkul\Shop\Http\Controllers\HomeController@index')->defaults('_config', [
        'view' => 'shop::home.index'
    ])->name('shop.home.index');
    //Store front about
    Route::get('/about', 'Webkul\Shop\Http\Controllers\StaticPageController@aboutus')->defaults('_config', [
        'view' => 'shop::about.about_us'
    ])->name('shop.about.about_us');
    Route::get('/contact', 'Webkul\Shop\Http\Controllers\StaticPageController@contact')->defaults('_config', [
        'view' => 'shop::about.contact'
    ])->name('shop.about.contact');
    Route::post('/contact/message', 'Webkul\Shop\Http\Controllers\StaticPageController@message')->defaults('_config', [
        'redirect' => 'shop.about.contact'
    ])->name('contact.message');
    Route::get('/career', 'Webkul\Shop\Http\Controllers\StaticPageController@career')->defaults('_config', [
        'view' => 'shop::about.career'
    ])->name('shop.about.career');
    Route::post('/career/save', 'Webkul\Shop\Http\Controllers\StaticPageController@career_save')->name('shop.about.career.save');
    Route::get('/feedback', 'Webkul\Shop\Http\Controllers\StaticPageController@feedback')->defaults('_config', [
        'view' => 'shop::about.feedback'
    ])->name('shop.about.feedback');
    Route::get('/blog', 'Webkul\Shop\Http\Controllers\StaticPageController@blog')->defaults('_config', [
        'view' => 'shop::blog.index'
    ])->name('shop.about.blog');
    Route::get('/blog/{id}', 'Webkul\Shop\Http\Controllers\StaticPageController@blog_id')->defaults('_config', [
        'view' => 'shop::blog.detail'
    ])->name('shop.about.blog_id');

    Route::post('/blog/date', 'Webkul\Shop\Http\Controllers\StaticPageController@blog_date')->defaults('_config', [
        'view' => 'shop::blog.index'
    ])->name('shop.about.blog_date');
    Route::post('/blog/search', 'Webkul\Shop\Http\Controllers\StaticPageController@blog_search')->defaults('_config', [
        'view' => 'shop::blog.index'
    ])->name('shop.about.blog_search');
    //store front support
    Route::get('/payment', 'Webkul\Shop\Http\Controllers\StaticPageController@payment')->defaults('_config', [
        'view' => 'shop::support.payment'
    ])->name('shop.support.payment');
    Route::get('/shipping', 'Webkul\Shop\Http\Controllers\StaticPageController@shipping')->defaults('_config', [
        'view' => 'shop::support.shipping'
    ])->name('shop.support.shipping');
    Route::get('/cancel', 'Webkul\Shop\Http\Controllers\StaticPageController@cancel')->defaults('_config', [
        'view' => 'shop::support.cancel'
    ])->name('shop.support.cancel');
    Route::get('/tracking', 'Webkul\Shop\Http\Controllers\StaticPageController@tracking')->defaults('_config', [
        'view' => 'shop::support.tracking'
    ])->name('shop.support.tracking');
    Route::post('/track', 'Webkul\Shop\Http\Controllers\StaticPageController@track')->defaults('_config', [
        'view' => 'shop::support.tracking'
    ])->name('shop.support.track');
    Route::get('/faqs', 'Webkul\Shop\Http\Controllers\StaticPageController@faqs')->defaults('_config', [
        'view' => 'shop::support.faqs'
    ])->name('shop.support.faqs');
    Route::get('/how', 'Webkul\Shop\Http\Controllers\StaticPageController@how')->defaults('_config', [
        'view' => 'shop::support.how'
    ])->name('shop.support.how');

    //store front policy
    Route::get('/aggrement', 'Webkul\Shop\Http\Controllers\StaticPageController@aggrement')->defaults('_config', [
        'view' => 'shop::policy.aggrement'
    ])->name('shop.policy.aggrement');
    Route::get('/privacy', 'Webkul\Shop\Http\Controllers\StaticPageController@privacy')->defaults('_config', [
        'view' => 'shop::policy.privacy'
    ])->name('shop.policy.privacy');
    Route::get('/return', 'Webkul\Shop\Http\Controllers\StaticPageController@return')->defaults('_config', [
        'view' => 'shop::policy.return'
    ])->name('shop.policy.return');
    Route::get('/refund', 'Webkul\Shop\Http\Controllers\StaticPageController@refund')->defaults('_config', [
        'view' => 'shop::policy.refund'
    ])->name('shop.policy.refund');
    Route::get('/cancellation', 'Webkul\Shop\Http\Controllers\StaticPageController@cancellation')->defaults('_config', [
        'view' => 'shop::policy.cancellation'
    ])->name('shop.policy.cancellation');
    Route::get('/terms', 'Webkul\Shop\Http\Controllers\StaticPageController@terms')->defaults('_config', [
        'view' => 'shop::policy.terms'
    ])->name('shop.policy.terms');
    
    Route::get('/sell', 'Webkul\Shop\Http\Controllers\StaticPageController@sell')->defaults('_config', [
        'view' => 'shop::earn.sell'
    ])->name('shop.earn.sell');
    Route::get('/affiliated', 'Webkul\Shop\Http\Controllers\StaticPageController@affiliated')->defaults('_config', [
        'view' => 'shop::earn.affiliated'
    ])->name('shop.earn.affiliated');
    Route::post('/affiliated', 'Webkul\Shop\Http\Controllers\StaticPageController@apply_affiliated')->defaults('_config', [
        'view' => 'shop::earn.apply_affiliated'
    ])->name('shop.earn.apply_affiliated');
    

    //subscription
    //subscribe
    Route::get('/subscribe', 'Webkul\Shop\Http\Controllers\SubscriptionController@subscribe')->name('shop.subscribe');

    //unsubscribe
    Route::get('/unsubscribe/{token}', 'Webkul\Shop\Http\Controllers\SubscriptionController@unsubscribe')->name('shop.unsubscribe');

    //Store front search
    Route::get('/search', 'Webkul\Shop\Http\Controllers\SearchController@index')->defaults('_config', [
        'view' => 'shop::search.search'
    ])->name('shop.search.index');

    //Country State Selector
    Route::get('get/countries', 'Webkul\Core\Http\Controllers\CountryStateController@getCountries')->defaults('_config', [
        'view' => 'shop::test'
    ])->name('get.countries');

    //Get States When Country is Passed
    Route::get('get/states/{country}', 'Webkul\Core\Http\Controllers\CountryStateController@getStates')->defaults('_config', [
        'view' => 'shop::test'
    ])->name('get.states');

    //checkout and cart
    //Cart Items(listing)
    Route::get('checkout/cart', 'Webkul\Shop\Http\Controllers\CartController@index')->defaults('_config', [
        'view' => 'shop::checkout.cart.index'
    ])->name('shop.checkout.cart.index');

    Route::post('checkout/cart/coupon', 'Webkul\Shop\Http\Controllers\CartController@applyCoupon')->name('shop.checkout.cart.coupon.apply');

    Route::delete('checkout/cart/coupon', 'Webkul\Shop\Http\Controllers\CartController@removeCoupon')->name('shop.checkout.coupon.remove.coupon');

    //Cart Items Add
    Route::post('checkout/cart/add/{id}', 'Webkul\Shop\Http\Controllers\CartController@add')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('cart.add');

    //Cart Items Remove
    Route::get('checkout/cart/remove/{id}', 'Webkul\Shop\Http\Controllers\CartController@remove')->name('cart.remove');

    //Cart Update Before Checkout
    Route::post('/checkout/cart', 'Webkul\Shop\Http\Controllers\CartController@updateBeforeCheckout')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.update');

    //Cart Items Remove
    Route::get('/checkout/cart/remove/{id}', 'Webkul\Shop\Http\Controllers\CartController@remove')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.remove');

    //Checkout Index page
    Route::get('/checkout/onepage', 'Webkul\Shop\Http\Controllers\OnepageController@index')->defaults('_config', [
        'view' => 'shop::checkout.onepage'
    ])->name('shop.checkout.onepage.index');

    //Checkout Save Order
    Route::get('/checkout/summary', 'Webkul\Shop\Http\Controllers\OnepageController@summary')->name('shop.checkout.summary');

    //Checkout Save Address Form Store
    Route::post('/checkout/save-address', 'Webkul\Shop\Http\Controllers\OnepageController@saveAddress')->name('shop.checkout.save-address');

    //Checkout Save Shipping Address Form Store
    Route::post('/checkout/save-shipping', 'Webkul\Shop\Http\Controllers\OnepageController@saveShipping')->name('shop.checkout.save-shipping');

    //Checkout Save Payment Method Form
    Route::post('/checkout/save-payment', 'Webkul\Shop\Http\Controllers\OnepageController@savePayment')->name('shop.checkout.save-payment');

    //Checkout Save Order
    Route::post('/checkout/save-order', 'Webkul\Shop\Http\Controllers\OnepageController@saveOrder')->name('shop.checkout.save-order');

    //Checkout Order Successfull
    Route::get('/checkout/success', 'Webkul\Shop\Http\Controllers\OnepageController@success')->defaults('_config', [
        'view' => 'shop::checkout.success'
    ])->name('shop.checkout.success');

    //Shop buynow button action
    Route::get('move/wishlist/{id}', 'Webkul\Shop\Http\Controllers\CartController@moveToWishlist')->name('shop.movetowishlist');

    Route::get('/downloadable/download-sample/{type}/{id}', 'Webkul\Shop\Http\Controllers\ProductController@downloadSample')->name('shop.downloadable.download_sample');

    // Show Product Review Form
    Route::get('/reviews/{slug}', 'Webkul\Shop\Http\Controllers\ReviewController@show')->defaults('_config', [
        'view' => 'shop::products.reviews.index'
    ])->name('shop.reviews.index');

    // Show Product Review(listing)
    Route::get('/product/{slug}/review', 'Webkul\Shop\Http\Controllers\ReviewController@create')->defaults('_config', [
        'view' => 'shop::products.reviews.create'
    ])->name('shop.reviews.create');

    // Show Product Review Form Store
    Route::post('/product/{slug}/review', 'Webkul\Shop\Http\Controllers\ReviewController@store')->defaults('_config', [
        'redirect' => 'shop.home.index'
    ])->name('shop.reviews.store');

     // Download file or image
    Route::get('/product/{id}/{attribute_id}', 'Webkul\Shop\Http\Controllers\ProductController@download')->defaults('_config', [
        'view' => 'shop.products.index'
    ])->name('shop.product.file.download');

    //customer routes starts here
    Route::prefix('customer')->group(function () {
        // forgot Password Routes
        // Forgot Password Form Show
        Route::get('/forgot-password', 'Webkul\Customer\Http\Controllers\ForgotPasswordController@create')->defaults('_config', [
            'view' => 'shop::customers.signup.forgot-password'
        ])->name('customer.forgot-password.create');

        // Forgot Password Form Store
        Route::post('/forgot-password', 'Webkul\Customer\Http\Controllers\ForgotPasswordController@store')->name('customer.forgot-password.store');

        // Reset Password Form Show
        Route::get('/reset-password/{token}', 'Webkul\Customer\Http\Controllers\ResetPasswordController@create')->defaults('_config', [
            'view' => 'shop::customers.signup.reset-password'
        ])->name('customer.reset-password.create');

        // Reset Password Form Store
        Route::post('/reset-password', 'Webkul\Customer\Http\Controllers\ResetPasswordController@store')->defaults('_config', [
            'redirect' => 'customer.profile.index'
        ])->name('customer.reset-password.store');

        // Login Routes
        // Login form show
        Route::get('login', 'Webkul\Customer\Http\Controllers\SessionController@show')->defaults('_config', [
            'view' => 'shop::customers.session.index',
        ])->name('customer.session.index');

        // Login form store
        Route::post('login', 'Webkul\Customer\Http\Controllers\SessionController@create')->defaults('_config', [
            'redirect' => 'customer.profile.index'
        ])->name('customer.session.create');


        // Registration Routes
        //registration form show
        Route::get('register', 'Webkul\Customer\Http\Controllers\RegistrationController@show')->defaults('_config', [
            'view' => 'shop::customers.signup.index'
        ])->name('customer.register.index');

        //registration form store
        Route::post('register', 'Webkul\Customer\Http\Controllers\RegistrationController@create')->defaults('_config', [
            'redirect' => 'customer.session.index',
        ])->name('customer.register.create');

        //verify account
        Route::get('/verify-account/{token}', 'Webkul\Customer\Http\Controllers\RegistrationController@verifyAccount')->name('customer.verify');

        //resend verification email
        Route::get('/resend/verification/{email}', 'Webkul\Customer\Http\Controllers\RegistrationController@resendVerificationEmail')->name('customer.resend.verification-email');

        // for customer login checkout
        Route::post('/customer/exist', 'Webkul\Shop\Http\Controllers\OnepageController@checkExistCustomer')->name('customer.checkout.exist');

        // for customer login checkout
        Route::post('/customer/checkout/login', 'Webkul\Shop\Http\Controllers\OnepageController@loginForCheckout')->name('customer.checkout.login');

        // Auth Routes
        Route::group(['middleware' => ['customer']], function () {

            //Customer logout
            Route::get('logout', 'Webkul\Customer\Http\Controllers\SessionController@destroy')->defaults('_config', [
                'redirect' => 'customer.session.index'
            ])->name('customer.session.destroy');

            //Customer Wishlist add
            Route::get('wishlist/add/{id}', 'Webkul\Customer\Http\Controllers\WishlistController@add')->name('customer.wishlist.add');

            //Customer Wishlist remove
            Route::get('wishlist/remove/{id}', 'Webkul\Customer\Http\Controllers\WishlistController@remove')->name('customer.wishlist.remove');

            //Customer Wishlist remove
            Route::get('wishlist/removeall', 'Webkul\Customer\Http\Controllers\WishlistController@removeAll')->name('customer.wishlist.removeall');

            //Customer Wishlist move to cart
            Route::get('wishlist/move/{id}', 'Webkul\Customer\Http\Controllers\WishlistController@move')->name('customer.wishlist.move');

            //customer account
            Route::prefix('account')->group(function () {
                //Customer Dashboard Route
                Route::get('index', 'Webkul\Customer\Http\Controllers\AccountController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.index'
                ])->name('customer.account.index');

                //Customer Profile Show
                Route::get('profile', 'Webkul\Customer\Http\Controllers\CustomerController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.profile.index'
                ])->name('customer.profile.index');

                //Customer Profile Edit Form Show
                Route::get('profile/edit', 'Webkul\Customer\Http\Controllers\CustomerController@edit')->defaults('_config', [
                    'view' => 'shop::customers.account.profile.edit'
                ])->name('customer.profile.edit');

                //Customer Profile Edit Form Store
                Route::post('profile/edit', 'Webkul\Customer\Http\Controllers\CustomerController@update')->defaults('_config', [
                    'redirect' => 'customer.profile.index'
                ])->name('customer.profile.edit');

                //Customer Profile Delete Form Store
                Route::post('profile/destroy', 'Webkul\Customer\Http\Controllers\CustomerController@destroy')->defaults('_config', [
                    'redirect' => 'customer.profile.index'
                ])->name('customer.profile.destroy');

                /*  Profile Routes Ends Here  */

                /*    Routes for Addresses   */
                //Customer Address Show
                Route::get('addresses', 'Webkul\Customer\Http\Controllers\AddressController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.address.index'
                ])->name('customer.address.index');

                //Customer Address Create Form Show
                Route::get('addresses/create', 'Webkul\Customer\Http\Controllers\AddressController@create')->defaults('_config', [
                    'view' => 'shop::customers.account.address.create'
                ])->name('customer.address.create');

                //Customer Address Create Form Store
                Route::post('addresses/create', 'Webkul\Customer\Http\Controllers\AddressController@store')->defaults('_config', [
                    'view' => 'shop::customers.account.address.address',
                    'redirect' => 'customer.address.index'
                ])->name('customer.address.create');

                //Customer Address Edit Form Show
                Route::get('addresses/edit/{id}', 'Webkul\Customer\Http\Controllers\AddressController@edit')->defaults('_config', [
                    'view' => 'shop::customers.account.address.edit'
                ])->name('customer.address.edit');

                //Customer Address Edit Form Store
                Route::put('addresses/edit/{id}', 'Webkul\Customer\Http\Controllers\AddressController@update')->defaults('_config', [
                    'redirect' => 'customer.address.index'
                ])->name('customer.address.edit');

                //Customer Address Make Default
                Route::get('addresses/default/{id}', 'Webkul\Customer\Http\Controllers\AddressController@makeDefault')->name('make.default.address');

                //Customer Address Delete
                Route::get('addresses/delete/{id}', 'Webkul\Customer\Http\Controllers\AddressController@destroy')->name('address.delete');

                /* Wishlist route */
                //Customer wishlist(listing)
                Route::get('wishlist', 'Webkul\Customer\Http\Controllers\WishlistController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.wishlist.wishlist'
                ])->name('customer.wishlist.index');

                /* Orders route */
                //Customer orders(listing)
                Route::get('orders', 'Webkul\Shop\Http\Controllers\OrderController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.index'
                ])->name('customer.orders.index');

                //Customer downloadable products(listing)
                Route::get('downloadable-products', 'Webkul\Shop\Http\Controllers\DownloadableProductController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.downloadable_products.index'
                ])->name('customer.downloadable_products.index');

                //Customer downloadable products(listing)
                Route::get('downloadable-products/download/{id}', 'Webkul\Shop\Http\Controllers\DownloadableProductController@download')->defaults('_config', [
                    'view' => 'shop::customers.account.downloadable_products.index'
                ])->name('customer.downloadable_products.download');

                //Customer orders view summary and status
                Route::get('orders/view/{id}', 'Webkul\Shop\Http\Controllers\OrderController@view')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.view'
                ])->name('customer.orders.view');

                //Prints invoice
                Route::get('orders/print/{id}', 'Webkul\Shop\Http\Controllers\OrderController@print')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.print'
                ])->name('customer.orders.print');

                Route::get('/orders/cancel/{id}', 'Webkul\Shop\Http\Controllers\OrderController@cancel')->name('customer.orders.cancel');

                /* Reviews route */
                //Customer reviews
                Route::get('reviews', 'Webkul\Customer\Http\Controllers\CustomerController@reviews')->defaults('_config', [
                    'view' => 'shop::customers.account.reviews.index'
                ])->name('customer.reviews.index');

                //Customer review delete
                Route::get('reviews/delete/{id}', 'Webkul\Shop\Http\Controllers\ReviewController@destroy')->defaults('_config', [
                    'redirect' => 'customer.reviews.index'
                ])->name('customer.review.delete');

                //Customer all review delete
                Route::get('reviews/all-delete', 'Webkul\Shop\Http\Controllers\ReviewController@deleteAll')->defaults('_config', [
                    'redirect' => 'customer.reviews.index'
                ])->name('customer.review.deleteall');
            });
        });
    });
    //customer routes end here

    Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

        Route::prefix('seller')->group(function () {
            Route::get('login', 'Badenjki\Seller\Http\Controllers\SessionController@show')->defaults('_config', [
                'view' => 'shop::sellers.signin.index'
            ])->name('store.index');

            Route::post('login', 'Badenjki\Seller\Http\Controllers\SessionController@create')->defaults('_config', [
            'redirect' => 'customer.store.index'
            ])->name('store.index.save');

            Route::get('registration', 'Badenjki\Seller\Http\Controllers\RegistrationController@show')->defaults('_config', [
                'view' => 'shop::sellers.register.index'
            ])->name('store.register');

            Route::post('registration', 'Badenjki\Seller\Http\Controllers\RegistrationController@create')->defaults('_config', [
            'redirect' => 'store.index',
            ])->name('store.register.save');
        });
        Route::group(['middleware' => ['customer']], function () {

            Route::get('stores', 'Badenjki\Seller\Http\Controllers\StoreController@index')->defaults('_config', [
                'view' => 'shop::customers.account.store.index'
            ])->name('customer.store.index');

           Route::get('stores/create', 'Badenjki\Seller\Http\Controllers\StoreController@create')->defaults('_config', [
               'view' => 'shop::customers.account.store.create'
           ])->name('customer.store.create');

           Route::post('stores/create', 'Badenjki\Seller\Http\Controllers\StoreController@store')->defaults('_config',[
               'redirect' => 'customer.store.index'
           ])->name('customer.store.create');

            Route::get('stores/edit/{id}', 'Webkul\Customer\Http\Controllers\AddressController@edit')->defaults('_config', [
                'view' => 'shop::customers.account.store.edit'
            ])->name('customer.store.edit');

            Route::patch('stores/edit/{store}', 'Badenjki\Seller\Http\Controllers\StoreController@update')->defaults('_config',[
                'redirect' => 'customer.store.index'
            ])->name('customer.store.edit');

            //Seller products(listing)
            Route::get('products', 'Badenjki\Seller\Http\Controllers\ProductController@index')->defaults('_config', [
                'view' => 'shop::sellers.product.index'
            ])->name('seller.products.index');

            //Product Create Form Show
            Route::get('products/create', 'Badenjki\Seller\Http\Controllers\ProductController@create')->defaults('_config', [
                'view' => 'shop::sellers.product.create'
            ])->name('seller.product.create');

            //Products Create Form Store
            Route::post('products/create', 'Badenjki\Seller\Http\Controllers\ProductController@store')->defaults('_config', [
                'redirect' => 'seller.product.edit'
            ])->name('seller.product.create');

            Route::get('products/edit/{id}', 'Badenjki\Seller\Http\Controllers\ProductController@edit')->defaults('_config', [
                'view' => 'shop::sellers.product.edit',
            ])->name('seller.product.edit');

            Route::put('products/edit/{id}', 'Badenjki\Seller\Http\Controllers\ProductController@update')->defaults('_config', [
                'redirect' => 'seller.products.index',
            ])->name('seller.product.edit');

            // Dashboard Route
            Route::get('dashboard', 'Badenjki\Seller\Http\Controllers\DashboardController@index')->defaults('_config', [
                'view' => 'shop::sellers.dashboard.index',
            ])->name('seller.dashboard.index');

        });
    });

    Route::get('page/{slug}', 'Webkul\CMS\Http\Controllers\Shop\PagePresenterController@presenter')->name('shop.cms.page');

    Route::fallback(\Webkul\Shop\Http\Controllers\ProductsCategoriesProxyController::class . '@index')
        ->defaults('_config', [
            'product_view' => 'shop::products.view',
            'category_view' => 'shop::products.index'
        ])
        ->name('shop.productOrCategory.index');
    //Login using facebook
        Route::post('submit-review', 'Webkul\Shop\Http\Controllers\ProductsCategoriesProxyController@submit_review')
            ->name('submit-review');

        Route::get('login/facebook', 'Webkul\Customer\Http\Controllers\SessionController@redirectToFacebookProvider')->name('redirectFacebook');
        Route::get('login/facebook/callback', 'Webkul\Customer\Http\Controllers\SessionController@handleFacebookProviderCallback');
        //Login using google
        Route::get('login/google', 'Webkul\Customer\Http\Controllers\SessionController@redirectToGoogleProvider')->name('redirectGoogle');
        Route::get('login/google/callback', 'Webkul\Customer\Http\Controllers\SessionController@handleGoogleProviderCallback');
});
