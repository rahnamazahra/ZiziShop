@if(session('swal'))
    <script>
        Swal.fire({
            title: "{{ session('swal')['title'] }}",
            text: "{{ session('swal')['message'] }}",
            icon: "{{ session('swal')['icon'] }}",
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
            showConfirmButton: false,
            timer: 7000
        });
    </script>
@endif

