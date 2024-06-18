@if (session('success') && is_array(session('success')) && isset(session('success')['text']))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const message = "{{ session('success')['text'] }}";
            Swal.fire({
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endif

@if (session('error') && is_array(session('error')) && isset(session('error')['text']))
    <script type="text/javascript">
        const message = "{{ session('error')['text'] }}";
        document.addEventListener("DOMContentLoaded", () => {
            Swal.fire({
                icon: 'error',
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endif
