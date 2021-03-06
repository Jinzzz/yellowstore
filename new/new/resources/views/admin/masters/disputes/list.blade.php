@extends('admin.layouts.app')
@section('content')
@php
$date = Carbon\Carbon::now();
@endphp
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12 col-lg-12">
         <div class="card">
            <div class="row">
               <div class="col-12" >

                  @if ($message = Session::get('status'))
                  <div class="alert alert-success">
                     <p>{{ $message }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                  </div>
                  @endif
                  <div class="col-lg-12">
                     @if ($errors->any())
                     <div class="alert alert-danger">
                        <h6>Whoops!</h6> There were some problems with your input.<br><br>
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
                 <form action="{{route('admin.list_disputes')}}" method="GET"
                         enctype="multipart/form-data">
                   @csrf
            <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                     <label class="form-label">Store</label>
                    <div id="store_idl"></div>
                       <select name="store_id" id="store_id"  class="form-control" >
                                 <option value=""> Select Store</option>
                                @foreach($stores as $key)
                                <option {{request()->input('store_id') == $key->store_id ? 'selected':''}} value="{{$key->store_id}}"> {{$key->store_name }} </option>
                                @endforeach
                              </select>
                  </div>
               </div>



                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Order Number</label>
                    <div id="order_numberl"></div>
                       <input type="text" class="form-control" name="order_number"  id="order_number" value="{{request()->input('order_number')}}"  placeholder="Order Number">
                  </div>
               </div>


                  {{-- @php
                   if(!@$datefrom)
                   {
                        $datefrom = $date->toDateString();
                   }

                    if(!@$dateto)
                   {
                        $dateto = $date->toDateString();
                   }
               @endphp --}}

                 <div class="col-md-6">
                 <div class="form-group">
                    <label class="form-label">From Date</label>
                    <div id="date_froml"></div>
                     <input type="date" class="form-control" name="date_from" id="date_from"  value="{{ request()->input('date_from') }}" placeholder="From Date">

                  </div>
               </div>
                 <div class="col-md-6">
               <div class="form-group">
                    <label class="form-label">To Date</label>
                    <div id="date_tol"></div>
                     <input type="date" class="form-control"  name="date_to"  id="date_to" value="{{ request()->input('date_to') }}" placeholder="To Date">

                  </div>
               </div>
           </div>
            <div class="col-md-12">
                     <div class="form-group">
                           <center>
                           <button type="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Filter</button>
                           <button type="reset" id="reset" class="btn btn-raised btn-success">Reset</button>
                          <a href="{{route('admin.list_disputes')}}"  class="btn btn-info">Cancel</a>
                           </center>
                        </div>
                  </div>
                   </form>
               </div>

                    <div class="card-body">
                        {{-- <a href="  {{route('admin.create_agency')}} " class="btn btn-block btn-info">
                           <i class="fa fa-plus"></i>
                           Create agency
                        </a>
                        </br> --}}
     @if($_GET)
                        <div class="table-responsive">
                           <table id="exampletable" class="table table-striped table-bordered text-nowrap w-100">
                              <thead>
                                 <tr>
                                    <th class="wd-15p">SL.No</th>
                                    <th class="wd-10p">{{ __('Dispute Date') }}</th>
                                    <th class="wd-15p">{{__('Issue')}}</th>
                                    <th class="wd-15p">{{__('Order Date')}}</th>
                                    <th class="wd-15p">{{__('Order Number')}}</th>
                                    <th class="wd-15p">{{ __('Store Name') }}</th>
                                    <th class="wd-10p">{{__('Sub Admin')}}</th>
                                    <th class="wd-20p">{{__('Dispute status')}}</th>
                                    <th class="wd-10p">{{__('Action')}}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @php
                                 $i = 0;
                                 @endphp
                                 @foreach ($disputes as $dispute)
                                 <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ \Carbon\Carbon::parse($dispute->dispute_date)->format('M d, Y')}}</td>

                                       @php
                                        $subadmin = \DB::table('users')->where('id',$dispute->subadmin_id)->first();
                                        $issue = \DB::table('mst__issues')->where('issue_id',$dispute->issue_id)->first();
                                        $store = \DB::table('mst_stores')->where('store_id',$dispute->store_id)->first();
                                        $order = \DB::table('trn_store_orders')->where('order_id',$dispute->order_id)->first();
                                    @endphp

                                    <td>{{@$issue->issue}}</td>

                                    <td>{{  date("d-m-Y", strtotime(@$order->created_at)) }}</td>
                                    <td>{{ @$order->order_number}}</td>
                                    <td>{{ @$store->store_name}}</td>

                                    <td>{{ @$subadmin->name}}</td>
                                    {{-- <td>{{ @$dispute->dispute_status}}</td> --}}
                        <td>
                           <button type="button" class="btn btn-sm @if($dispute->dispute_status == 'closed') btn-success @elseif($dispute->dispute_status == 'open') btn-danger @else btn-warning @endif"
                           data-toggle="modal" data-target="#StockModal{{$dispute->dispute_id}}" >

                            @if($dispute->dispute_status == 'closed' )Closed
                                @elseif($dispute->dispute_status == 'open') Open
                                @else Pending
                           @endif
                           </button>
                    </td>

                                    {{-- <td>{{ $dispute->discription}}</td> --}}
                                    <td>
                                          <button data-toggle="modal" data-target="#viewModal{{$dispute->dispute_id}}"  class="btn btn-sm btn-cyan">View</button>
                                    </td>
                                 {{-- <td>
                                    <form action="#" method="GET">
                                          @csrf
                                          @method('GET')
                                          <button type="submit" onclick="return confirm('Do you want to delete this dispute?');"  class="btn btn-sm btn-danger">Delete</button>
                                       </form>
                                 </td> --}}
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
@endif
                     </div>
                  </div>
               </div>
            </div>

            <!-- MESSAGE MODAL CLOSED -->

@foreach($disputes as $dispute)
            <div class="modal fade" id="StockModal{{$dispute->dispute_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">Update Dispute Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>

                 <form action=" {{ route('admin.dispute_status',$dispute->dispute_id ) }} " method="POST" enctype="multipart/form-data" >
                 @csrf
                  <div class="modal-body">

                    <label class="form-label">Dispute Status</label>

                   <select class="form-control" name="dispute_status" id="dispute_status">
                     <option value=""> Select Status</option>
                              <option {{request()->input('dispute_status') == 'closed' ? 'selected':''}} value="closed"> Closed     </option>
                              <option {{request()->input('dispute_status') == 'open' ? 'selected':''}} value="open"> Open     </option>
                              <option {{request()->input('dispute_status') == 'pending' ? 'selected':''}} value="pending"> Pending     </option>
                           </select>
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


@foreach($disputes as $dispute)
            <div class="modal fade" id="viewModal{{$dispute->dispute_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{$pageTitle}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">

                        <div class="table-responsive ">
                           <table class="table row table-borderless">
                              <tbody class="col-lg-12 col-xl-12 p-0">
                            @php
                                $issue = \DB::table('mst__issues')->where('issue_id',$dispute->issue_id)->first();
                    $customer = \DB::table('trn_store_customers')->where('customer_id',$dispute->customer_id)->first();

                            @endphp
                                 <tr>
                                    <td><h6>Customer Name : {{@$customer->customer_first_name}} {{@$customer->customer_last_name }}</h6></td>
                                 </tr>
                                 <tr>
                                    <td><h6>Customer Phone : {{$customer->customer_mobile_number}}</h6></td>
                                 </tr>
                                 <tr>
                                    <td><h6>Dispute Status : {{$dispute->dispute_status}}</h6></td>
                                 </tr>
                                 <tr>
                                    <td><h6>Remarks : {{@$issue->issue}}
                                   </h6></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>

                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
<!-- MESSAGE MODAL CLOSED -->


                      <script>

$(function(e) {
	 $('#exampletable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                title: 'Disputes',
                footer: true,
                exportOptions: {
                     columns: [0,1,2,3,4,5]
                 }
            },
            {
                extend: 'excel',
                title: 'Disputes',
                footer: true,
                exportOptions: {
                     columns: [0,1,2,3,4,5]
                 }
            }
         ]
    } );

} );



$(document).ready(function() {
 $('#reset').click(function(){

     //$('#store_id').val('');
     //$('#order_number').val('');

     $('#store_id').remove();
     $('#order_number').remove();
     $('#date_from').remove();
    $('#date_to').remove();
    $('#date_froml').append('<input type="date" class="form-control" name="date_from" id="date_from"  placeholder="From Date">');
    $('#date_tol').append('<input type="date" class="form-control" name="date_to"   id="date_to" placeholder="To Date">');

 $('#store_idl').append(' <select name="store_id" id="store_id"  class="form-control" ><option value=""> Select Store</option>@foreach($stores as $key)<option value="{{$key->store_id}}"> {{$key->store_name }} </option>@endforeach</select>');
 $('#order_numberl').append('<input type="text" class="form-control" name="order_number"  id="order_number" placeholder="Order Number">');

   });
});

            </script>


@endsection


