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
                <a href="#" target="_blank" class="menu-link px-2">About</a>
            </li>
            <li class="menu-item">
                <a href="#" target="_blank" class="menu-link px-2">Support</a>
            </li>
            <li class="menu-item">
                <a href="#" target="_blank" class="menu-link px-2">Purchase</a>
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