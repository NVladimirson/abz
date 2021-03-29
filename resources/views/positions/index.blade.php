@extends('layouts.main')

@section('page_header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Positions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{  route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Positions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>


@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-12">
          <div class="table-responsive table-bordered">
                  <table class="table" id="datatable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th class="text-center">Name</th>
                           <th class="text-center">Applicants</th>
                           <th class="text-center">Rank</th>
                           <th class="text-center">Can be head to</th>
                           <th class="text-center">More</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                          <th class="text-center">Name</th>
                          <th class="text-center">Applicants</th>
                           <th class="text-center">Rank</th>
                           <th class="text-center">Can be head to</th>
                           <th>More</th>
                        </tr>
                     </tfoot>
                     <tbody>

                     </tbody>
                  </table>
               </div>
          </div>
        </div>
      </div>
    </section>
    
    <div class="modal fade" id="deletePositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Logout Form</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Are you sure you want to delete position? That will make all related employees without defined position!</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <div id="delete-button">
                              
                              </div>
                            <!-- <a class="btn btn-primary" href="{{route('logout')}}" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">Logout</a> -->
                        </div>
                    </div>
                </div>
            </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js"></script>
  <script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script>
   jQuery(function($) {
    function details ( d ) {
            return d.more;
        }

      window.table = $('#datatable').DataTable( {
      "ajax": {
         "url" : "{!! route('positions.datatable') !!}",
      },
      "serverSide": true,
      // "order": [[ 0, 'asc' ], [ 1, 'asc' ]],
      "columnDefs": [
        { className: "align-middle", targets: "_all"}
      ],
      "columns": [
         { 
           "data": "position",
           "orderable": true,
          },
         { 
           "data": "applicants",
           "orderable": true,
         },
         { 
           "data": "rank",
           "orderable": true,
         },
         { 
           "data": "can_be_head_to",
           "orderable": true,
         },
         {
                "className":      'details-control align-middle',
                "orderable":      false,
                "searchable": false,
                "data":           null,
                "defaultContent": '<div class="text-center"><i class="fa fa-plus"></i></div>'
            },
        //  { "data": "recruitment_date" },
        //  { "data": "updated_at" },
        //  { "data": "created_at" },
        //  { "data": "actions" },
      ],
      } );

    // Add event listener for opening and closing details
    $('#datatable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            console.log(row.data());
            row.child( details(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
   } );

   $(document).ready( function () {

    $('#deletePositionModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let modal = $(this);
                modal.find('#delete-button').append('<a class="btn btn-danger delete-position" href="#" data-position_id="'+button.data('position_id')+'" data-position="'+button.data('position')+'" data-employees="'+button.data('employees')+'">Delete</a>')
            });

            $('#deletePositionModal').on('hide.bs.modal', function(event) {
              $("#delete-button").empty();
            });
   
    function delete_position(position){
      let token = $("meta[name='csrf-token']").attr("content");
      let url = "{{route('positions.index')}}"+"/"+position;
          
      $.ajax({
          type: "POST",
          data:{
          _method:"DELETE",
          "_token": "{{ csrf_token() }}",
          "id": position
          },
          url: url,
          success: function(response){
            console.log(response);
              alert('Position "'+response['position'] + '" was deleted. '+ 'Employees not anymore having a position : '+ response['updated']);
              document.location.reload();
          }
      });

    };

    $(document).on("click", ".delete-position", function(e){
      delete_position($(this).data('position_id'));
   }); 
   
   } );
</script>
@endsection