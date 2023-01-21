@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    News Table
                </div>
                <div class="card-body table-responsive">
                    {{-- {{$dataTable->table()}} --}}

                    <div class="mb-4">
                        <a class="btn btn btn-primary" href="{{ route('news.create') }}">Add News</a>
                    </div>
                    <table class="table table-responsive-sm table-striped dataTableBuilder">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Popular Count</th>
                                <th>Author</th>
                                <th>Post By</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Slide</th>
                                <th>Action</th>
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
              ajax: "{{ route('news.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'title', name: 'title'},
                  {data: 'news_category', name: 'news_category'},
                  {data: 'popular_counts', name: 'popular_counts'},
                  {data: 'author_by', name: 'author_by'},
                  {data: 'post_by', name: 'post_by'},
                  {data: 'image', name: 'image'},
                  {data: 'date_text', name: 'date_text'},
                  {data: 'slide', name: 'slide'},
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
                    url: `/news/${id}`,
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

        function changeSlide(e) {
            const id = e.target.getAttribute('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: `/update-slide/${id}`,
                type: 'POST',
                data: {
                    '_method': 'POST',
                    "id": id
                },
                success: function (response) {
                    $('.dataTableBuilder').DataTable().ajax.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
      </script>
@endpush
