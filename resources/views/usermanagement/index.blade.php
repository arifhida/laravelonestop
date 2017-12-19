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

<div class="modal fade" tabindex="-1" role="dialog" id="modalUser">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userName">New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control" required/>
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
                        addUser();
                    }
                }
            ],
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row' <'col-sm-6'i><'col-sm-6'p>>"
        });
    });

    function addUser(){
        var $modal =  $('#modalUser');
        $('#userName').val('New User');
        $('input[name="email"]').prop('readonly', null);
        $('input[name="password"]').prop('required', 'required');
        $form = $modal.find('.form-horizontal');
        $form[0].reset();
        $modal.modal('show');
        $form.unbind();
        $form.submit(function(e){
            e.preventDefault();
            axios.post("{{ url('api/usermanagement') }}",$form.serialize())
                .then(function(response){                  
                    $table.ajax.reload();
                }).catch(function(errors){
                    console.log(errors);
                });
            $modal.modal('hide');
            return false;
        });
    }

    function editUser($id){
        var $modal =  $('#modalUser');
        $form = $modal.find('.form-horizontal');
        $('input[name="password"]').prop('required', null);
        axios.get("{{ url('api/usermanagement') }}" + "/"+ $id)
            .then(function(response){
                var $user = response.data.user;
                $('#userName').val($user.email);
                $('input[name="name"]').val($user.name);
                $('input[name="email"]').val($user.email).attr('readonly','readonly');
                console.log(response);
            }).catch(function(errors){
                console.log($user.name);
            });
        $form[0].reset();
        $modal.modal('show');
        $form.unbind();

        $form.submit(function(e){
            e.preventDefault();
            axios.put("{{ url('api/usermanagement') }}" + "/"+ $id, $form.serialize())
                .then(function(response){
                    $table.ajax.reload();
                    console.log(response);
                }).catch(function(errors){
                    console.log(response);
                });
            $modal.modal('hide');
            return false;
        });        
    }

    function deleteUser($id){
        axios.delete("{{ url('api/usermanagement/') }}" + "/" + $id).then(function(response){
                $table.ajax.reload();
            }).catch(function(errors){
                console.log(errors);
            });
    }
</script>
@endsection