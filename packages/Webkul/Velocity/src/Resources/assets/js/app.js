import Vue from 'vue';
import accounting from 'accounting';
import VueCarousel from 'vue-carousel';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/index.css';
import de from 'vee-validate/dist/locale/de';
import ar from 'vee-validate/dist/locale/ar';
import VeeValidate, { Validator } from 'vee-validate';
import axios from 'axios';

// import ar_plug from 'array-tools'
//

window.axios = axios;
window.VeeValidate = VeeValidate;
window.jQuery = window.$ = require("jquery");
window.BootstrapSass = require("bootstrap-sass");

Vue.use(VueToast);
Vue.use(VueCarousel);
Vue.use(BootstrapSass);
Vue.prototype.$http = axios;

Vue.use(VeeValidate, {
    dictionary: {
        ar: ar,
        de: de,
    }
});

Vue.filter('currency', function (value, argument) {
    return accounting.formatMoney(value, argument);
})

window.Vue = Vue;
window.Carousel = VueCarousel;



// UI components
Vue.component("vue-slider", require("vue-slider-component"));
Vue.component("top_slider_category", require("./UI/components/home-slider"));
Vue.component("slider-add-section", require("./UI/components/slider-add-section"));
Vue.component("add-panel-first", require("./UI/components/add-panel-first"));
Vue.component("add-panel-second", require("./UI/components/add-panel-second"));
Vue.component('mini-cart', require('./UI/components/mini-cart'));
Vue.component('modal-component', require('./UI/components/modal'));
Vue.component("add-to-cart", require("./UI/components/add-to-cart"));
Vue.component('star-ratings', require('./UI/components/star-rating'));
Vue.component('quantity-btn', require('./UI/components/quantity-btn'));
Vue.component('sidebar-component', require('./UI/components/sidebar'));
Vue.component('sidebar-new', require('./UI/components/sidebar-new'));
Vue.component('root', require('./UI/components/root'));
Vue.component('folder', require('./UI/components/folder'));
Vue.component("product-card", require("./UI/components/product-card"));
Vue.component("wishlist-component", require("./UI/components/wishlist"));
Vue.component('carousel-component', require('./UI/components/carousel'));
Vue.component('child-sidebar', require('./UI/components/child-sidebar'));
Vue.component('card-list-header', require('./UI/components/card-header'));
Vue.component('magnify-image', require('./UI/components/image-magnifier'));
Vue.component('compare-component', require('./UI/components/product-compare'));
Vue.component("shimmer-component", require("./UI/components/shimmer-component"));
Vue.component("shimmer-component-small", require("./UI/components/shimmer-component-small"));
Vue.component("shimmer-component-slider", require("./UI/components/shimmer-component-slider"));
Vue.component('responsive-sidebar', require('./UI/components/responsive-sidebar'));
Vue.component('product-quick-view', require('./UI/components/product-quick-view'));
Vue.component('product-view', require('./UI/components/product-view'));
Vue.component('configure-product-view', require('./UI/components/configure-product-view'));
Vue.component('take-review', require('./UI/components/take-review'));
Vue.component('product-quick-view-btn', require('./UI/components/product-quick-view-btn'));
Vue.component('recommended-cat-list', require('./UI/components/recommended-cat-list'));
Vue.component('mix-customize-section-home', require('./UI/components/mix-customize-section'));
Vue.component('customize-category-section', require('./UI/components/customize-category-section'));

import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.component('loading', Loading);
import VModal from 'vue-js-modal'
window.eventBus = new Vue();
Vue.use(VModal, { componentName: 'v-modal' });

$(document).ready(function () {
    // define a mixin object
    Vue.mixin(require('./UI/components/trans'));

    Vue.mixin({
        data: function () {
            return {
                'imageObserver': null,
                'navContainer': false,
                'headerItemsCount': 0,
                'sharedRootCategories': [],
                'responsiveSidebarTemplate': '',
                'responsiveSidebarKey': Math.random(),
                // 'baseUrl': document.querySelector("script[src$='velocity.js']").getAttribute('baseUrl'),
                'baseUrl': document.getElementById("base_url_span").getAttribute('baseUrl'),
            }
        },

        methods: {
            redirect: function (route) {
                route ? window.location.href = route : '';
            },

            debounceToggleSidebar: function (id, {target}, type) {
                // setTimeout(() => {
                    this.toggleSidebar(id, target, type);
                // }, 500);
            },

            toggleSidebar: function (id, {target}, type) {

                if (
                    Array.from(target.classList)[0] == "main-category"
                    || Array.from(target.parentElement.classList)[0] == "main-category"
                ) {
                    let sidebar = $(`#sidebar-level-${id}`);

                    if (sidebar && sidebar.length > 0) {
                        if (type == "mouseover") {
                            this.show(sidebar);
                        } else if (type == "mouseout") {
                            this.hide(sidebar);
                        }
                    }
                } else if (
                    Array.from(target.classList)[0]     == "category"
                    || Array.from(target.classList)[0]  == "category-icon"
                    || Array.from(target.classList)[0]  == "category-title"
                    || Array.from(target.classList)[0]  == "category-content"
                    || Array.from(target.classList)[0]  == "rango-arrow-right"
                ) {
                    let parentItem = target.closest('li');

                    if (target.id || parentItem.id.match('category-')) {
                        let subCategories = $(`#${target.id ? target.id : parentItem.id} .sub-categories`);

                        if (subCategories && subCategories.length > 0) {
                            let subCategories1 = Array.from(subCategories)[0];
                            subCategories1 = $(subCategories1);

                            if (type == "mouseover") {
                                console.log(subCategories1)
                                this.show(subCategories1);
                                let sidebarChild = subCategories1.find('.sidebar');
                                this.show(sidebarChild);
                            } else if (type == "mouseout") {

                                this.hide(subCategories1);
                            } else {
                                console.log('not found')
                            }

                        } else {
                            if (type == "mouseout") {
                                let sidebar = $(`#${id}`);
                                sidebar.hide();
                            }
                        }
                    }
                }
            },

            show: function (element) {
                element.show();
                element.mouseleave(({target}) => {
                    $(target.closest('.sidebar')).hide();
                });
            },

            hide: function (element) {
                element.hide();
            },

            toggleButtonDisability ({event, actionType}) {
                let button = event.target.querySelector('button[type=submit]');

                button ? button.disabled = actionType : '';
            },

            onSubmit: function (event) {
                this.toggleButtonDisability({event, actionType: true});

                if(typeof tinyMCE !== 'undefined')
                    tinyMCE.triggerSave();

                this.$validator.validateAll().then(result => {
                    if (result) {
                        event.target.submit();
                    } else {
                        this.toggleButtonDisability({event, actionType: false});

                        eventBus.$emit('onFormError')
                    }
                });
            },

            isMobile: function () {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                  return true
                } else {
                  return false
                }
            },

            getDynamicHTML: function (input) {
                var _staticRenderFns;
                const { render, staticRenderFns } = Vue.compile(input);

                if (this.$options.staticRenderFns.length > 0) {
                    _staticRenderFns = this.$options.staticRenderFns;
                } else {
                    _staticRenderFns = this.$options.staticRenderFns = staticRenderFns;
                }

                try {
                    var output = render.call(this, this.$createElement);
                } catch (exception) {
                    console.log(this.__('error.something_went_wrong'));
                }

                this.$options.staticRenderFns = _staticRenderFns;

                return output;
            },

            getStorageValue: function (key) {
                let value = window.localStorage.getItem(key);

                if (value) {
                    value = JSON.parse(value);
                }

                return value;
            },

            setStorageValue: function (key, value) {
                window.localStorage.setItem(key, JSON.stringify(value));

                return true;
            },
        }
    });

    new Vue({
        el: "#app",
        VueToast,

        data: function () {
            return {
                modalIds: {},
                miniCartKey: 0,
                quickView: false,
                productDetails: [],
            }
        },

        created: function () {
            window.addEventListener('click', () => {
                let modals = document.getElementsByClassName('sensitive-modal');

                Array.from(modals).forEach(modal => {
                    modal.classList.add('hide');
                });
            });
        },

        mounted: function () {
            setTimeout(() => {
                this.addServerErrors();
            }, 0);

            document.body.style.display = "block";
            this.$validator.localize(document.documentElement.lang);

            this.loadCategories();
            this.addIntersectionObserver();
        },

        methods: {
            onSubmit: function (event) {
                this.toggleButtonDisability({event, actionType: true});

                if(typeof tinyMCE !== 'undefined')
                    tinyMCE.triggerSave();

                this.$validator.validateAll().then(result => {
                    if (result) {
                        event.target.submit();
                    } else {
                        this.toggleButtonDisability({event, actionType: false});

                        eventBus.$emit('onFormError')
                    }
                });
            },

            toggleButtonDisable (value) {
                var buttons = document.getElementsByTagName("button");

                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].disabled = value;
                }
            },

            addServerErrors: function (scope = null) {
                for (var key in serverErrors) {
                    var inputNames = [];
                    key.split('.').forEach(function(chunk, index) {
                        if(index) {
                            inputNames.push('[' + chunk + ']')
                        } else {
                            inputNames.push(chunk)
                        }
                    });

                    var inputName = inputNames.join('');

                    const field = this.$validator.fields.find({
                        name: inputName,
                        scope: scope
                    });

                    if (field) {
                        this.$validator.errors.add({
                            id: field.id,
                            field: inputName,
                            msg: serverErrors[key][0],
                            scope: scope
                        });
                    }
                }
            },

            addFlashMessages: function () {
                if (window.flashMessages.alertMessage)
                    window.alert(window.flashMessages.alertMessage);
            },

            showModal: function (id) {
                this.$set(this.modalIds, id, true);
            },

            loadCategories: function () {
                this.$http.get(`${this.baseUrl}/categories`)
                .then(response => {
                    this.sharedRootCategories = response.data.categories;
                    $(`<style type='text/css'> .sub-categories{ min-height:${response.data.categories.length * 30}px;} </style>`).appendTo("head");
                })
                .catch(error => {
                    console.log('failed to load categories');
                })
            },

            addIntersectionObserver: function () {
                this.imageObserver = new IntersectionObserver((entries, imgObserver) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            const lazyImage = entry.target
                            lazyImage.src = lazyImage.dataset.src
                        }
                    })
                });
            },
        }
    });

    // for compilation of html coming from server
    Vue.component('vnode-injector', {
        functional: true,
        props: ['nodes'],
        render(h, {props}) {
            return props.nodes;
        }
    });
});
