@extends('layouts.admin')

@section('content')
<h2>List of User</h2>
<div class="table-responsive col-md-8">
    <table class="table table-bordered" id="tblUser">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/b-1.4.2/b-colvis-1.4.2/b-flash-1.4.2/b-html5-1.4.2/b-print-1.4.2/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/b-1.4.2/b-colvis-1.4.2/b-flash-1.4.2/b-html5-1.4.2/b-print-1.4.2/datatables.min.js"></script>

<script>
    var $table;
    $(document).ready(function(){
        $table = $('#tblUser').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,                
            ajax: "{{route('user.data')}}",
            columns:[
                {data: 'id', className: 'text-center'},{
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'id',orderable: false,  searchable: false,className: 'text-center',
                    render: function(data, type, row, meta){
                        var $button = '<button type="button" class="btn btn-info" onclick="editUser('+ data +');"><i class="fa fa-pencil"></i></button>';
                        $button += '&nbsp;<button type="button" class="btn btn-danger" onclick="deleteUser('+ data +');"><i class="fa fa-trash"></i></button>';
                        return $button;
                    }
                }
            ],
            buttons:[
                {
                    text : "<i class='fa fa-plus'></i> Add User",
                    className: 'btn btn-success green-meadow',
                    action: function(e, dt, node, config){
                        
                    }
                }
            ],
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row' <'col-sm-6'i><'col-sm-6'p>>"
        });
    });
</script>
@endsection