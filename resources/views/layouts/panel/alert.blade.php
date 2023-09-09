@if(session('swal'))
    <script>
        Swal.fire({
            title: "{{ session('swal.title') }}",
            text: "{{ session('swal.text') }}",
            icon: "{{ session('swal.icon') }}",
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
            showConfirmButton: false,
            timer: 7000
        });
    </script>
@endif


@if(session('errors'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'خطا',
            html: '<ul class="list-disc pl-5">' +
            '@foreach ($errors->all() as $error)' +
                '<li>{!! $error !!}</li>' +
            '@endforeach' +
            '</ul>',
            toast: true,
            position: 'top-end',
            showCloseButton: true,
            timerProgressBar: true,
            showConfirmButton: false,
            timer: 7000
        });
    </script>
@endif

{{--  @if(session('errors'))
    <script>
       const errors = {!! json_encode(session('errors')->all()) !!};

        function displayToast(error) {
            swal.fire({
                icon: 'error',
                title: 'خطا',
                text: error,
                toast: true,
                position: 'top-end',
                showCloseButton: true,
                timerProgressBar: true,
                showConfirmButton: false,
            })
        }

        const errorQueue = [];

        errors.forEach(error => {
            errorQueue.push(() => displayToast(error));
        });

        function displayQueue() {
            if (errorQueue.length > 0) {
                const nextError = errorQueue.shift();
                nextError();
                setTimeout(displayQueue, 1000);
            }
        }

        displayQueue();

    </script>
@endif  --}}
{{--
@if(session('errors'))
<script>
const errors = {!! json_encode(session('errors')->all()) !!};

function displayToast(errors) {

    errors.forEach(error => {
        swal.fire({
            icon: 'error',
            title: 'خطا',
            text: error,
            toast: true,
            position: 'top-end',
            showCloseButton: true,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    });
}

displayToast(errors);
 </script>
@endif  --}}
