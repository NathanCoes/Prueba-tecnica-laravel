
        <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
                </div>
            </footer>
        </div>
        <!-- REQUIRED SCRIPTS -->
        <!-- Bootstrap -->
        <script src="{{ asset("js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset("js/jquery.overlayScrollbars.min.js") }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset("js/adminlte.js") }}"></script>
        @yield('extraJS')
    </body>
</html>
