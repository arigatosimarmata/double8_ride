@extends('templates.master')
@section('head')

<script type="text/javascript" src="{{ URL::asset('resources/assets/js/jquery.jcarousel.min.js') }}"></script>
<script>
    var flavourLimit    = 0;
    var selectLimit     = 0;

    var package         = {
        packageID: 0,
        packageName: '',
        packageCategoryID: 0,
        packagePrice: 0,
        flavourID: [0,0,0,0],
        flavourQuantity: [0,0,0,0],
        selectorDefault: [0,1,2,3],
        selectorUsed: [],
        createSelector: function (flavID, parent) {
            var selector    = this.getSelector();
            if(selector === false) return false;
            this.flavourID[selector]    = flavID;
            parent.append("<select class='flavour-quantity' id='combo-"+selector+"'></select>");
            package.createLimit(selector);
            package.selectorUsed.push(selector);
            package.updateQuantity($("#combo-"+selector));
            return true;
        },
        createLimit: function(index) {
            var selector    = $("#combo-"+index);
            for(var a=1;a<=4;a++)
                selector.append("<option value='"+a+"'>"+a+"</option>");
        },
        removeSelector: function (flavID) {
            var index   = jQuery.inArray(flavID, this.flavourID);
            this.flavourID[index]       = 0;
            this.flavourQuantity[index] = 0;
            this.selectorUsed.splice(jQuery.inArray(index, this.selectorUsed), 1);
            $("#combo-"+index).remove();
        },
        reset: function () {
            for(var a = 0;a<package.selectorUsed.length;a++) {
                $("#combo-"+package.selectorUsed[a]).remove();
            }
            this.selectorUsed   = [];
            this.flavourID      = [0,0,0,0];
            this.flavourQuantity= [0,0,0,0];
            $(".everyday-special-flavour:checked").prop('checked', false);
        },
        getSelector: function() {
            var difference = [];

            jQuery.grep(package.selectorDefault, function(el) {
                    if (jQuery.inArray(el, package.selectorUsed) == -1) difference.push(el);
            });
            if(difference.length > 0) return difference[0];
            else return false;
        },
        updateQuantity: function (selector) {
            var value   = selector.val();
            var index   = selector.attr('id').split('-')[1];

            this.flavourQuantity[index] = value;
        }
    }

    $(function(){
        jQuery.fn.rotate = function(degrees, delay, before, callback) {
            before.call();
            delay   = delay/1000;
            $(this).css({
                            '-moz-transition' : 'all '+delay+'s ease',
                            '-webkit-transition' : 'all '+delay+'s ease',
                            '-o-transition' : 'all '+delay+'s ease',
                            'transition' : 'all '+delay+'s ease'
            });
            $(this).css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
                         '-moz-transform' : 'rotate('+ degrees +'deg)',
                         '-ms-transform' : 'rotate('+ degrees +'deg)',
                         'transform' : 'rotate('+ degrees +'deg)'});

            setTimeout(function () {
                callback.call();
            }, delay*1000);
            return $(this);
        };

        $('.month-tab').click(function() {
            if($(this).parent().hasClass('current')) return false;

            var current = $(this).parent().siblings('.current');

            destination = $(this).attr('href');
            splitDestination = destination.split('-');
            category = splitDestination[2];
            subcategory = splitDestination[3];

            current.removeClass('current').addClass('grayscale');
            $(this).parent().removeClass('grayscale').addClass('current');

            var selector    = $(this).closest('.select-flavour').find('.flavour-area');

            selector.fadeOut().promise().done(function() {
                $('#flavour-area-'+category+'-'+subcategory).fadeIn();
            });
            package.packageCategoryID   = subcategory; //id sub categorynya di sini
            package.reset();
            return false;
        });

        $('.big-separator:first').siblings().find('.month-tab:first').click();

        $('.big-separator').click(function(){
            var id              = $(this).attr('id').split('-')[2];
            var packageName     = $(this).attr('data-package-name');
            flavourLimit        = parseInt($(this).attr('flavour_limit')) + 1;
            var packagePrice    = $(this).attr('data-price');
            var separator       = $(this);
            var separatorImg    = $(this).find('img');
            var slider          = $(this).siblings('.slidedown');

            if(separator.hasClass('curr')){
                var rotation    = 0;
                var delay       = 500;//ms second
                separatorImg.rotate(rotation, delay, function () {
                    separatorImg.attr('src', '{{ URL::asset('resources/assets/images/separator-close.png') }}');
                });

                if(slider.stop().slideUp()){
                    separator.removeClass('curr');
                }
            }
            else{
                //UNTUK MENUTUP SEMUA SLIDEDOWN
                $('.slidedown').slideUp();
                $('.big-separator').removeClass('curr');
                $('.big-separator').find('img').rotate(rotation, delay, function () {
                    $('.big-separator').find('img').attr('src', '{{ URL::asset('resources/assets/images/separator-close.png') }}');
                });

                //MEMBUKA SLIDEDOWN YANG DIKLIK
                var rotation    = 90;
                var delay       = 500;//ms second
                separatorImg.rotate(rotation, delay, function () {
                    separatorImg.attr('src', '{{ URL::asset('resources/assets/images/separator-open.png') }}');
                });
                if(slider.stop().slideDown()){
                    separator.addClass('curr');
                }
                $(this).siblings().find('.month-tab:first').click();
            }
            package.packageID   = id;
            package.packageName = packageName;
            package.packagePrice = packagePrice;
            package.reset();
            return false;
        });
        $('.big-separator:first').trigger('click');
    });
    //UNTUK CAROUSEL
    $(document).ready(function() {
        var current = 1;
        $(".product-detail-tab a").click(function () {
            var dest    = $(this).attr('class');
            dest        = dest.split('-')[2];

            $(".detail-tab-"+current).parent().removeClass('product-detail-tab-active');
            $(".detail-tab-"+current).find('div').hide();
            $(".tab-"+current).hide();


            $(".detail-tab-"+dest).parent().addClass('product-detail-tab-active');
            $(".detail-tab-"+dest).find('div').show();
            $(".tab-"+dest).show();
            current = dest;
            return false;
        });

        $(".img-thumb").click(function(){
            var img 		= $(this).attr('href');
            var img_full 	= $(this).attr('data');
            var stage       = $(this).parent().parent().parent().parent().siblings('.stage');

            stage.css({'background-image': 'url('+img+')'});

            return false;
        });

//        $(".img-thumb:first").trigger('click');

        $('.carousel').jcarousel();
        $('.carousel-navigation.prev')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.carousel-navigation.next')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        $('.everyday-special-flavour').change(function() {
            var flavourID       = $(this).attr('flavour-id');
            var flavourName     = $(this).attr('flavour-name');
            var code            = $(this).attr('id').split('-');

            var flavArea        = $(this).parent().parent('.select-flavour-area');

            if(this.checked){//disini kalo ke check
                var status  = package.createSelector(flavourID, flavArea);
                if(!status) $(this).prop('checked', false);

            } else {//disini uncheck
                package.removeSelector(flavourID);
            }
            console.log(package.selectorUsed);
            console.log(package.flavourID);
        });

        $(document).on('change', '.flavour-quantity', function() {
            package.updateQuantity($(this));
        });
    });

    //UNTUK ADD TO CART
    $(function() {
        $('.buy-daily-package').click(function() {
            var product_id   = 2;
            var temp    = {
                packageID   : package.packageID,
                packageName : package.packageName,
                categoryID  : package.packageCategoryID,
                flavour     : package.flavourID,
                quantity    : package.flavourQuantity,
                price       : package.packagePrice
            };

            $.ajax({
                type: 'POST',
                url: '{{ URL::to('add-to-cart') }}',
                data: {
                    productID   : product_id,
                    value       : temp
                },
                success: function (response) {
                    response    = $.parseJSON(response);
                    var status  = response.status;
                    var message = response.message;
                    if(status) {
                        cart.update('{{ URL::route('process_cart_update') }}', $("#minicart-ul"), $(".minicart-redbox"), $(".minicart-summary_price"));
                        $("html, body").animate({
                            scrollTop: 0
                        }, 700);
                        if($(".empty-cart-line").length) $(".empty-cart-line").remove();
                        $('.minicart-list-container').show();
                        $('.minicart-list-added').show();
                        // check kalau success. package.reset(); update cart;
                    } else {
                        // gagal
                        alert(message);
                    }
                }
            });
        });
    });

</script>
@stop
@section('content')
    <div class="container">
        <div class="page-title">
            <hr class="page-title-line">
            <div class="page-title-background" style="background-image: url({{ URL::asset('resources/assets/images/title-background.png') }})">
                <div class="page-title-text uppercase">
                    <span>everyday</span>
                    special
                </div>
            </div>
        </div>
    </div>
    <?php $a = 0; ?>
    @foreach($everyday_package as $list)
        <div id="slidedown-area-{{ $list->id }}">
            <div id="big-separator-{{ $list->id }}" class="big-separator uppercase" flavour_limit="{{ $list->flavour_limit }}" data-package-name="{{$list->name}}" data-price="{{ $list->price }}">
                <div class="container">
                    <img class="separator img" id="separator-img-{{ $list->id }}" src="{{ URL::asset('resources/assets/images/separator-close.png') }}">
                    <div class="everyday-special-separator-text">
                        {{ $list->name.' (IDR '.number_format($list->price, 0).')' }}
                        <span>{{ $list->subtitle }}</span>
                    </div>
                </div>
            </div>
            <div id="slidedown-{{ $list->id }}" class="container slidedown everyday-slidedown">
                <div class="col-md-6 col-xs-12 no-gutters everyday-special-carousel">
                    <div class="stage" data-aaa="abcde" style="background-image:url('{{ $list->images()->where('as_default',1)->first() ? URL::asset('resources/assets/uploads/products/everyday/400/'.$list->images()->where('as_default',1)->first()->image) : ''}}')"></div>
                    <div class="thumb">
                        <a href="#" class="carousel-navigation prev"></a>
                        <a href="#" class="carousel-navigation next"></a>
                        <div class="carousel">
                            <ul>
                                @foreach($list->images as $listImage)
                                    <li>
                                        <a class="img-thumb" href="{{URL::asset('resources/assets/uploads/products/everyday/400/'.$listImage->image)}}">
                                            <div class="everyday-special-carousel-small" style="background-image:url('{{ URL::asset('resources/assets/uploads/products/everyday/400/'.$listImage->image) }}')"></div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 no-gutters">
                    <div class="everyday-special-description">
                        <span class="uppercase">{{ $list->title }}</span>
                        {!! $list->description !!}
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 no-gutters inlineblock select-flavour">

                    <div class="everyday-special-select-month">
                        <center>
                        <span class="category-holder">
                        <?php $b = 0; ?>
                        @foreach($list->category as $listCategory)
                            <div class="everyday-special-month grayscale uppercase">
                                <a href="flavour-area-{{$list->id}}-{{$listCategory->id}}" id="month-tab-{{$list->id}}-{{$listCategory->id}}" class="month-tab">
                                    <span>{{ $listCategory->name }}</span>
                                </a>
                            </div>
                            <?php $b++; ?>
                        @endforeach
                        </span>
                        </center>
                    </div>

                    <?php $c = 0; ?>
                    @foreach($list->category as $listCategory)
                        <div id="flavour-area-{{ $list->id }}-{{$listCategory->id}}" class="flavour-area" style="{{ $c==0 ? 'display:block' : 'display:none' }}">
                            <?php $d = 0; ?>
                            <div class="select-flavour-row col-md-12 col-xs-12 no-gutters">
                            @foreach($listCategory->flavour->flavour as $listFlavour)
                                    <div class="col-md-3 col-xs-4 no-gutters select-flavour-area">
                                        <div class="everyday-special-select-flavour uppercase">
                                            <input type="checkbox" name="" class="field everyday-special-flavour unselected"
                                                    flavour-id="{{ $listFlavour['id'] }}"
                                                    flavour-name="{{ $listFlavour['flavName'] }}"
                                                    id="{{ $list->id.'-'.$listCategory->id.'-'.$listFlavour['id']  }}"
                                                >
                                            <label for="{{$list->id.'-'.$listCategory->id.'-'.$listFlavour['id']}}"><span></span>{{ $listFlavour['flavName'] }}</label>
                                        </div>
                                    </div>
                                @if($d!= 0 && $d%4==0)
                                    </div>
                                    <div class="select-flavour-row">
                                @endif
                                <?php $d++ ?>
                            @endforeach
                            </div>
                            {!! Form::submit('BUY', array('class' => 'brown-button buy-daily-package')) !!}
                        </div>
                        <?php $c++ ?>
                    @endforeach
                </div>
            </div>
        </div>
        <?php $a++; ?>
    @endforeach


@stop