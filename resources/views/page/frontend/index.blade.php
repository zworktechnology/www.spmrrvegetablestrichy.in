@extends('layout.frontend.guest')
@section('content')
    <!--Main Slider Start-->
    <section class="main-slider clearfix" id="home">
        <div class="swiper-container thm-swiper__slider"
            data-swiper-options='{"slidesPerView": 1, "loop": true,
                "effect": "fade",
                "pagination": {
                "el": "#main-slider-pagination",
                "type": "bullets",
                "clickable": true
                },
                "navigation": {
                "nextEl": "#main-slider__swiper-button-next",
                "prevEl": "#main-slider__swiper-button-prev"
                },
                "autoplay": {
                "delay": 5000
                }}'>
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="image-layer" style="background-image: url(https://images.unsplash.com/photo-1505692794401-b371fa865622?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80);">
                    </div>
                    <!-- /.image-layer -->
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <p class="main-slider__sub-title">Embracing nature's finest</p>
                                    <h2 class="main-slider__title">Agriculture.</h2>
                                    <div class="main-slider__btn-box">
                                        <a href="#products" class="thm-btn main-slider__btn">Discover More <i
                                                class="icon-right-arrow"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="image-layer" style="background-image: url(https://images.unsplash.com/photo-1518843875459-f738682238a6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1142&q=80);">
                    </div>
                    <!-- /.image-layer -->
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <p class="main-slider__sub-title">Embracing nature's finest</p>
                                    <h2 class="main-slider__title">Agriculture.</h2>
                                    <div class="main-slider__btn-box">
                                        <a href="#products" class="thm-btn main-slider__btn">Discover More <i
                                                class="icon-right-arrow"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-pagination" id="main-slider-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="main-slider__nav">
                <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                    <i class="icon-right-arrow"></i>
                </div>
                <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                    <i class="icon-right-arrow"></i>
                </div>
            </div>

        </div>
    </section>
    <!--Main Slider End-->

    <!--Feature One Start-->
    <section class="feature-one">
        <div class="container">
            <div class="row">
                <!--Feature One Single Start-->
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="feature-one__single">
                        <div class="feature-one__icon">
                            <span class="icon-farm"></span>
                        </div>
                        <div class="feature-one__content">
                            <h3 class="feature-one__title">the Best Quality <br> Standards</h3>
                        </div>
                    </div>
                </div>
                <!--Feature One Single End-->
                <!--Feature One Single Start-->
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="feature-one__single">
                        <div class="feature-one__icon">
                            <span class="icon-agriculture"></span>
                        </div>
                        <div class="feature-one__content">
                            <h3 class="feature-one__title">a Smart organic <br> Products</h3>
                        </div>
                    </div>
                </div>
                <!--Feature One Single End-->
                <!--Feature One Single Start-->
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="feature-one__single">
                        <div class="feature-one__icon">
                            <span class="icon-harvest"></span>
                        </div>
                        <div class="feature-one__content">
                            <h3 class="feature-one__title">Natural Healthy <br> products</h3>
                        </div>
                    </div>
                </div>
                <!--Feature One Single End-->
            </div>
        </div>
    </section>
    <!--Feature One End-->

    <!--About One Start-->
    <section class="about-one" id="about">
        <div class="about-one-shape-1 float-bob-x">
            <img src="{{ asset('assets/frontend/images/shapes/about-one-shape-1.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-one__left">
                        <div class="section-title text-left">
                            {{-- <span class="section-title__tagline">About Us</span> --}}
                            <h2 class="section-title__title">About Us</h2>
                            <div class="section-title__icon">
                                <img src="{{ asset('assets/frontend/images/icon/section-title-icon-1.png') }}"
                                    alt="">
                            </div>
                        </div>
                        <p class="about-one__text-1">We’ve 20 years of agriculture farming experience.</p>
                        <p class="about-one__text-2">Welcome to our vegetable paradise! Explore a bountiful world of fresh, locally sourced produce that celebrates the goodness of Mother Nature. Discover a delightful assortment of vibrant, nutrient-rich vegetables, handpicked and cultivated with love. Immerse yourself in the flavors and colors of our farm-fresh veggies, grown sustainably to nourish both body and soul. Whether you're a seasoned chef or a home cook, our vegetable site is your ultimate destination for culinary inspiration and the freshest ingredients straight from the earth. Join us on this veggie-filled journey and savor the taste of nature's goodness in every bite.</p>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-one__right">
                        <div class="about-one__img-box wow slideInRight" data-wow-delay="100ms"
                            data-wow-duration="2500ms">
                            <div class="about-one__img-one">
                                <img src="{{ asset('assets/frontend/images/resources/about-one-img-1.jpg') }}"
                                    alt="">
                            </div>
                            <div class="about-one__img-two">
                                <img src="{{ asset('assets/frontend/images/resources/about-one-img-2.jpg') }}"
                                    alt="">
                            </div>
                            <div class="about-one__video-link">
                                <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="video-popup">
                                    <div class="about-one__video-icon">
                                        <span class="fa fa-play"></span>
                                        <i class="ripple"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About One End-->

    <!--Services One Start-->
    <section class="services-one" id="products">
        <div class="services-one__bg" style="background-image: url(assets/images/shapes/services-one-shape-1.png);">
        </div>
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Products</span>
                <h2 class="section-title__title">Our Products</h2>
                <div class="section-title__icon">
                    <img src="{{ asset('assets/frontend/images/icon/section-title-icon-1.png') }}" alt="">
                </div>
            </div>
            <div class="row">
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/beans1.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="agriculture-products.html">Beans</a></h3>
                            <p class="services-one__text"></p>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/chilly.jpeg') }}" alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="organic-products.html">Green Chilly</a></h3>
                            <p class="services-one__text"></p>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="300ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/chow chow image.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="fresh-vegetables.html">Chou Chou</a></h3>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="400ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/ginger.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="dairy-products.html">Ginger</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
            </div>

            <div class="row mt-4">
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/onion1.jpg') }}"
                                    alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="agriculture-products.html">Onion</a></h3>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/potato.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="organic-products.html">Potato</a></h3>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="300ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/tomato.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="fresh-vegetables.html">Tomato</a></h3>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
                <!--Services One Single Start-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="400ms">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="{{ asset('assets/frontend/images/products/veg2.jpg') }}"
                                    alt="">
                            </div>
                            <div class="services-one__icon">
                                <span class="icon-vegetables"></span>
                            </div>
                        </div>
                        <div class="services-one__content">
                            <h3 class="services-one__title"><a href="dairy-products.html">Other Vegtables</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
            </div>
        </div>
    </section>
    <!--Services One End-->

    <!--Brand One Start-->
    <section class="brand-one d-none">
        <div class="brand-one__inner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="brand-one__carousel thm-owl__carousel owl-theme owl-carousel"
                            data-owl-options='{
                                "margin": 0,
                                "smartSpeed": 700,
                                "loop":true,
                                "autoplay": 6000,
                                "nav":false,
                                "dots":false,
                                "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                                "responsive":{
                                    "0":{
                                        "items":1
                                    },
                                    "600":{
                                        "items":2
                                    },
                                    "800":{
                                        "items":3
                                    },
                                    "1024":{
                                        "items": 4
                                    },
                                    "1200":{
                                        "items": 5
                                    }
                                }
                            }'>
                            <!--Brand One Single-->
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="{{ asset('assets/frontend/images/brand/brand-1-1.png') }}" alt="">
                                </div>
                            </div>
                            <!--Brand One Single-->
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="{{ asset('assets/frontend/images/brand/brand-1-2.png') }}" alt="">
                                </div>
                            </div>
                            <!--Brand One Single-->
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="{{ asset('assets/frontend/images/brand/brand-1-3.png') }}" alt="">
                                </div>
                            </div>
                            <!--Brand One Single-->
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="{{ asset('assets/frontend/images/brand/brand-1-4.png') }}" alt="">
                                </div>
                            </div>
                            <!--Brand One Single-->
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="{{ asset('assets/frontend/images/brand/brand-1-5.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Brand One End-->

    <!--Unbeatable One Start-->
    <section class="unbeatable-one">
        <div class="unbeatable-one__bg  jarallax" data-jarallax="" data-speed="0.2" data-imgposition="50% 0%"
            style="background-image: url(assets/images/backgrounds/unbeatable-one-bg.jpg);"></div>
        <div class="container">
            <div class="unbeatable-one__inner text-center">
                <div class="unbeatable-one__content">
                    <div class="unbeatable-one__shape-one wow slideInLeft" data-wow-delay="100ms"
                        data-wow-duration="2500ms">
                        <img src="{{ asset('assets/frontend/images/shapes/unbeatable-shape-1.png') }}" alt=""
                            class="float-bob-y">
                    </div>
                    <div class="unbeatable-one__shape-two wow slideInRight" data-wow-delay="100ms"
                        data-wow-duration="2500ms">
                        <img src="{{ asset('assets/frontend/images/shapes/unbeatable-shape-2.png') }}" alt=""
                            class="float-bob-y">
                    </div>
                    <p class="unbeatable-one__tagline">We’re Selling Healthy Products</p>
                    <h3 class="unbeatable-one__title">Unbeatable Organic and
                        <br> Agriculture Products
                    </h3>
                    <div class="unbeatable-one__btn-box">
                        <a href="#products" class="thm-btn unbeatable-one__btn">Discover More <i
                                class="icon-right-arrow"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Unbeatable One End-->





    <!--Contact One Start-->
    <section class="contact-one pb-5 pt-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="contact-one__left">
                        <div class="section-title text-left">
                            <span class="section-title__tagline">Contact Now</span>
                            <h2 class="section-title__title">Get in touch now</h2>
                            <div class="section-title__icon">
                                <img src="assets/images/icon/section-title-icon-1.png" alt="">
                            </div>
                        </div>
                        {{-- <p class="contact-one__text"></p> --}}
                        <ul class="list-unstyled contact-one__contact-list">
                            <li>
                                <div class="icon">
                                    <span class="fas fa-phone-alt"></span>
                                </div>
                                <div class="content">
                                    <p>Have Question?</p>
                                    <h4><a href="tel:9288009850">Free +92 (8800)-9850</a></h4>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="fas fa-envelope"></span>
                                </div>
                                <div class="content">
                                    <p>Write Email</p>
                                    <h4><a href="mailto:needhelp@company.com">needhelp@company.com</a></h4>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="fas fa-map-marker"></span>
                                </div>
                                <div class="content">
                                    <p>Visit Now</p>
                                    <h4>88 Broklyn Golden Street. USA</h4>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7">
                    <div class="contact-one__right">
                        <div class="contact-one__bg float-bob-x"
                            style="background-image: url(assets/images/shapes/contact-one-shape-1.png);"></div>
                        <div class="row">
                            <div class="contact-one__form-box">
                                <form action="assets/inc/sendemail.php" class="contact-one__form contact-one-validated"
                                    novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="contact-one__input-box">
                                                <input type="text" placeholder="Your Name" name="name">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="contact-one__input-box">
                                                <input type="email" placeholder="Email Address" name="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="contact-one__input-box text-message-box">
                                                <textarea name="message" placeholder="Write a Message"></textarea>
                                            </div>
                                            <div class="contact-one__btn-box">
                                                <a href="about.html" class="thm-btn contact-one__btn">Send a
                                                    Message
                                                    <i class="icon-right-arrow"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Contact One End-->

    <!--Blog One Start-->
    <section class="blog-one d-none" id="blog">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">From the Blog Post</span>
                <h2 class="section-title__title">Latest News & Articles</h2>
                <div class="section-title__icon">
                    <img src="assets/images/icon/section-title-icon-1.png" alt="">
                </div>
            </div>
            <div class="row">
                <!--Blog One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                    <div class="blog-one__single">
                        <div class="blog-one__img">
                            <img src="{{ asset('assets/frontend/images/blog/blog-one-1.jpg') }}" alt="">
                            <div class="blog-one__date">
                                <span>28</span>
                                <p>Aug</p>
                            </div>
                        </div>
                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <a href="blog-details.html"><i class="fas fa-user-circle"></i>Admin</a>
                                </li>
                                <li>
                                    <a href="blog-details.html"><i class="fas fa-comments"></i>2 Comments</a>
                                </li>
                            </ul>
                            <h3 class="blog-one__title"><a href="blog-details.html">Why Agriculture & Eco is for
                                    the
                                    Envoirment</a></h3>
                        </div>
                    </div>
                </div>
                <!--Blog One Single End-->
                <!--Blog One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                    <div class="blog-one__single">
                        <div class="blog-one__img">
                            <img src="{{ asset('assets/frontend/images/blog/blog-one-2.jpg') }}" alt="">
                            <div class="blog-one__date">
                                <span>28</span>
                                <p>Aug</p>
                            </div>
                        </div>
                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <a href="blog-details.html"><i class="fas fa-user-circle"></i>Admin</a>
                                </li>
                                <li>
                                    <a href="blog-details.html"><i class="fas fa-comments"></i>2 Comments</a>
                                </li>
                            </ul>
                            <h3 class="blog-one__title"><a href="blog-details.html">Wheat Harvest Organic Gather
                                    nice Moment</a></h3>
                        </div>
                    </div>
                </div>
                <!--Blog One Single End-->
                <!--Blog One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="300ms">
                    <div class="blog-one__single">
                        <div class="blog-one__img">
                            <img src="{{ asset('assets/frontend/images/blog/blog-one-3.jpg') }}" alt="">
                            <div class="blog-one__date">
                                <span>28</span>
                                <p>Aug</p>
                            </div>
                        </div>
                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <a href="blog-details.html"><i class="fas fa-user-circle"></i>Admin</a>
                                </li>
                                <li>
                                    <a href="blog-details.html"><i class="fas fa-comments"></i>2 Comments</a>
                                </li>
                            </ul>
                            <h3 class="blog-one__title"><a href="blog-details.html">Agriculture Matters to the
                                    Future of World</a></h3>
                        </div>
                    </div>
                </div>
                <!--Blog One Single End-->
            </div>
        </div>
    </section>
    <!--Blog One End-->

    <!--Cta One Start-->
    <section class="cta-one">
        <div class="cta-one__bg" data-jarallax="" data-speed="0.2" data-imgposition="50% 0%"
            style="background-image: url(assets/images/backgrounds/cta-one-bg.jpg);"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="cta-one__inner">
                        <div class="cta-one__left">
                            <div class="cta-one__icon">
                                <span class="icon-agriculture-2"></span>
                            </div>
                            <h3 class="cta-one__title">We’re  <br> One Of The Best
                            </h3>
                        </div>
                        <div class="cta-one__right">
                            <a href="#products" class="thm-btn cta-one__btn">Discover More <i
                                    class="icon-right-arrow"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Cta One End-->
@endsection
