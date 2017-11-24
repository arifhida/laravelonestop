@extends('layouts.admin')
@section('content')
    <h2>List of Sub Category</h2>
    <div class="table-responsive col-md-8">
        <table class="table table-bordered" id="tblSubCategory">
            <thead>
                <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>
                        Name
                    </th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="modalSubCategory" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subcategoryname">New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="form-horizontal">
                    <div class="modal-body">      
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{ $category->name }}</option>
                            @endforeach
                            </select>
                        </div>             
                        <div class="form-group">
                            <label>Sub Category</label>
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
        $table = $('#tblSubCategory').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,                
                ajax: "{{route('subcategory.get')}}",
                columns: [
                    {data: 'id', className: 'text-center'},{
                        data: 'name'
                    },
                    {
                        data:'category'
                    },
                    {
                        data: 'active',className: 'text-center',
                        render:function(data, type, row, meta){ 
                            var $data = (data ==1) ? "<i class='fa fa-check-square-o text-success'></i>" : "<i class='fa fa-minus-square-o text-danger'></i>";                     
                            return $data;
                        }
                    },
                    {
                        data: 'id', orderable: false,  searchable: false,className: 'text-center',
                        render: function(data, type, row, meta){
                        var $button = '<button type="button" class="btn btn-info" onclick="editSubCategory('+ data +');"><i class="fa fa-pencil"></i></button>';
                        $button += '&nbsp;<button type="button" class="btn btn-danger" onclick="deleteSubCategory('+ data +');"><i class="fa fa-trash"></i></button>';
                        return $button;
                    } }                    
                ],
                buttons:[
                    {
                        text : "<i class='fa fa-plus'></i> Add SubCategory",
                        className: 'btn btn-success green-meadow',
                        action: function(e, dt, node, config){
                            addsubCategory();
                        }
                    }
                ],
                dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row' <'col-sm-6'i><'col-sm-6'p>>"
        });
    });
    function addsubCategory(){
        var $modal =  $('#modalSubCategory');        
        $form = $modal.find('.form-horizontal');
        $form[0].reset();     
        $modal.modal('show');
        
        $form.unbind();
        $form.submit(function(e){
            e.preventDefault();
            axios.post("{{ route('subcategory.store') }}",$form.serialize())
                .then(function(response){                  
                    $table.ajax.reload();
                }).catch(function(errors){
                    console.log(errors);
                });
            $modal.modal('hide');
            return false;
        });
    }
    function editSubCategory($id){
        var $modal =  $('#modalSubCategory');        
        axios.get("{{ url('/api/subcategory/') }}" + "/"+ $id).then(function(response){                
            var $subcategory = response.data.subcategory;
            $('input[name="name"]').val($subcategory.name);
            $('label.btn.active').removeClass('active');
            $('option[value='+$subcategory.category_id+']').attr('selected','selected');
            if($subcategory.active == 1){
                $('input[name="active"][value="1"]').attr("checked","checked").parent('label.btn').addClass('active');
                $('input[name="active"][value="0"]').attr("checked", false);
            }
            else {
                $('input[name="active"][value="0"]').attr("checked","checked").parent('label.btn').addClass('active');
                $('input[name="active"][value="1"]').attr("checked",false);
            }
                
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
                axios.put("{{ url('api/subcategory/') }}" + "/" + $id, $form.serialize()).then(function(response){
                    console.log(response);
                    $table.ajax.reload();
                }).catch(function(errors){
                    console.log(errors);
                });
                $modal.modal('hide');
                return false;
            }); 
    }
    function deleteSubCategory($id){
        axios.delete("{{ url('api/subcategory/') }}" + "/" + $id).then(function(response){
            $table.ajax.reload();
        }).catch(function(errors){
            console.log(errors);
        });
    }
</script>
@endsection