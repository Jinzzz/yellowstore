@extends('admin.layouts.app')
@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h3 class="mb-0 card-title">{{$pageTitle}}</h3>
            </div>
            <div class="card-body">
               @if ($message = Session::get('status'))
               <div class="alert alert-success">
                  <p>{{ $message }}</p>
               </div>
               @endif
            </div>
            <div class="col-lg-12">
               @if ($errors->any())
               <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                  <ul>
                     @foreach (@$errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               <form id="myForm"  onsubmit="return validateForm()" action="{{route('admin.store')}}" method="POST"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label"> Store Name *</label>
                           <input type="text" class="form-control" required name="store_name" value="{{old('store_name')}}" placeholder="Store Name">
                        </div>
                      </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Store Mobile Number *</label>
                                <input type="text" maxlength="10" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="store_mobile" class="form-control"  value="{{old('store_mobile')}}" placeholder="Store Mobile Number ">
                            </div>
                        </div>

                     <div class="col-md-6">
                         <div class="form-group">
                           <label class="form-label">Contact Person Name *</label>
                            <input type="text"  name="store_contact_person_name" class="form-control"  value="{{old('store_contact_person_name')}}" placeholder="Contact Person Name">
                           </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Contact Person Number</label>
                            <input type="text" maxlength="10" name="store_contact_person_phone_number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control" value="{{old('store_contact_person_phone_number')}}" placeholder="Contact Person Number">
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Store Email </label>
                            <input type="email" id="email_"  name="email" class="form-control" placeholder="Store Email" value="{{old('email')}}">
                            <span id="error_email"></span>
                        </div>
                     </div>

                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Country *</label>
                            <select name="store_country_id" required="" onchange=" @if(old('store_country_id'))  @else findCountry(this.value) @endif" class="form-control" id="country" >
                                 <option value=""> Select Country</option>
                                @foreach( @$countries as $key)
                                <option {{old('store_country_id') == $key->country_id ? 'selected':''}} value="{{$key->country_id}}"> {{$key->country_name }} </option>
                                @endforeach
                              </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">State *</label>
                            <select name="store_state_id" required=""  onchange=" @if(old('store_state_id'))  @else findCity(this.value) @endif  "  class="form-control" id="state" >
                            @if(old('store_state_id'))
                                @php
                                    $town = \DB::table('sys_states')->where('state_id',old('store_state_id'))->first();
                                @endphp
                                <option  value="{{$town->state_id}}"> {{$town->state_name}} </option>
                            @else
                            <option  value=""> Select State</option>
                             @endif

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">District *</label>
                          <select name="store_district_id" required="" onchange=" @if(old('store_state_id'))  @else findTown(this.value) @endif " class="form-control" id="city">
                                 @if(old('store_district_id'))
                                @php
                                    $town = \DB::table('mst_districts')->where('district_id',old('store_district_id'))->first();
                                @endphp
                                <option  value="{{$town->district_id}}"> {{$town->district_name}} </option>
                            @else
                             <option value="">Select City</option>
                             @endif
                          </select>
                        </div>
                    </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Town *</label>
                              <select name="store_town" required="" class="form-control" id="town">
                             @if(old('store_town'))
                                @php
                                    $town = \DB::table('mst_towns')->where('town_id',old('store_town'))->first();
                                @endphp
                                <option  value="{{$town->town_id}}"> {{$town->town_name}} </option>
                            @else
                                <option value="">Select Town</option>
                             @endif
                              </select>
                           </div>
                        </div>

                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="form-label">Store Place *</label>
                              <input required type="text" class="form-control" name="store_place" value="{{old('store_place')}}" placeholder="Store Place">
                        </div>
                    </div>

                      <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Store Pincode *</label>
                           <input type="text" class="form-control" name="store_pincode" value="{{old('store_pincode')}}" placeholder="Store Pincode">
                        </div>
                    </div>

                    <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label"> Username *</label>
                          <input type="text" id="username" name="store_username" class="form-control" placeholder="Username" value="{{old('store_username')}}">
                           <span id="error_username"></span>
                        </div>
                    </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <label id="passlabel" class="form-label">Password *</label>
                          <input type="Password" onkeyup="validatePassLength()"  id="password" required="" name="password" class="form-control" placeholder=" Password" value="{{old('password')}}">
                        <p id="showpassmessage"><p>
                    </div>
                   </div>
                   <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password"  class="form-control" onkeyup="validatePass()"
                            name="password_confirmation" id="confirm_password" value="{{old('password_confirmation')}}"  placeholder="Confirm Password">
                                <p id="showmessage"><p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Store Commission Amount (Monthly) *</label>
                          <input type="number"  step="0.1"  id="exclude" required name="store_commision_amount" class="form-control" placeholder="Store Commision Amount (Monthly) "  value="{{old('store_commision_amount')}}">
                        </div>
                     </div>


                     <div class="col-md-6">
                           <div class="form-group">
                          <label class="form-label">Store Commission Percentage (Per Order) *</label>
                          <input type="number" step="0.1" id="exclude"  required name="store_commision_percentage" class="form-control" placeholder="Store Commission Percentage (Per Order)" value="{{old('store_commision_percentage')}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Website Link</label>
                           <input type="url" class="form-control" name="store_website_link" value="{{old('store_website_link')}}" placeholder="Website Link">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Business Type *</label>
                            <select name="business_type_id" required="" class="form-control"  >
                                 <option value=""> Select Business Type</option>
                                @foreach(@$business_types as $key)
                                <option {{old('business_type_id') == $key->business_type_id ? 'selected':''}} value="{{$key->business_type_id}}"> {{$key->business_type_name }} </option>
                                @endforeach
                              </select>
                       </div>
                    </div>
    @if (auth()->user()->user_role_id == 0)


                      <div class="col-md-6">
                          <div class="form-group">
                           <label class="form-label">Sub Admin *</label>
                             <select required name="subadmin_id"  class="form-control"  >
                                  <option value=""> Select Sub Admin</option>
                                 @foreach(@$subadmins as $key)
                                 <option {{old('subadmin_id') == $key->id ? 'selected':''}} value="{{$key->id}}"> {{$key->name }} </option>
                                 @endforeach
                               </select>
                           </div>
                      </div>
    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Store License *</label>
                           <input type="text" class="form-control" required name="store_document_license" value="{{old('store_document_license')}}" placeholder="Store License">
                        </div>
                     </div>


                     <div class="col-md-6">
                        <div class="form-group">

                           <label class="form-label"> Store GSTIN *</label>
                           <input type="text" class="form-control" required
                           name="store_document_gstin" value="{{old('store_document_gstin')}}" placeholder="Store GSTIN">
                        </div>
                     </div>


                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="form-label">Store Address *</label>
                           <textarea class="form-control"  name="store_primary_address" required
                           rows="4" placeholder="Store Address">{{old('store_primary_address')}}</textarea>
                        </div>
                     </div>


                  </div>


                   <h3 class="mb-0 card-title">Add Store Documents </h3>
                   <div class="card-body">
                  <div class="row">
                         <div id="doc_area">



                    <div class="col-md-10">
                        <div class="form-group">
                           <label class="form-label"> Document Title </label>
                           <input type="text" class="form-control"
                           name="store_document_other_file_head[]" value="{{ old('store_document_other_file_head.0') }}"   placeholder="Document Title">
                      </div>
                     </div>

                     <div class="col-md-10">
                        <div class="form-group">
                           <label class="form-label"> Other File [in pdf,doc,docx or txt] </label>
                           <input type="file" accept=".pdf,.docx,.txt,.doc" class="form-control"
                           name="store_document_other_file[]"  placeholder="Store Document  File">
                      </div>
                     </div>


                        </div>

                      <div class="col-md-2">
                        <div class="form-group">
                           <label class="form-label">Add more</label>
                            <button type="button" id="addDoc" class="btn btn-raised btn-success">
                      Add More</button>
                        </div>
                        </div>
                  </div>
                    </div>

              <h3 class="mb-0 card-title">Add Store Images</h3>
                   <div class="card-body">
                  <div class="row">

                     <div class="col-md-6">
                        <div class="form-group">
                           <div id="teamArea">
                           <label class="form-label">Images (1000*800)</label>
                           <input type="file"  class="form-control" accept="image/x-png,image/jpg,image/jpeg" multiple="" name="store_image[]"  placeholder="Images">
                        </div>
                     </div>
                     </div>

                  <div class="col-md-2">
                        <div class="form-group">
                           <label class="form-label">Add more</label>
                            <button type="button" id="addImage" class="btn btn-raised btn-success">
                      Add More</button>
                        </div>
                        </div>
                    </div>
                    </div>
</div>




                    <div class="form-group">
                           <center>
                           <button type="submit" id="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Add</button>
                           <button type="reset" class="btn btn-raised btn-success">
                           Reset</button>
                           <a class="btn btn-danger" href="{{ route('admin.list_store') }}">Cancel</a>
                           </center>
                        </div>
               </form>
           {{--  </div>
         </div> --}}
      </div>
   </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>


<script>

var excludedEl = document.getElementById('exclude');
        $('body').css('overflow','auto');

$(window).on("wheel", function(e) {

        $('body').css('overflow','auto');


  focusedEl = document.activeElement;
  if(focusedEl === excludedEl){
    return;
  }
  if (focusedEl.nodeName='input' && focusedEl.type && focusedEl.type.match(/number/i)){
    e.preventDefault();
        $('body').css('overflow','hidden');
// $('body').css('position','fixed');
    var max=null;
    var min=null;
    if(focusedEl.hasAttribute('max')){
      max = focusedEl.getAttribute('max');
    }
    if(focusedEl.hasAttribute('min')){
      min = focusedEl.getAttribute('min');
    }
    var value = parseFloat(focusedEl.value, 10);
    if (e.originalEvent.deltaY < 0) {
      value++;
      if (max !== null && value > max) {
        value = max;
      }
    } else {
      value--;
      if (min !== null && value < min) {
        value = min;
      }
    }
    focusedEl.value = value;
  }
});

</script>


<script>
function validatePass() {
  var x = document.forms["myForm"]["password"].value;
  var y = document.forms["myForm"]["confirm_password"].value;
   document.getElementById('showmessage').innerHTML = '';
    if (x == y) {
    document.getElementById('password').border.color = 'green';
    document.getElementById('confirm_password').border.color = 'green';


    } else {
        document.getElementById('showmessage').style.color = 'red';
        document.getElementById('showmessage').innerHTML = 'passwords not matching';
    }
}
</script>

<script>
function validatePassLength() {
  var x = document.forms["myForm"]["password"].value;
   if(x.length < 8)
   {
     document.getElementById('showpassmessage').style.color = 'red';
            document.getElementById('showpassmessage').innerHTML = 'You have to enter at least 8 digits!';
   }
   else
   {
                   document.getElementById('showpassmessage').innerHTML = '';

   }

}
</script>





<script>
function validateForm() {
  var x = document.forms["myForm"]["password"].value;
  var y = document.forms["myForm"]["confirm_password"].value;
   if(x.length >= 8)
    {
        if (x != y) {
            document.getElementById('showmessage').style.color = 'red';
            document.getElementById('showmessage').innerHTML = 'passwords not matching';
            var elmnt = document.getElementById("passlabel");
            elmnt.scrollIntoView();
            return false;
        }
    }
    else
    {
           document.getElementById('showpassmessage').style.color = 'red';
            document.getElementById('showpassmessage').innerHTML = 'You have to enter at least 8 digits!';
            var elmnt = document.getElementById("passlabel");
            elmnt.scrollIntoView();
            return false;
    }
}
</script>




<script type="text/javascript">

function findCountry(country_id)
{
 $('#city').empty();
         $('#city').append('<option value="">Select City</option>');

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

function findCity(state_id){


       //alert(product_cat_id);
        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get_city') }}?state_id="+state_id ,


          success:function(res){
           // alert(data);
            if(res){
            $('#city').prop("diabled",false);
            $('#city').empty();
            $('#city').append('<option value="">Select City</option>');
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

function findTown(city_id){

        var _token= $('input[name="_token"]').val();

        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get_town') }}?city_id="+city_id ,

          success:function(res){

           if(res){
            //  console.log(res);
            $('#town').prop("diabled",false);
            $('#town').empty();

            $('#town').append('<option value="">Select Town</option>');
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
</script>




<script>
$(document).ready(function() {
   var wrapper      = $("#teamArea"); //Fields wrapper
  var add_button      = $("#addImage"); //Add button ID

  var x = 1; //initlal text box count


  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    //max input box allowed
      x++; //text box increment
      $(wrapper).append('<div> <br>  <input type="file" accept="image/x-png,image/jpg,image/jpeg" class="form-control" multiple="" name="store_image[]"  placeholder="Images"> <a href="#" class="remove_field btn btn-info btn btn-sm">Remove</a></div>'); //add input box

  });



  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
  })
});


$(document).ready(function() {
   var wrapper      = $("#doc_area"); //Fields wrapper
  var add_button      = $("#addDoc"); //Add button ID

  var x = 1; //initlal text box count


  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    //max input box allowed
x++; //text box increment
$(wrapper).append('<div class="border border-primary mb=2"> <div class="col-md-10"><div class="form-group"><label class="form-label"> Document Title </label><input type="text" class="form-control"name="store_document_other_file_head[]" placeholder="Store Document File Title"></div></div><div class="col-md-10"><div class="form-group"><label class="form-label"> Other File [in pdf,doc,docx or txt] </label><input type="file" class="form-control" accept=".pdf,.docx,.txt,.doc" name="store_document_other_file[]" placeholder="Store Document Other File"></div></div><a href="#" class="remove_field btn btn-info btn btn-sm">Remove</a></div><br>'); //add input box

  });


  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
  })
});

$(document).ready(function(){
  $("#email").blur(function(){
   var error_email = '';
  var email = $(this).val();
  //alert(email);
  var _token = $('input[name="_token"]').val();
 var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

     $.ajax({
    url:"{{ route('admin.unique_email') }}",
    method:"POST",
    data:{email:email, _token:_token},
    success:function(result)
    {

         if(!filter.test(email))
        {
             if(email != "")
            {

                    $('#error_email').html('<label class="text-danger">Invalid Email</label>');
                    $('#email').addClass('has-error');
                    $('#submit').attr('disabled', 'disabled');
            }
            else{
                 $('#error_email').html('<label class="text-danger"></label>');
                    $('#submit').attr('disabled', 'disabled');
            }
        }
        else if(email != "")
        {
                    if(result == 'unique')
                    {
                    $('#error_email').html('<label class="text-success">Email Available</label>');
                    $('#email').removeClass('has-error');
                    $('#submit').attr('disabled', false);
                    }
                    else
                    {
                    $('#error_email').html('<label class="text-danger">Email Already Exist </label>');
                    $('#email').addClass('has-error');
                    $('#submit').attr('disabled', 'disabled');
                    }
        }

    }
   })
  });
});

$(document).ready(function(){
  $("#username").blur(function(){
   var error_username = '';
  var store_username = $(this).val();
  //alert(email);
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:"{{ route('admin.unique_username') }}",
    method:"POST",
    data:{store_username:store_username, _token:_token},
    success:function(result)
    {
        if(store_username != "" && store_username.length > 5)
        {
              if(result == 'unique')
            {
                $('#error_username').html('<label class="text-success">Username Available</label>');
                $('#username').removeClass('has-error');
                $('#submit').attr('disabled', false);
            }
            else
            {
                $('#error_username').html('<label class="text-danger">Username Already Exist </label>');
                $('#username').addClass('has-error');
                $('#submit').attr('disabled', 'disabled');

            }

        }
        else
        {

                if(store_username.length <= 5 && store_username.length != 0)
                {
                     $('#error_username').html('<label class="text-danger">Username must have 6 digits</label>');
                    $('#username').addClass('has-error');
                    $('#submit').attr('disabled', 'disabled');
                }
                else
                {
                    $('#error_username').html('<label class="text-danger"></label>');
                $('#submit').attr('disabled', 'disabled');
                }

        }

    }
   })
  });
});

</script>
