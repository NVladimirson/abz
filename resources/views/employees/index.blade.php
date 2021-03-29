@extends('layouts.main')

@section('page_header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employees</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{  route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Employees</li>
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
                           <th class="text-center">Photo</th>
                           <th class="text-center">Position</th>
                           <th class="text-center">Higher Up</th>
                           <th class="text-center">Email</th>
                           <th class="text-center">Phone Number</th>
                           <th class="text-center">Salary</th>
                           <th class="text-center">More</th>
                           <!-- <th>Recruitment Date</th>
                           <th>Updated At</th>
                           <th>Created At</th> 
                           <th>Actions</th>                         -->
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Photo</th>
                           <th>Position</th>
                           <th>Higher Up</th>
                           <th>Email</th>
                           <th>Phone Number</th>
                           <th>Salary</th>
                           <th>More</th>
                           <!-- <th>Recruitment Date</th>
                           <th>Updated At</th>
                           <th>Created At</th> 
                           <th>Actions</th>  -->
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

    <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Employee</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Are you sure you want to delete this employee?</div>
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
         "url" : "{!! route('employees.datatable') !!}",
      },
      "serverSide": true,
      // "order": [[ 0, 'asc' ], [ 1, 'asc' ]],
      "columnDefs": [
        { className: "align-middle", targets: "_all"}
      ],
      "columns": [
         { 
           "data": "name",
           "orderable": true,
          },
         { 
           "data": "photo",
           "orderable": true,
         },
         { 
           "data": "position",
           "orderable": true,
         },
         { 
           "data": "higher_up",
           "orderable": true,
         },
         { 
           "data": "email",
           "orderable": true,
         },
         { 
           "data": "phone_number",
           "orderable": true,
         },
         { 
           "data": "salary",
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
       
    $('#deleteEmployeeModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let modal = $(this);
                console.log(button.data('employee'));
                console.log(button.data('name'));
                modal.find('#delete-button').append('<a class="btn btn-danger delete-employee" href="#" data-employee="'+button.data('employee')+'" data-name="'+button.data('name')+'">Delete</a>')
            });

            $('#deleteEmployeeModal').on('hide.bs.modal', function(event) {
              $("#delete-button").empty();
            });
   
    function delete_employee(employee){
      let token = $("meta[name='csrf-token']").attr("content");
      let url = "{{route('employees.index')}}"+"/"+employee;
          
      $.ajax({
          type: "POST",
          data:{
          _method:"DELETE",
          "_token": "{{ csrf_token() }}",
          "id": employee
          },
          url: url,
          success: function(response){
            console.log(response);
              alert('Employee '+response['name'] + ' was deleted. '+ 'Employees not anymore having a boss : '+ response['updated']);
              document.location.reload();
          }
      });

    };

    $(document).on("click", ".delete-employee", function(e){
      delete_employee($(this).data('employee'));
   }); 
   
   } );
</script>
@endsection