</main>

<!--   Core JS Files   -->
<script src="{{ asset('assets/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script>
    document.getElementById('sidenavCollapseButton').addEventListener('click', function() {
        var sidenav = document.getElementById('sidenav-main');
        var content = document.getElementById('main-content');
        var nav = document.getElementById('navbarBlur');

        sidenav.classList.toggle('collapsed');
        content.classList.toggle('sidenav-collapsed');
        nav.classList.toggle('navbar-collapsed'); // Toggle the collapsed class for the navbar
    });
</script>
</script>

</body>

</html>
