<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">{{date('Y')}}&copy;</span>
            <a href="#" target="_blank" class="text-gray-800 text-hover-primary">loigiai-AI</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu--> 
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="https://www.facebook.com/H%E1%BB%8Dc-c%C3%B9ng-Ch%E1%BB%8B-Ong-Ch%C3%BAa-AI-100307193000519" target="_blank" class="menu-link px-2">
                    <img width="34" src="/images/share_facebook.png">
                </a>
            </li>
            <li class="menu-item">
                <a href="#" target="_blank" class="menu-link px-2">
                    <img width="29" src="/images/share_ytb.png">
                </a>
            </li>
            <li class="menu-item">
                <a href="https://www.tiktok.com/@loigiaiai.com?_t=8ZyABqr1Qw6&_r=1" target="_blank" class="menu-link px-2">
                    <img width="34" src="/images/share_tiktok.png">
                </a>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div>
<script>
    function loading() {
        $('.bg-loader').show();
    }

    function unloading() {
        $('.bg-loader').hide();
    }
    window.MathJax = {
        tex: {
            inlineMath: [
                ['$', '$'],
                ['\\(', '\\)']
            ]
        },
        svg: {
            fontCache: 'global'
        }
    };

    (function() {
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js';
        script.async = true;
        document.head.appendChild(script);
    })();
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TBCLTM046D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TBCLTM046D');
</script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script>
    var socket = io('https://socket.cmsedu.vn/', {
        transports: ['websocket', 'polling', 'flashsocket'],
        secure: true,
        allowEIO3: true
    });
    console.log(socket)
    socket.on('call_end', function(msg) {
        console.log(msg)
    });
</script>