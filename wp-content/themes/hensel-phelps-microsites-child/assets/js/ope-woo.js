(function ($) {

    var isHeaderCartRelated = function ($target, $cart, $cart_button) {
        var isMenuButtoRelated = $.contains($cart_button[0], $target[0]) || $target.is($cart_button);
        var isCartContentRelated = $.contains($cart[0], $target[0]) || $target.is($cart);

        return isMenuButtoRelated || isCartContentRelated
    };


    var addCloseCartBind = function ($cart, $cart_button, $menu) {
        $('body').on('mouseover.ope-wooo', function () {
            var $target = $(event.target);
            var related = isHeaderCartRelated($target, $cart, $cart_button) || $target.is($menu);
            if (!related) {
                $('body').off('mouseover.ope-wooo');
                $cart.fadeOut();
            }


        });
    };

    var positionateWooCartItem = function () {
        var $menu = $('#drop_mainmenu');
        var $cart_button = $menu.find('li.ope-menu-cart');
        var $cart = $cart_button.find('.ope-woo-header-cart');
        $menu.parent().append($cart);
        var $menuItems = $menu.find('li').not($cart_button);

        var position = /*$menu.closest('[data-sticky]') ? "fixed" :*/ "absolute";


        $cart_button.off().on('mouseover', function (event) {

            if ($cart.children().length === 0) {
                return;
            }

            $menuItems.trigger('mouseleave');

            addCloseCartBind($cart, $cart_button, $menu);
            var top = $cart_button[0].getBoundingClientRect().top + $cart_button.height();

            if (position === "absolute") {
                top = top - jQuery('body').offset().top;
            }

            $cart.css({
                'position': position,
                'z-index': '100000',
                'top': top,
                'left': $cart_button.offset().left + $cart_button.width() + 8,
            });
            $cart.fadeIn();
        });


        $( '.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:eq(0) .wp-post-image' ).on( 'load', function() {
            var $image = $( this );

            if ( $image ) {
                setTimeout( function() {
                    var setHeight = $image.closest( '.woocommerce-product-gallery__image' ).height();
                    var $viewport = $image.closest( '.flex-viewport' );

                    if ( setHeight && $viewport ) {
                        $viewport.height( setHeight );
                    }
                }, 500 );
            }
        } ).each( function() {
            if ( this.complete ) {
                $( this ).load();
            }
        } );
    };

    jQuery(document).ready(positionateWooCartItem);


})(jQuery);
