@extends('backend.layouts.master')

@section('main-content')
<div class="container-fluid">
    <div class="row mb-3">
      <div class="col-md-12">
        @include('backend.layouts.notification')
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0">Danh sách Sản phẩm</h6>
            <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
              data-placement="bottom" title="Thêm Sản phẩm"><i class="fas fa-plus"></i> Thêm Sản phẩm</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-sm">
          <div class="card-body-table">
            <div class="table-responsive">
              @if(count($products) > 0)
                <table class="table table-striped table-borderless" id="product-dataTable" width="100%" cellspacing="0">
                <thead class="table-success">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Giảm giá</th>
                                        <th>Tình trạng</th>
                                        <th>Hình ảnh</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->title}}</td>
                                            <td>{{$product->cat_info['title']}} 
                                                <sub>{{$product->sub_cat_info->title ?? ''}}</sub>
                                            </td>
                                            <td>${{$product->price}}</td>
                                            <td>{{$product->discount}}%</td>
                                            <td>{{$product->condition}}</td>
                                            <td>
                                                @if($product->photo)
                                                    @php
                                                        $photo = explode(',', $product->photo);
                                                    @endphp
                                                    <img src="{{$photo[0]}}" class="img-fluid zoom" style="max-width:80px" alt="{{$product->photo}}">
                                                @else
                                                    <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid zoom" style="max-width:100%" alt="avatar.png">
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->status == 'active')
                                                    <span class="badge badge-success">Hoạt động</span>
                                                @else
                                                    <span class="badge badge-warning">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('product.edit', $product->id)}}" class="btn btn-primary btn-sm" style="height:30px; width:30px" data-toggle="tooltip" title="Chỉnh sửa" data-placement="bottom">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{route('product.destroy', [$product->id])}}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn" data-id="{{$product->id}}" style="height:30px; width:30px" data-toggle="tooltip" data-placement="bottom" title="Xóa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                </table>
                <span style="float:right">{{$products->links()}}</span>
              @else
                <h6 class="text-center">Không có sản phẩm nào! Vui lòng thêm sản phẩm mới.</h6>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
    div.dataTables_wrapper div.dataTables_paginate {
    display: none;
    }

    .zoom {
    transition: transform .2s;
    /* Animation */
    }

    .zoom:hover {
    transform: scale(3.2);
    }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>

  <!-- Page level custom scripts -->
  <script>
    $('#product-dataTable').DataTable({
      "columnDefs": [
        {
          "orderable": false,
          "targets": [3, 4, 5]  // Các cột không thể sắp xếp
        }
      ]
    });

    // Sweet alert for delete
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $('.dltBtn').click(function (e) {
        var form = $(this).closest('form');
        var dataID = $(this).data('id');
        e.preventDefault();
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Your data is safe!");
          }
        });
      })
    })
  </script>
@endpush
