@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    Feedback Table
                </div>
                <div class="card-body table-responsive">
                    <div class="mb-4">
                        <a class="btn btn btn-primary" href="{{ route('feedback.create') }}">Add Feedback</a>
                    </div>
                    <table class="table table-responsive-sm table-striped dataTableBuilder">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Comment</th>
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
              ajax: "{{ route('feedback.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'user', name: 'user'},
                  {data: 'email', name: 'email'},
                  {data: 'comment', name: 'comment'},
                  {
                      data: 'action',
                      name: 'action',
                      orderable: true,
                      searchable: true
                  },
              ]
          });

        });
      </script>

      <script>

        function deleteThis(e) {
            if (confirm("Delete This data?")) {
                const id = e.target.getAttribute('data-id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/feedback/${id}`,
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
