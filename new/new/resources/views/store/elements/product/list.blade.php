@extends('store.layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="row">
          <div class="col-12">
            
            
            @if ($message = Session::get('status'))
            <div class="alert alert-success">
              <p>{{ $message }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <div class="col-lg-12">
              @if ($errors->any())
              <div class="alert alert-danger">
                <strong>Whoops!</strong>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

             <div class="card-header">
                        <h3 class="mb-0 card-title">{{$pageTitle}}</h3>
                     </div>
                    <div class="card-body border">
                <form action="{{route('store.list_product')}}" method="GET" 
                         enctype="multipart/form-data">
                   @csrf
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="form-label">Product Name</label>
                       <input type="text" class="form-control" 
                       name="product_name"  value="{{ request()->input('product_name') }}" placeholder="Product Name">

                  </div>
               </div>
                <div class="col-md-4">
                  <div class="form-group">
                     <label class="form-label">Product Code</label>
                       <input type="text" class="form-control" 
                       name="product_code"  value="{{ request()->input('product_code') }}" placeholder="Product Code">

                  </div>
               </div>
                <div class="col-md-4">
                  <div class="form-group">
                     <label class="form-label">Product Status</label>
                       <select name="product_status" id="product_statusproduct_status"  class="form-control" >
                 <option value="" >Select Status</option>
                 <option {{request()->input('product_status') == '1' ? 'selected':''}} value="1" >Active</option>
                 <option {{request()->input('product_status') == '0' ? 'selected':''}} value="0" >InActive</option>  
                 </select>
                  </div>
               </div>
            
             </div>
             
             <div class="row">
                    <div class="col-md-4">
                 <div class="form-group">
                    <label class="form-label">From Date</label>
                     <input type="date" class="form-control" name="From_date"  value="{{ request()->input('From_date') }}" placeholder=" Date">

                  </div> 
               </div> 
                 <div class="col-md-4">
                 <div class="form-group">
                    <label class="form-label">To Date</label>
                     <input type="date" class="form-control" name="To_date"  value="{{ request()->input('To_date') }}" placeholder="Date">

                  </div> 
               </div> 
                 <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">Stock Status</label>
                     <select name="stock_status" id="stock_status_"  class="form-control" >
                 <option value="" >Select Status</option>
                 <option {{request()->input('stock_status') == '1' ? 'selected':''}} value="1" >Instock</option>
                 <option {{request()->input('stock_status') == '0' ? 'selected':''}} value="0" >OutStock</option>  
                 </select>
                  </div>
               </div> 
             </div>
                <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label class="form-label">Price Range From</label>
                       <input type="number" class="form-control" 
                       name="start_price"  value="{{ request()->input('start_price') }}" placeholder="Price Range From">

                  </div>
               </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label class="form-label">Price Range To</label>
                       <input type="number" class="form-control" 
                       name="end_price"  value="{{ request()->input('end_price') }}" placeholder="Price Range To">

                  </div>
               </div></div>
                     <div class="col-md-12">
                     <div class="form-group">
                           <center>
                           <button type="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Filter</button>
                           <button type="reset" class="btn btn-raised btn-success">Reset</button>
                          <a href="{{route('store.list_product')}}"  class="btn btn-info">Cancel</a>
                           </center>
                        </div>
                  </div>
                </div>
                   </form>
                </div>
             
               <div class="card-body">
                         <a href="{{route('store.create_product')}}" class="btn btn-block btn-info">
                           <i class="fa fa-plus"></i>
                           Create Product
                        </a> <br/>
                <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                    <thead>
                      <tr>
                        <th class="wd-15p">SL.No</th>
                        <th class="wd-15p">{{ __('Product') }}</th>
                        <th class="wd-15p">{{ __('Code') }}</th>
                        <th class="wd-15p">{{ __('Price') }}</th>
                        <th class="wd-15p">{{__('Image')}}</th>
                        <th class="wd-15p">{{__('Status')}}</th>
                        <th class="wd-15p">{{__('Stock')}}</th>
                       <th class="wd-15p">{{__('Action')}}</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 0;
                      @endphp
                      @foreach ($products as $product)
                      <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->product_code}}</td> 
                        <td>{{$product->product_price_offer}}</td>
                        <td><img src="{{asset('/assets/uploads/products/base_product/base_image/'.$product->product_base_image)}}"  width="50" >&nbsp;</td>
                       
                        <td>
                   <form action="{{route('store.status_product',$product->product_id)}}" method="POST">
                                          
                       @csrf
                          @method('POST')
                        <button type="submit" onclick="return confirm('Do you want to Change status?');" class="btn btn-sm
                        @if($product->product_status == 0) btn-danger @else btn-success @endif"> @if($product->product_status == 0)
                        InActive
                        @else
                        Active
                        @endif</button>
                     </form>
                        </td>
                        <td>
                          
                            <button type="button"  data-toggle="modal" data-target="#___StockModal{{$product->product_id}}"  class="btn btn-sm @if($product->stock_count == 0) btn-danger @else btn-success @endif"> 
                            @if($product->stock_count == 0)
                            OutStock
                            @else
                            InStock
                            @endif </button>
                          
                          </form>

                        </td>
                     
                   <td>
                     <form action="{{route('store.destroy_product',$product->product_id)}}" method="POST">
                       
                    @csrf
                      @method('POST')

                       <a class="btn btn-sm btn-cyan" href="{{url('store/product/edit/'.$product->product_name_slug)}}">Edit</a> 
                       <a class="btn btn-sm btn-cyan"
                       href="{{url('store/product/view/'.$product->product_name_slug)}}">View</a> 
                        <button type="submit" onclick="return confirm('Do you want to delete this item?');"  class="btn btn-sm btn-danger">Delete</button>
                         </form> 

                        </td> 
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  
                  
             
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 @foreach($products as $product)
            <div class="modal fade" id="StockModal{{$product->product_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{$pageTitle}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                           
                 <form action="{{ route('store.stock_update_product',$product->product_id) }} " method="POST" enctype="multipart/form-data" >
                 @csrf
                  <div class="modal-body">
           
                    <label class="form-label">Stock</label>
                    <input type="hidden" class="form-control" name="product_id" value="{{$product->product_id}}" >
                    
                  <input type="number" class="form-control" name="stock_count" value="{{old('stock_count',$product->stock_count)}}" placeholder="Stock">
                  </div>
              
                     <div class="modal-footer">
                       <button type="submit" class="btn btn-raised btn-primary">
                    <i class="fa fa-check-square-o"></i> Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     </div>
                      </form>
                  </div>
               </div>
            </div>
            @endforeach
  @endsection
 