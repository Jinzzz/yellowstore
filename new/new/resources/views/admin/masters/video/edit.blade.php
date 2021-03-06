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
               <form action="{{route('admin.update_video',$video->video_id)}}" method="POST"  enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                      <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Platform *</label>
                                <select name="platform" required=""  class="form-control">
                                 <option value="">Platform</option>
                                 <option {{old('platform',$video->platform) == 'Youtube' ? 'selected':''}} value="Youtube">Youtube</option>
                                 <option {{old('platform',$video->platform) == 'Vimeo' ? 'selected':''}} value="Vimeo">Vimeo</option>
                                </select>
                            </div>
                            </div>
                        <div class="col-md-12">
                             <div class="form-group">
                                <label class="form-label">Embedded Code *</label>
                              <textarea class="form-control"  name="video_code" required rows="4" placeholder="Embedded Code">{{old('video_code',$video->video_code)}}</textarea>                            
                           </div>
                        </div>


                        <div class="col-md-2">
                            <br> <br>
                            <label class="custom-switch">
                            <input type="hidden" name="status" value=0 />
                            <input type="checkbox" name="status" @if ($video->status == 1) checked @endif  value=1 class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
													</label>
                            </div>


                  </div>
                    <div class="form-group">
                           <center>
                           <button type="submit" id="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Update</button>
                           <button type="reset" class="btn btn-raised btn-success">
                           Reset</button>
                           <a class="btn btn-danger" href="{{ route('admin.videos') }}">Cancel</a>
                           </center>
                        </div>
               </form>

         </div>
      </div>
   </div>
</div>

 @endsection
