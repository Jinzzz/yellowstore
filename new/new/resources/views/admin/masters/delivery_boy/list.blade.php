@extends('admin.layouts.app')
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
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
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
                <form action="{{route('admin.list_delivery_boy')}}" method="GET"
                         enctype="multipart/form-data">
                   @csrf
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="form-label">Store</label>
                      <div id="store_idl"></div>
                       <select name="store_id"  id="store_id" required="" class="form-control" >
                                 <option value=""> Select Store</option>
                                @foreach($stores as $key)
                                <option {{request()->input('store_id') == $key->store_id ? 'selected':''}} value="{{$key->store_id}}"> {{$key->store_name }} </option>
                                @endforeach
                              </select>
                  </div>
               </div>
                    <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">From Date</label>
                      <div id="date_froml"></div>
                     <input type="date" class="form-control" name="date_from" id="date_from"  value="{{ request()->input('date_from') }}" placeholder="From Date">

                  </div>
               </div>
                 <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">To Date</label>
                      <div id="date_tol"></div>
                     <input type="date" class="form-control" name="date_to"  id="date_to" value="{{ request()->input('date_to') }}" placeholder="To Date">

                  </div>
               </div>
                     <div class="col-md-12">
                     <div class="form-group">
                           <center>
                           <button type="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Filter</button>
                           <button type="reset"  id="reset" class="btn btn-raised btn-success">Reset</button>
                          <a href="{{route('admin.list_delivery_boy')}}"  class="btn btn-info">Cancel</a>
                           </center>
                        </div>
                  </div>
                </div>
                   </form>
                </div>

               <div class="card-body">
                <a href=" {{route('admin.create_delivery_boy')}}" class="btn btn-block btn-info">
                           <i class="fa fa-plus"></i>
                           Create Delivery Boy
                        </a>
                        </br>
                <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                    <thead>
                      <tr>
                        <th class="wd-15p">SL.No</th>
                        <th class="wd-15p">{{ __('Name') }}</th>
                        <th class="wd-15p">{{ __('Mobile') }}</th>
                        <th class="wd-15p">{{ __('Email') }}</th>
                          <th class="wd-15p">{{ __('Town') }}</th>
                          <th class="wd-15p">{{ __('Stores') }}</th>
                      {{--   <th class="wd-15p">{{__('Status')}}</th>
 --}}
                        <th class="wd-15p">{{__('Action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 0;
                      @endphp
                      @foreach ($delivery_boys as $delivery_boy)
                      <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$delivery_boy->delivery_boy_name}}</td>
                        <td>{{$delivery_boy->delivery_boy_mobile}}</td>
                        <td>{{$delivery_boy->delivery_boy_email}}</td>
                     @php
                     $towns =  \DB::table('mst_towns')->where('town_id', @$delivery_boy->town_id)->first();
                    // dd($towns);
                     @endphp
                        <td>{{@$towns->town_name}}</td>

                        <td>
                        @php
                            $stores__data = \DB::table('mst_store_link_delivery_boys')
                            ->join('mst_stores','mst_stores.store_id','=','mst_store_link_delivery_boys.store_id')
                            ->where('mst_store_link_delivery_boys.delivery_boy_id','=',$delivery_boy->delivery_boy_id)
                            ->select('mst_stores.*')
                            ->get();
                        @endphp
                       @foreach ($stores__data as $s)
                                                   {{ $s->store_name }} <br>
                       @endforeach

                        </td>



                         <td>
                      <form action="{{route('admin.destroy_delivery_boy',$delivery_boy->delivery_boy_id)}}" method="POST">

                    @csrf
                      @method('POST')
                       <a class="btn btn-sm btn-info" href="{{url('admin/delivery_boy/assign_store/'.Crypt::encryptString($delivery_boy->delivery_boy_id))}}">Assign Store</a>
                       <a class="btn btn-sm btn-cyan" href="{{url('admin/delivery_boy/edit/'.Crypt::encryptString($delivery_boy->delivery_boy_id))}}">Edit</a>
                       <a class="btn btn-sm btn-cyan" href="{{url('admin/delivery_boy/view/'.Crypt::encryptString($delivery_boy->delivery_boy_id))}}">View</a>

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
  </div>



<script>

$(document).ready(function() {
 $('#reset').click(function(){
     $('#store_id').remove();
     $('#date_from').remove();
     $('#date_to').remove();

    $('#date_froml').append('<input type="date" class="form-control"  name="date_from" id="date_from"   placeholder="From Date">');
    $('#date_tol').append('<input type="date" class="form-control" name="date_to"   id="date_to" placeholder="To Date">');

     $('#store_idl').append('  <select class="form-control" name="store_id" id="store_id"><option value=""> Select Store</option>@foreach ($stores as $key)<option value=" {{ $key->store_id}} "> {{ $key->store_name}}</option>@endforeach</select>');


   });
});

</script>


  @endsection
