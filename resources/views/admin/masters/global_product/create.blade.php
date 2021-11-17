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
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               <form action="{{route('admin.store_global_product')}}" method="POST"  enctype="multipart/form-data">
                  @csrf
                  <div class="row">

                      <div class="col-md-12">
                        <div class="form-group">
                           <label class="form-label">Product Name *</label>
                           <input type="text" class="form-control" required
                              name="product_name" value="{{old('product_name')}}" placeholder="Product Name">
                        </div>
                     </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" >Product Description *</label>
                            <textarea class="form-control" id="product_description" required
                                name="product_description" rows="2" cols="3" placeholder="Product Description">{{old('product_description')}}</textarea>
                        </div>
                     </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Regular Price *</label>
                            <input type="text" class="form-control" required onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="regular_price"   id="regular_price" value="{{old('regular_price')}}" placeholder="Regular Price">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Sale Price *</label>
                            <input type="text" class="form-control" required onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="sale_price"  id="sale_price" value="{{old('sale_price')}}" placeholder="Sale Price">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Tax *</label>
                           <select required  name="tax_id" id="tax_id" class="form-control"  >
                                 <option value="">Tax</option>
                                @foreach($tax as $key)
                                <option {{old('tax_id') == $key->tax_id ? 'selected':''}} value="{{$key->tax_id }}"> {{$key->tax_name }} ( {{$key->tax_value}} ) </option>
                                @endforeach
                              </select>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Min Stock *</label>
                           <select required name="min_stock" id="min_stock" class="form-control"  >
                                 <option value="">Min Stock</option>
                                 @for ($i = 0; $i < 21; $i++)
                                    <option {{old('min_stock') == $i ? 'selected':''}}  value="{{$i}}">{{$i}}</option>
                                 @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Code *</label>
                            <input type="text" required class="form-control" name="product_code" id="product_code" value="{{old('product_code')}}" placeholder="Product Code">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Product Type *</label>
                           <select name="business_type_id" required id="business_type" class="form-control"  >
                                 <option value=""> Product Type</option>
                                @foreach($business_types as $key)
                                <option {{old('business_type_id') == $key->business_type_id ? 'selected':''}} value="{{$key->business_type_id }}"> {{$key->business_type_name }} </option>
                                @endforeach
                              </select>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Color *</label>
                           <select name="color_id" required id="color_id" class="form-control"  >
                                 <option value="">Color</option>
                                @foreach($colors as $key)
                                <option {{old('color_id') == $key->attr_value_id ? 'selected':''}} value="{{$key->attr_value_id }}"> {{$key->group_value }} </option>
                                @endforeach
                              </select>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Brand *</label>
                            <input type="text" required class="form-control" name="product_brand" id="product_brand" value="{{old('product_brand')}}" placeholder="Product Brand">
                        </div>
                    </div>

                    <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">Attribute *</label>
                       <select name="attr_group_id" required class="attr_group form-control" >
                         <option value="">Attribute</option>
                          @foreach($attr_groups as $key)
                          <option {{old('attr_group_id') == $key->attr_group_id ? 'selected':''}} value="{{$key->attr_group_id}}"> {{$key->group_name}} </option>
                                @endforeach
                              </select>
                     </div>
                   </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Value *</label>
                            <select name="attr_value_id" required  class="attr_value form-control" >
                            <option value="">Value</option>
                            @if( old('attr_value_id'))
                              @php
                                $att_value = DB::table('mst_attribute_values')->where('attr_value_id',old('attr_value_id'))->first();
                              @endphp
                              <option selected value="{{  @$att_value->attr_value_id}}">{{ @$att_value->group_value }}</option>
                            @endif
                                </select>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" >Product Category * </label>
                            <select name="product_cat_id" required id="category" class="form-control"  >
                                 <option value="">Product Category</option>
                                 @if( old('product_cat_id'))
                              @php
                                $category = DB::table('mst_store_categories')->where('category_id',old('product_cat_id'))->first();
                              @endphp
                              <option selected value="{{ @$category->category_id }}">{{ @$category->category_name }}</option>
                            @endif       

                            </select>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Vendor *</label>
                           <select required name="vendor_id" id="vendor_id" class="form-control"  >
                                 <option value="">Vendor</option>
                                @foreach($agencies as $key)
                                <option {{old('vendor_id') == $key->agency_id ? 'selected':''}} value="{{$key->agency_id }}"> {{$key->agency_name }} </option>
                                @endforeach
                              </select>
                        </div>
                     </div>

                <div class="col-md-12">
                   <div class="form-group">
                    <div class="BaseFeatureArea">
                        <label class="form-label">Upload Images*</label>
                        <input type="file" required accept="image/png, image/jpeg., image/jpg"  class="form-control" name="product_image[]" multiple="" value="{{old('product_image')}}" placeholder="Product Feature Image">
                        <br>
                     </div>
                     </div>
                 </div>



        <h4 class="ml-4">Videos</h4>

                      <div id="teamArea" class="container">
                      <div  class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Platform </label>
                                <select name="platform[]"   class="form-control">
                                 <option value="">Platform</option>
                                 <option {{old('platform.0') == 'Youtube' ? 'selected':''}} value="Youtube">Youtube</option>
                                 <option {{old('platform.0') == 'Vimeo' ? 'selected':''}} value="Vimeo">Vimeo</option>
                                </select>
                            </div>
                         </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="form-label">Embedded Code </label>
                                <textarea class="form-control"  name="video_code[]" rows="4" placeholder="Embedded Code">{{old('video_code.0')}}</textarea>                            
                            </div>
                          </div>
                        </div>
                    </div>
                
                      <div class="col-md-2">
                        <div class="form-group">
                            <button type="button" id="addImage" class="mt-2 btn btn-raised btn-success"> Add More</button>
                        </div>
                      </div>
                              
                  </div>
                    <div class="form-group">
                           <center>
                           <button type="submit" id="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Add</button>
                           <button type="reset" class="btn btn-raised btn-success">
                           Reset</button>
                           <a class="btn btn-danger" href="{{ route('admin.global_products') }}">Cancel</a>
                           </center>
                        </div>
               </form>

         </div>
      </div>
   </div>
</div>
  <script src="{{ asset('vendor\unisharp\laravel-ckeditor/ckeditor.js')}}"></script>
   <script>CKEDITOR.replace('product_description');</script>

<script>



$(document).ready(function() {
   var wrapper      = $("#teamArea"); //Fields wrapper
  var add_button      = $("#addImage"); //Add button ID

  var x = 1; //initlal text box count


  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    //max input box allowed
      x++; //text box increment
      $(wrapper).append('<div> <br> <div  class="row"><div class="col-md-12"><div class="form-group"><label class="form-label">Platform</label><select name="platform[]"  class="form-control"><option value="">Platform</option><option value="Youtube">Youtube</option><option value="Vimeo">Vimeo</option></select></div></div><div class="col-md-12"><div class="form-group"><label class="form-label">Embedded Code </label><textarea class="form-control"  name="video_code[]"  rows="3" placeholder="Embedded Code"></textarea></div></div></div><a href="#" class="remove_field mb-2 btn btn-info btn btn-sm">Remove</a></div>'); //add input box
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
          url:"{{ url('admin/product/ajax/get_attr_value') }}?attr_group_id="+attr_group_id,


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
          url:"{{ url('admin/product/ajax/get_category') }}?business_type_id="+business_type_id,
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

</script>
 @endsection
