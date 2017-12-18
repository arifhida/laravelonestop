@extends('layouts.admin')
@section('content')
<h2>List of Role</h2>
<div class="table-responsive col-md-8">
    <table class="table table-bordered" id="tblRole">
        <thead>
            <tr>
                <th>#</th>
                <th>Role Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>        
    </table>
</div>

<div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolename">New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="name" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
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
       $table = $('#tblRole').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                ajax: "{{ route('role.data')}}",
                columns:[
                    {data: 'id', className: 'text-center'},
                    {data: 'name'},
                    {data: 'description'},
                    {data: 'id', orderable: false,  searchable: false,className: 'text-center',
                    render: function(data, type, row, meta){
                            var $button = '<button type="button" class="btn btn-info" onclick="editRole('+ data +');"><i class="fa fa-pencil"></i></button>';
                            $button += '&nbsp;<button type="button" class="btn btn-danger" onclick="deleteRole('+ data +');"><i class="fa fa-trash"></i></button>';
                            return $button;
                        }
                    }
                ],
                buttons:[
                    {
                        text : "<i class='fa fa-plus'></i> Add Role",
                        className: 'btn btn-success green-meadow',
                        action: function(e, dt, node, config){
                            addRole();
                        }
                    }
                ],
                dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row' <'col-sm-6'i><'col-sm-6'p>>"
       });
    });

    function addRole(){
        var $modal =  $('#modalRole');        
        $form = $modal.find('.form-horizontal');
        $form[0].reset();     
        $modal.modal('show');
        
        $form.unbind();
        $form.submit(function(e){
            e.preventDefault();
            axios.post("{{ route('role.store') }}", $form.serialize())
                .then(function(response){
                    $table.ajax.reload();
                }).catch(function(errors){
                    console.log(errors);
                });
            $modal.modal('hide');
            return false;
        });
    }

    function editRole($id){
        var $modal =  $('#modalRole');        
        axios.get("{{ url('/api/role/') }}" + "/"+ $id).then(function(response){
            var $role = response.data.role;
            $('input[name="name"]').val($role.name);
            $('input[name="description"]').val($role.description);
            $modal.modal('show'); 
        }).catch(function(errors){
            console.log(errors);
        });
        $form = $modal.find('.form-horizontal');
        $form[0].reset();     
        $modal.modal('show');
        
        $form.unbind(); 
        $form.submit(function(e){
            e.preventDefault();
            axios.put("{{ url('api/role/') }}" + "/" + $id, $form.serialize()).then(function(response){
                console.log(response);
                $table.ajax.reload();
            }).catch(function(errors){
                console.log(errors);
            });
            $modal.modal('hide');
            return false;
        }); 

    }
    function deleteRole($id){
        axios.delete("{{ url('api/role/') }}" + "/" + $id).then(function(response){
            $table.ajax.reload();
        }).catch(function(errors){
            console.log(errors);
        });
    }
</script>


@endsection