@extends('admin.layouts.app')
@section('content')
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
                    <div class="card-body border">
                <form onsubmit="return emptyCheck()" action="{{route('admin.list_store')}}" method="GET"
                         enctype="multipart/form-data">
                   @csrf
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <label class="form-label">Country</label>
                                             <div id="countryl"></div>
<select name="store_country_id"  class="form-control" id="country" >
                                 <option value=""> Select Country</option>
                                @foreach($countries as $key)
                                <option {{request()->input('store_country_id') == $key->country_id ? 'selected':''}} value="{{$key->country_id}}"> {{$key->country_name }} </option>
                                @endforeach
                              </select>
                  </div>
               </div>
                <div class="col-md-3">
                  <div class="form-group">
                     <label class="form-label">State</label>
                      <select name="store_state_id"  class="form-control" id="state" >
                       <option {{request()->input('store_state_id')}} value=""> Select State</option>
                               @if (request()->input('store_state_id'))
                                    @foreach(@$states as $key)
                                    <option {{request()->input('store_state_id') == @$key->state_id ? 'selected':''}} value="{{@$key->state_id}}"> {{@$key->state_name }} </option>
                                @endforeach
                               @endif
                       </select>
                  </div>
               </div>
                <div class="col-md-3">
                  <div class="form-group">
                     <label class="form-label">District</label>
                     <select name="store_district_id" class="form-control" id="city">
                             <option value="">Select District</option>
                               @if (request()->input('store_district_id'))
                                  @foreach(@$districts as $key)
                                    <option {{request()->input('store_district_id') == @$key->district_id ? 'selected':''}} value="{{@$key->district_id}}"> {{@$key->district_name }} </option>
                                    @endforeach
                                @endif
                          </select>
                  </div>
               </div>

                <div class="col-md-3">
                  <div class="form-group">
                     <label class="form-label">Town</label>
                     <select name="store_town_id" class="form-control" id="town">
                             <option value="">Select Town</option>
                               @if (request()->input('store_town_id'))
                                 @foreach(@$town as $key)
                                    <option {{request()->input('store_town_id') == @$key->town_id ? 'selected':''}} value="{{@$key->town_id}}"> {{@$key->town_name }} </option>
                                @endforeach
                            @endif
                        </select>
                  </div>
               </div>


             </div>
             <div class="row">
               <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label"> Store Name</label>
                                         <div id="store_namel"></div>
 <input type="text" class="form-control" name="store_name" id="store_name" value="{{request()->input('store_name')}}" placeholder="Store Name">
                        </div>
                      </div>
                  <div class="col-md-4">
                   <div class="form-group">
                    <label class="form-label"> Store Email</label>
                                         <div id="store_email_addressl"></div>
 <input type="text" class="form-control" id="store_email_address" name="store_email_address" value="{{request()->input('store_email_address')}}" placeholder="Store Email">
                        </div>
                      </div>

                <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label"> Store Mobile Number</label>
                                       <div id="store_contact_person_phone_numberl"></div>
 <input type="text" id="store_contact_person_phone_number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="10" name="store_contact_person_phone_number" class="form-control"  value="{{request()->input('store_contact_person_phone_number')}}" placeholder="Store Mobile Number">
                        </div>
                      </div>
                    </div>
                        <div class="row">

 @if (auth()->user()->user_role_id == 0)
                      <div class="col-md-4">
                          <div class="form-group">
                           <label class="form-label">Sub Admin</label>
                             <select name="subadmin_id"  class="form-control"  >
                                  <option value=""> Select Sub Admin</option>
                                 @foreach(@$subadmins as $key)
                                 <option {{request()->input('subadmin_id') == $key->id ? 'selected':''}} value="{{$key->id}}"> {{$key->name }} </option>
                                 @endforeach
                               </select>
                           </div>
                      </div>
    @endif

               <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label"> Status</label>
                                        <div id="store_account_statusl"></div>
  <select name="store_account_status" id="store_account_status"  class="form-control" >
                 <option value="" >Select Status</option>
                 <option {{request()->input('store_account_status') == '1' ? 'selected':''}} value="1" >Active</option>
                 <option {{request()->input('store_account_status') == '0' ? 'selected':''}} value="0" >InActive</option>
                 </select>
                        </div>
                      </div>

               {{--
                <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label"> Mobile</label>
                  <input type="text" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="store_contact_person_phone_number" class="form-control"  value="{{old('store_contact_person_phone_number')}}" placeholder="Contact Person Number">
                        </div>
                      </div> --}}
                     <div class="col-md-12">
                     <div class="form-group">
                           <center>
                           <button type="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Filter</button>
                           <button type="reset" id="reset" class="btn btn-raised btn-success">Reset</button>
                          <a href="{{route('admin.list_store')}}"  class="btn btn-info">Cancel</a>
                           </center>
                        </div>
                  </div>
                </div>
                   </form>
                </div>

                    <div class="card-body">
                        <a href="  {{route('admin.create_store')}} " class="btn btn-block btn-info">
                           <i class="fa fa-plus"></i>
                           Create Store
                        </a>
                        </br>
                        <div class="table-responsive">
                           <table id="exampletable" class="table table-striped table-bordered text-nowrap w-100">
                              <thead>
                                 <tr>
                                    <th class="wd-15p">SL<br>No</th>
                                    <th class="wd-15p">{{ __('Name') }}</th>
                                    <th class="wd-15p">Contact<br>Person</th>
                                    <th class="wd-15p">Contact<br>Person Number</th>
                                    <th class="wd-20p">{{__('Email')}}</th>
    @if(auth()->user()->user_role_id  == 0)
                                    <th class="wd-20p">Sub<br>Admin</th>
    @endif

                                    <th class="wd-20p">{{__('Status')}}</th>
                                    <th class="wd-15p">{{__('Action')}}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @php
                                 $i = 0;
                                 @endphp
                                 @foreach ($stores as $store)
                                 <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $store->store_name}}</td>
                                    <td>{{$store->store_contact_person_name}} </td>
                                    <td>{{$store->store_contact_person_phone_number}} </td>
                                    <td>{{ $store->email}} </td>
    @if(auth()->user()->user_role_id  == 0)
                                    <td>{{ @$store->subadmin->name}} </td>
    @endif
                                 <td>

                                       <form action="{{route('admin.status_store',$store->store_id)}}" method="POST">

                                          @csrf
                                          @method('POST')
                                          <button type="submit"  onclick="return confirm('Do you want to Change status?');" class="btn btn-sm
                                          @if($store->store_account_status == 0) btn-danger @else btn-success @endif"> @if($store->store_account_status == 0)
                                          InActive
                                          @else
                                          Active
                                          @endif</button>
                                       </form>

                                    </td>
                                    <td>
                                       <form action="{{route('admin.destroy_store',$store->store_id)}}" method="POST">
                                        <a class="btn btn-sm btn-cyan"
                                             href="{{url('admin/store/edit/'.
                                          $store->store_name_slug)}}">Edit</a>
                                           <a class="btn btn-sm btn-info"
                                             href="{{url('admin/store/assign_agency/'.
                                          $store->store_name_slug)}}"> Agency</a> <br> <br>
                                         {{--   <a class="btn btn-sm btn-info"
                                             href="{{url('admin/store/assign_delivery_boy/'.
                                          $store->store_name_slug)}}">Delivery Boy</a>  --}}
                                          <a class="btn btn-sm btn-primary"
                                             href="{{url('admin/store/view/'.
                                          $store->store_name_slug)}}">View</a>
                                          @csrf
                                          @method('POST')
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

            <!-- MESSAGE MODAL CLOSED -->


                      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">


$(function(e) {
	 $('#exampletable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                title: 'Stores',
                footer: true,
                exportOptions: {
                     columns: [0,1,2,3,5,4,6]
                 }
            },
            {
                extend: 'excel',
                title: 'Stores',
                footer: true,
                exportOptions: {
                     columns: [0,1,2,3,5,4,6]
                 }
            }
         ]
    } );

} );





function emptyCheck() {
    var x;
    a = document.getElementById("country").value;
    b = document.getElementById("state").value;
    c = document.getElementById("city").value;
    d = document.getElementById("town").value;
    e = document.getElementById("store_email_address").value;
    f = document.getElementById("store_name").value;
    g = document.getElementById("store_account_status").value;
    h = document.getElementById("store_contact_person_phone_number").value;
    if (a == "" && b == "" && c == "" && d == "" && e == "" && f == "" && g == "" && h == "") {
        return false;
    };
}



$(document).ready(function() {
 $('#reset').click(function(){
     $('#state option:not(:first)').remove();

     $('#city option:not(:first)').remove();

     $('#town option:not(:first)').remove();


     $('#country').remove();
     $('#store_email_address').remove();
     $('#store_name').remove();
     $('#store_account_status').remove();
     $('#store_contact_person_phone_number').remove();

     $('#countryl').append(' <select name="store_country_id"  class="form-control" id="country" ><option value=""> Select Country</option>@foreach($countries as $key)<option } value="{{$key->country_id}}"> {{$key->country_name }} </option>@endforeach</select>');
     $('#store_email_addressl').append('<input type="email" class="form-control" id="store_email_address" name="store_email_address" placeholder="Store Email">');
     $('#store_namel').append('<input type="text" class="form-control" name="store_name" id="store_name"  placeholder="Store Name">');
     $('#store_account_statusl').append('<select name="store_account_status" id="store_account_status"  class="form-control" ><option value="" >Select Status</option><option  value="1" >Active</option><option  value="0" >InActive</option></select>');
     $('#store_contact_person_phone_numberl').append('<input type="number" id="store_contact_person_phone_number" maxlength="10" name="store_contact_person_phone_number" class="form-control"   placeholder="Contact Person Number">');

   });
});



       $(document).ready(function() {
           var coc = 0;
       $('#country').change(function(){

           if(coc != 0)
           {



       /* $('#city').empty();
         $('#city').append('<option value="">Select City</option>');*/
        var country_id = $(this).val();
            //alert(country_id);
        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get_state') }}?country_id="+country_id,


          success:function(res){
           // alert(data);
            if(res){
            $('#state').prop("diabled",false);
            $('#state').empty();
            // $('#city').prop("diabled",false);
            // $('#city').empty();

            $('#state').append('<option value="">Select State</option>');
            $.each(res,function(state_id,state_name)
            {
              $('#state').append('<option value="'+state_id+'">'+state_name+'</option>');
            });

            }else
            {
              $('#state').empty();

            }
            }

        });

        }
        else{
               coc++;
           }

      });

    });



//display town

    $(document).ready(function() {
        var cc = 0;
       $('#city').change(function(){
if(cc != 0 )
{


        var city_id = $(this).val();
       // alert(city_id);
        var _token= $('input[name="_token"]').val();

        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get_town') }}?city_id="+city_id ,

          success:function(res){

           if(res){
              console.log(res);
           // $('#town').prop("diabled",false);
           // $('#town').empty();

          //  $('#town').append('<option value="">Select Town</option>');
            $.each(res,function(town_id,town_name)
            {
              $('#town').append('<option value="'+town_id+'">'+town_name+'</option>');
            });

            }else
            {
              $('#town').empty();

             }
            }

        });
      }
    else
    {
        cc++;
    }


      });

    });


    $(document).ready(function() {

var sc = 0;

       $('#state').change(function(){
      if(sc != 0)
      {


        var state_id = $(this).val();
        //alert(state_id);
        var _token= $('input[name="_token"]').val();

        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get_city') }}?state_id="+state_id ,

          success:function(res){
            //alert(res);
            if(res){
           // $('#city').prop("diabled",false);
            //$('#city').empty();

           // $('#city').append('<option value="">Select City</option>');
            $.each(res,function(district_id,district_name)
            {
              $('#city').append('<option value="'+district_id+'">'+district_name+'</option>');
            });

            }else
            {
              $('#city').empty();

            }
            }

        });
    }
      else
      {
          sc++;
      }
      });

    });

</script>
            @endsection


