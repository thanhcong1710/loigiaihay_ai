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
</script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdn.socket.io/3.1.3/socket.io.min.js" integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous"></script>
<script>
  var socket = io('https://socket.cmsedu.vn', {transports: ['websocket', 'polling', 'flashsocket'],secure: true});
  console.log(socket)
  
  socket.on('call_end', function(msg) {
    console.log(msg);
  });
</script>