<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
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
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets/js/material-dashboard.min.js?v=3.1.0"') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
        function parseCurrency(value) {
        // Remove any non-digit characters, including commas and periods
        return parseInt(value.replace(/[^0-9]/g, ''), 10) || 0;
    }

    // Function to format numbers as currency
    function formatCurrency(value) {
        // Return the number formatted with commas for thousands, etc.
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function formatRupiah(input) {
            let value = input.value;

            // Remove all non-digit characters
            value = value.replace(/\D/g, '');

            // Convert to integer for proper formatting
            value = parseInt(value, 10);

            // If the value is not a number, reset the input
            if (isNaN(value)) {
                input.value = '';
                return;
            }

            // Convert number to string with thousands separators (using dots)
            value = value.toLocaleString('id-ID');

            // Set the formatted value back to the input
            input.value = value;
        }
</script>
</body>

</html>
