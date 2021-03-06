@extends('store.layouts.app')
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
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif

               <form action="{{route('store.update_store_settings')}}" method="POST"
                  enctype="multipart/form-data">
                  @csrf
              <div class="row">



                <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Service Area(km)</label>
                           <input type="number"  class="form-control" required  onchange="findKM(this.value)"
                              id="service_area" name="service_area"  value="{{old('service_area',$store->service_area)}}" placeholder="Service Area(km)">
                        </div>
                     </div>


                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Service District *</label>
                           <select name="service_district" required id="city" class="form-control"  >
                                 <option value=""> Service District</option>
                                @foreach($districts as $key)
                                <option {{old('service_district',@$store->store_district_id) == $key->district_id ? 'selected':''}} value="{{$key->district_id }}"> {{$key->district_name }} </option>
                                @endforeach
                              </select>
                        </div>
                     </div>

                       <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Service Town *</label>
                           <select name="service_town" required id="town" class="form-control"  >
                                @if(old('service_town') || @$store->town_id)
                                @php
                                    $town = \DB::table('mst_towns')->where('town_id',old('service_town',@$store->town_id))->first();
                                @endphp
                                <option  value="{{$town->town_id}}"> {{$town->town_name}} </option>
                            @else
                                <option value="">Service Town</option>
                             @endif
                              </select>
                        </div>
                     </div>


                  <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Business Type *</label>
                           <select name="business_type_id" required id="business_type" class="form-control"  >
                                 <option value=""> Select Business Type</option>
                                @foreach($business_types as $key)
                                <option {{old('business_type_id',$store->business_type_id) == $key->business_type_id ? 'selected':''}} value="{{$key->business_type_id }}"> {{$key->business_type_name }} </option>
                                @endforeach
                              </select>
                        </div>
                     </div>


                     <table class="table">
                       <thead>
                         <tr>
                           <th>Starting(km)</th>
                           <th></th>
                           <th>Ending(km)</th>
                           <th>Delivery Charges</th>
                           <th>Packing Charges</th>
                         </tr>
                       </thead>
                       <tbody id="table_body">
                       @if ($settingcount > 0)
                           
                          @foreach ($store_settings as $data)
                              <tr >
                              <td>
                                <input readonly type="number" id="start0" value="{{ $data->service_start }}" class="form-control" name="start[]">
                              </td>
                                <td class="text-center"> - </td>
                              <td>
                                <input readonly type="number" id="end0"  value="{{ $data->service_end }}" class="form-control"   name="end[]">
                              </td>
                              <td>
                                <input type="number" required value="{{ $data->delivery_charge }}" id="delivery_charge0" class="form-control"  name="delivery_charge[]">
                              </td>
                              <td>
                                <input type="number" required value="{{ $data->packing_charge }}"  id="packing_charge0" class="form-control"  name="packing_charge[]">
                              </td>
                            </tr>
                          @endforeach

                        @endif
                         
                       </tbody>
                     </table>

                   
                    <div class="col-md-12">
                      <div class="form-group">
                        <center>
                              <button type="submit" class="btn btn-block btn-raised btn-info">Update</button>
                <br>
                              <a href="{{ route('store.time_slots') }}" style="color:white;"  class="btn  btn-block btn-raised btn-info">Working Days & Time</a>
                        </center>
                      </div>
                    </div>

                     

                  </div>
                <br>
             
       </form>
           
      </div>
   </div>
</div>
</div>
@endsection

{{-- .varient {
  background-color: #EDEDFD;
  border: 1px  grey;
} --}}

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>

<script>

function findKM(km)
{
  //if((km % 5) != 0)
 // { 
  //  $('#service_area').val(0);
  //}
 // {
    var km_count =  km / 5;
     $('#table_body').empty();
    var v1 = 0.1;

    var i = 1;
    for(i = 1; i <= km_count; i++)
    {
     // var html = "";
     var v2 = i * 5;
     var v1 = (v2 - 4.9);
    
      $('#table_body').append('<tr><td><input type="number" readonly step="0.1" id="start'+i+'" value="'+v1.toFixed(1)+'" class="form-control" name="start[]"></td><td class="text-center"> - </td><td><input readonly type="number" id="end'+i+'" step="0.1"  value="'+v2+'"  class="form-control"   name="end[]"></td><td><input type="number" id="delivery_charge'+i+'" class="form-control" required name="delivery_charge[]"></td><td><input type="number" id="packing_charge'+i+'" required class="form-control"  name="packing_charge[]"></td></tr>');
    }

    if((km % 5) > 0)
    {
      var v4 = km % 5;
      if(km > 5)
      {
        v1 = v1 + 5;
        v4 = v4 + v2;

      }

      $('#table_body').append('<tr><td><input readonly type="number" step="0.1" id="start'+i+'" value="'+v1.toFixed(1)+'" class="form-control" name="start[]"></td><td class="text-center"> - </td><td><input readonly type="number" id="end'+i+'" step="0.1"  value="'+v4+'"  class="form-control"   name="end[]"></td><td><input type="number" id="delivery_charge'+i+'" class="form-control" required  name="delivery_charge[]"></td><td><input type="number" required id="packing_charge'+i+'" class="form-control"  name="packing_charge[]"></td></tr>');
    }
  //}
}



$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });

          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/

        });
        fileReader.readAsDataURL(f);
      }
      console.log(files);
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
</script>


<script type="text/javascript">


$(document).ready(function() {
   var wrapper      = $(".BaseFeatureArea"); //Fields wrapper
  var add_button      = $(".addBaseFeatureImage"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    //max input box allowed
      x++; //text box increment
      $(wrapper).append('<div>  <input type="file" class="form-control" name="product_image[]"  value="{{old('product_image')}}" placeholder="Base Product Feature Image" /> <a href="#" class="remove_field btn btn-small btn-danger">Remove</a></div>'); //add input box

  });

  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
  })
});




 $(document).ready(function() {

var agc = 0;

       $('.attr_group').change(function(){
       // alert("hi");
       if(agc != 0)
       { 
       // alert("dd");
        var attr_group_id = $(this).val();

        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('store/product/ajax/get_attr_value') }}?attr_group_id="+attr_group_id,


          success:function(res){
            //alert(data);
            if(res){
            $('.attr_value').prop("diabled",false);
            $('.attr_value').empty();
            $('.attr_value').append('<option value="">Value</option>');
            $.each(res,function(attr_value_id,group_value)
            {
              $('.attr_value').append('<option value="'+attr_value_id+'">'+group_value+'</option>');
            });

            }else
            {
              $('.attr_value').empty();

            }
            }

        });
       }
       else
       {
         agc++;
       }
      });

    });
  $(document).ready(function() {
    var pcc = 0;
      //  alert("dd");
       $('#business_type').change(function(){
         if(pcc != 0)
         { 
        var business_type_id = $(this).val();
       //alert(business_type_id);
        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('store/product/ajax/get_category') }}?business_type_id="+business_type_id,


          success:function(res){
           // alert(data);
            if(res){
            $('#category').prop("diabled",false);
            $('#category').empty();
            $('#category').append('<option value="">Product Category</option>');
            $.each(res,function(category_id,category_name)
            {
              $('#category').append('<option value="'+category_id+'">'+category_name+'</option>');
            });

            }else
            {
              $('#category').empty();

            }
            }

        });
         }else{
           pcc++;
         }
      });

    });


    $(document).ready(function() {
    var cc = 0;


       $('#city').change(function(){
          if(cc != 0)
         { 

        var city_id = $(this).val();
       // alert(city_id);
        var _token= $('input[name="_token"]').val();

        $.ajax({
          type:"GET",
          url:"{{ url('store/ajax/get_town') }}?city_id="+city_id ,

          success:function(res){

           if(res){
              console.log(res);
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
         else
         {
           cc++;
         }
      });

    });

</script>
