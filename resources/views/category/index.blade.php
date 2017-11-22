@extends('layouts.admin')

@section('content')
    <h2>List of Category</h2>
    <div class="table-responsive col-md-8">
        <!-- <a href="" class="btn btn-default" role="button">
            <i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
        </a> -->
        <table class="table table-bordered" id="tblCategory">
            <thead>
                <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>
                        Name
                    </th>
                    <th>Status</th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            
        </table>
    </div> 
    <div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryname">New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="form-horizontal">
                    <div class="modal-body">                   
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="input-group">
                                <div class="btn-group" data-toggle="buttons">
                                    <label name="btn" class="btn btn-success active">
                                        <input type="radio" name="active" id="active" value="1">Active</input>
                                    </label>
                                    <label name="btn" class="btn btn-success">
                                        <input type="radio" name="active" id="inactive" value="0">Not Active</input>
                                    </label>
                                </div>
                            </div>                            
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
            $table = $('#tblCategory').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,                
                ajax: "{{route('category.get')}}",
                columns: [
                    {data: 'id', className: 'text-center'},{
                        data: 'name'
                    },{
                        data: 'active',className: 'text-center',
                        render:function(data, type, row, meta){ 
                            var $data = (data ==1) ? "<i class='fa fa-check-square-o text-success'></i>" : "<i class='fa fa-minus-square-o text-danger'></i>";                     
                            return $data;
                        }
                    },
                    {
                        data: 'id', orderable: false,  searchable: false,className: 'text-center',
                        render: function(data, type, row, meta){
                        var $button = '<button type="button" class="btn btn-info" onclick="editCategory('+ data +');"><i class="fa fa-pencil"></i></button>';
                        $button += '&nbsp;<button type="button" class="btn btn-danger" onclick="deleteCategory('+ data +');"><i class="fa fa-trash"></i></button>';
                        return $button;
                    } }
                ],
                buttons:[
                    {
                        text : "<i class='fa fa-plus'></i> Add Category",
                        className: 'btn btn-success green-meadow',
                        action: function(e, dt, node, config){
                            addcategory();
                        }
                    }
                ],
                dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row' <'col-sm-6'i><'col-sm-6'p>>"
            });
        });

        function addcategory(){
            var $modal =  $('#modalCategory');    
            $form = $modal.find('.form-horizontal');
            $form[0].reset();     
            $modal.modal('show');
            
            $form.unbind();
            $form.submit(function(e){
                e.preventDefault();
                axios.post("{{ route('category.store') }}",$form.serialize())
                    .then(function(response){                  
                        $table.ajax.reload();
                    }).catch(function(errors){
                        console.log(errors);
                    });
                $modal.modal('hide');
                return false;
            });
        }
        function editCategory(id){
            var $modal =  $('#modalCategory');
            axios.get("{{ url('/api/category/') }}" + "/"+ id).then(function(response){                
                var $category = response.data.category;
                $('input[name="name"]').val($category.name);
                $('label.btn.active').removeClass('active');
                if($category.active == 1){
                    $('input[name="active"][value="1"]').attr("checked","checked").parent('label.btn').addClass('active');
                    $('input[name="active"][value="0"]').attr("checked", false);
                }
                else {
                    $('input[name="active"][value="0"]').attr("checked","checked").parent('label.btn').addClass('active');
                    $('input[name="active"][value="1"]').attr("checked",false);
                }
                    
                $modal.modal('show');                
            }).catch(function(errors){

            });
            $form = $modal.find('.form-horizontal');
            $form[0].reset();     
            $modal.modal('show');
            
            $form.unbind();
            $form.submit(function(e){
                e.preventDefault();
                axios.put("{{ url('api/category/') }}" + "/" + id, $form.serialize()).then(function(response){
                    console.log(response);
                    $table.ajax.reload();
                }).catch(function(errors){
                    console.log(errors);
                });
                $modal.modal('hide');
                return false;
            });
            
        }
        function deleteCategory(id){
            axios.delete("{{ url('api/category/') }}" + "/" + id).then(function(response){
                $table.ajax.reload();
            }).catch(function(errors){
                console.log(errors);
            });
        }
    </script>
@endsection