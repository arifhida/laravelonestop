@extends('layouts.admin')
@section('content')
    <h2>List of Product</h2>
    <div class="table-responsive">
        <table class="table table-bordered" id="tblProduct">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Active</th>
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
            $table = $('#tblProduct').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                ajax: "{{route('product.get')}}",
                columns:[
                    {data: 'id', searchable: false },
                    {data: 'product_name'},
                    {data: 'description'},
                    {data: 'name'},
                    {data: 'price'},
                    {data: 'active', className: 'text-center',orderable: false,  searchable: false,
                        render:function(data, type, row, meta){ 
                            var $data = (data ==1) ? "<i class='fa fa-check-square-o text-success'></i>" : "<i class='fa fa-minus-square-o text-danger'></i>";                     
                            return $data;
                        }
                    },
                    {
                        data: 'id',orderable: false,  searchable: false,className: 'text-center',
                        render:function(data, type, row, meta){ 
                            var $button = '<button type="button" class="btn btn-info" onclick="editProduct('+ data +');"><i class="fa fa-pencil"></i></button>';
                            $button += '&nbsp;<button type="button" class="btn btn-danger" onclick="deleteProduct(' + data + ')"><i class="fa fa-trash"></i></button>';
                            return $button;
                        }
                    }
                ],
                buttons: [
                    {
                        text : "<i class='fa fa-plus'></i> Add Product",
                        className: 'btn btn-success green-meadow',
                        action: function(e, dt, node, config){
                            window.location.href = "{{ route('product.create') }}";
                        }
                    }
                ],
                dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row' <'col-sm-6'i><'col-sm-6'p>>"
            });
        });

        function editProduct($id){
            var $url = "{{ url('/product') }}" + "/" + $id + "/edit";
            window.location.href = $url;
        }

        function deleteProduct($id){
            axios.delete("{{ url('api/product/') }}" + "/" + $id).then(function(response){
                $table.ajax.reload();
            }).catch(function(errors){
                console.log(errors);
            });
        }
    </script>
@endsection