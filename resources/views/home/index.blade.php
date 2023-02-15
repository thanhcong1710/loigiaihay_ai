<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>{{isset($meta_title) ? $meta_title : "Lời giải AI, lời giải trí tuệ nhân tạo các môn toán, văn, anh, lý, hóa, sinh, sử và địa lý"}}</title>
    <meta name="description" content="{{isset($meta_description) ? $meta_description :'Lời giải AI, lời giải trí tuệ nhân tạo,lời giải chi tiết giúp soạn bài đến lớp các môn toán, văn, anh, lý, hóa, sinh, sử và địa lý'}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Lời giải AI, lời giải trí tuệ nhân tạo, soạn bài đến lớp, luyện tập, kiểm tra, giải thích, toán, văn, ngoại ngữ, anh, lý, hóa, sinh, sử, địa" />
    <meta name="robots" content="index,follow" />
    <meta property="og:locale" content="vi" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Lời giải AI, lời giải trí tuệ nhân tạo,lời giải chi tiết giúp soạn bài đến lớp các môn toán, văn, anh, lý, hóa, sinh, sử và địa lý" />
    <meta property="og:url" content="https://loigiaiai.com" />
    <meta property="og:site_name" content="Lời giải AI" />
    <meta property="og:image" content="https://loigiaiai.com/themes/slick/img/gpt/banner-ai-gpt.jpeg" />
    <link rel="image_src" type="image/jpeg" href="https://loigiaiai.com/themes/slick/img/gpt/banner-ai-gpt.jpeg">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="themes/slick/img/2.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="themes/slick/css/bootstrap.min.css">
    <link rel="stylesheet" href="themes/slick/css/animate.css">
    <link rel="stylesheet" href="themes/slick/css/LineIcons.css">
    <link rel="stylesheet" href="themes/slick/css/owl.carousel.css">
    <link rel="stylesheet" href="themes/slick/css/owl.theme.css">
    <link rel="stylesheet" href="themes/slick/css/magnific-popup.css">
    <link rel="stylesheet" href="themes/slick/css/nivo-lightbox.css">
    <link rel="stylesheet" href="themes/slick/css/main.css">
    <link rel="stylesheet" href="themes/slick/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <!-- Header Section Start -->
    <header id="home" class="hero-area">
        <div class="overlay">
            <span></span>
            <span></span>
        </div>
        <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbar">
            <div class="container">
                <a href="#" class="navbar-brand"><img src="themes/slick/img/logo.png" alt="" style="width:186px"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="lni-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto w-100 justify-content-end">
                        <li class="nav-item">
                            <a class="btn btn-singin" href="{{route('admin.login')}}">ĐĂNG NHẬP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.register')}}">ĐĂNG KÝ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row space-100">
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="contents">
                        <h2 class="head-title">Hỏi đáp với ChatGPT</h2>
                        <p>Giải đáp mọi câu hỏi của bạn với công nghệ trí tuệ nhân tạo Chat GPT (Chat Generative Pre-training Transformer)</p>
                        <div class="header-button">
                            <a href="{{route('admin.register')}}" rel="nofollow" class="btn btn-border-filled">Dùng thử miễn phí ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12 p-0">
                    <div class="intro-img">
                        <img src="themes/slick/img/gpt/banner-ai-gpt.jpeg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->


    <!-- Services Section Start -->
    <section id="services" class="section">
        <div class="container">

            <div class="row">
                <!-- Start Col -->
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="services-item text-center">
                        <div class="icon">
                            <i class="fa-solid fa-atom"></i>
                        </div>
                        <h4>Chat GPT</h4>
                        <p style="text-align: justify;">Trả lời mọi câu hỏi của bạn với công nghệ trí tuệ nhân tạo ChatGPT.</p>
                    </div>
                </div>
                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="services-item text-center">
                        <div class="icon">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <h4>Tài liệu</h4>
                        <p style="text-align: justify;">Lời giải chi tiết giúp soạn bài đến lớp các môn toán, ngữ văn, tiếng anh, vật lý, hóa học, sinh học cho tất cả các khối lớp.</p>
                    </div>
                </div>
                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="services-item text-center">
                        <div class="icon">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <h4>Luyện tập</h4>
                        <p style="text-align: justify;">Kho bài tập online với hàng chục nghìn câu hỏi các môn môn toán, ngữ văn, tiếng anh, vật lý, hóa học, sinh học cho tất cả các khối lớp.</p>
                    </div>
                </div>
                <!-- End Col -->

            </div>
        </div>
    </section>
    <!-- Services Section End -->



    <!-- Business Plan Section Start -->
    <section id="business-plan">
        <div class="container">

            <div class="row">
                <!-- Start Col -->
                <div class="col-lg-6 col-md-12 pl-0 pt-70 pr-5">
                    <div class="business-item-img">
                        <img src="themes/slick/img/business/business-img.png" class="img-fluid" alt="">
                    </div>
                </div>
                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-6 col-md-12 pl-4">
                    <div class="business-item-info">
                        <h3>Loigiai AI - Giải pháp tổng thể hỗ trợ hoạt động dạy và học</h3>
                        <p style="text-align: justify;">Liên tục phân tích dữ liệu học của học sinh từ đó đưa ra nội dung phù hợp, giúp các bạn học ít tiến bộ nhiều.
                            Ngân hàng câu hỏi và bài giảng các môn Toán, Ngữ văn, Tiếng anh, Vật lý, Hóa học, Sinh học cá nhân hóa cho từng học sinh.
                            Học mọi nơi mọi lúc, trên mọi thiết bị ứng dụng, giúp bạn có thể thiết lập kế hoạch học tập sao cho phù hợp với thời gian riêng của bản thân.</p>

                        <a class="btn btn-common" href="{{route('admin.register')}}">Đăng ký ngay</a>
                    </div>
                </div>
                <!-- End Col -->

            </div>
        </div>
    </section>
    <!-- Business Plan Section End -->

    <footer>
        <!-- Footer Area Start -->
        <section id="footer-Content" style="padding-top:0px;">
            <div class="copyright" style="margin-top:0px;">
                <div class="container">
                    <!-- Star Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="site-info text-center">
                                <p>Crafted by <a href="https://loigiaiai.com" rel="nofollow">Loigiai-AI</a></p>
                            </div>

                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- Copyright End -->
        </section>
        <!-- Footer area End -->

    </footer>
    <!-- Footer Section End -->


    <!-- Go To Top Link -->
    <a href="#" class="back-to-top">
        <i class="lni-chevron-up"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="themes/slick/js/jquery-min.js"></script>
    <script src="themes/slick/js/popper.min.js"></script>
    <script src="themes/slick/js/bootstrap.min.js"></script>
    <script src="themes/slick/js/owl.carousel.js"></script>
    <script src="themes/slick/js/jquery.nav.js"></script>
    <script src="themes/slick/js/scrolling-nav.js"></script>
    <script src="themes/slick/js/jquery.easing.min.js"></script>
    <script src="themes/slick/js/nivo-lightbox.js"></script>
    <script src="themes/slick/js/jquery.magnific-popup.min.js"></script>
    <script src="themes/slick/js/form-validator.min.js"></script>
    <script src="themes/slick/js/contact-form-script.js"></script>
    <script src="themes/slick/js/main.js"></script>
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const register_code = urlParams.get('register_code');
            if (register_code) {
                setCookie('lg_register_code', register_code, 3);
            }
        });

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TBCLTM046D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-TBCLTM046D');
    </script>
</body>

</html>