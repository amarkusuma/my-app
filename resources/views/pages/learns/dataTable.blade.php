@extends('dashboard.base')

{{-- @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection --}}

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    Learns Table
                </div>
                <div class="card-body table-responsive">
                    {{-- {{$dataTable->table()}} --}}

                    <div class="mb-4">
                        <a class="btn btn btn-primary" href="{{ route('learns.create') }}"> Add Learns</a>
                    </div>
                    <table class="table table-responsive-sm table-striped dataTableBuilder">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>


@endsection

@push('scripts')

    <script type="text/javascript">
        $(function () {

            var table = $('.dataTableBuilder').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('learns.list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'level', name: 'level'},
                    {data: 'price', name: 'price'},
                    {data: 'discount', name: 'discount'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });

        });
    </script>

      <script>
        //   $('.delete', '#')
        // $('.dataTableBuilder tbody').on('click', ".delete", function() {
        // });

        function deleteThis(e) {
            if (confirm("Delete This data?")) {
                const id = e.target.getAttribute('data-id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/learns/${id}`,
                    type: 'POST',
                    data: {
                        // '_token': $('meta[name=csrf-token]').attr("content"),
                        '_method': 'DELETE',
                        "id": id
                    },
                    success: function (response) {
                    //   console.log(response)
                    $('.dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    }
                });
            }

        }
      </script>
@endpush
