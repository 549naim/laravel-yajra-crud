<!DOCTYPE html>
<html>

<head>
    <title>Laravel 8 Datatables Tutorial - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>

    <div class="container">
        <h1>Laravel Datatables</h1>
        <a href="{{ url('/create') }}">
            <button class="btn btn-primary mb-2 float-end" href>
                Create New
            </button>
        </a>
        <table class="table table-bordered data-table m-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th width="100px">image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</body>

<script type="text/javascript">
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

    });

    $('body').on('click', '.edit', function() {

        var userId = $(this).data("id");
        window.location.href = '/edit/' + userId;
    });

    // $('body').on('click', '.delete', function() {
    //     var userId = $(this).data("id")
    //     window.location.href = '/delete/' + userId;
    // });
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // delete category data

        $('body').on('click', '.delete', function() {

            let product_id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: "{{ url('/product/delete') }}",
                data: {
                    product_id: product_id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 'success') {
                        $('.data-table').DataTable().ajax.reload();
                    }
                }
            });

        })

    });
</script>

</html>
