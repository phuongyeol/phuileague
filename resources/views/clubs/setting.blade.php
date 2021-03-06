@extends('layouts.master')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/club.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
@section('head')
    
@endsection

@section('content')
    <!-- Header TabList -->
    <div class="club-section club-main">
        <div class="container">
            <div class="page-header page-title text-center">
                <h5><strong>{{ $club->name }}</strong></h5>
                <small>(Chỉnh sửa thông tin, thêm thành viên và thống kê thành tích)</small>
            </div>
            <div class="col-md-3">
                <div id="tablist-setting">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"><a href="{{ route('club.profile', $club->slug)}}">Thông tin chung<span class="glyphicon glyphicon-chevron-right"></span></a></li>
                        <li role="presentation" class="active"><a href="{{ route('club.setting', $club->slug)}}">Chỉnh sửa thông tin đội<span class="glyphicon glyphicon-chevron-right"></a></li>
                            <li role="presentation"><a href="{{ route('club.member', $club->slug)}}">Thành viên<small>({{ isset($club->number_player)?$club->number_player:0 }})</small><span class="glyphicon glyphicon-chevron-right"></a></li>
                        {{-- <li role="presentation"><a href="{{ route('club.statistic', $club->slug)}}">Thống kê<span class="glyphicon glyphicon-chevron-right"></a></li> --}}
                    </ul>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="panel panel-success">
                    <div class="page-header text-center">
                        <h6><strong>Chỉnh sửa thông tin đội</strong></h6>
                    </div>
                    <div class="panel-body">
                        <!-- Logo đội bóng -->
                        <div class="col-md-4">
                            <div class="text-center">
                                <label>Logo đội bóng:</label></label><br>
                                <small>(logo nên có kích thước 1x1)</small>
                            </div>
                            <div class="logo-club">
                                <div id="preview-crop-logo">
                                    @if (isset($club->logo))
                                        <img src="{{ asset('/storage/club-logos').'/'.$club->logo }}" alt="">
                                    @else
                                        <img src="{{ asset('/storage/club-logos/logo_default.jpg') }}">
                                    @endif
                                </div>
                                <button type="button" class="btn btn-submit set-logo" data-toggle="modal" data-target="#logoModal">
                                    Thay ảnh
                                </button>
                                @if ($errors->has('logo'))
                                    <p class="error-danger">{{ $errors->first('logo') }}</p>
                                @endif
                            </div>
                        </div>
                        <!-- Thông tin đội bóng -->
                        <form action="{{ route('club.update', $club->slug) }}" method="post" id="form-create">
                            {{ csrf_field() }}
                            @if (Route::has('login'))
                                <input type="hidden" name="owner_id" value="{{ Auth::user()->id }}">
                            @endif
                            <input type="hidden" value="{{ $club->gender }}" id="input-gender">
                            <input type="hidden" value="{{ $club->ages }}" id="input-ages">
                            <input type="hidden" value="{{ $club->club_type }}" id="input-club-type">
                            <!-- Thông tin cơ bản -->
                            <div class="col-md-8" id="basic-info">
                                <div class="form-group">
                                    <label>Tên đội bóng:</label>
                                    <input class="form-control" type="text" name="name" value="{{ $club->name }}">
                                    @if ($errors->has('name'))
                                        <p class="error-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Giới tính:</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="0">Nữ</option>
                                        <option value="1">Nam</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Độ tuổi:</label>
                                    <select class="form-control" id="ages" name="ages">
                                        <option value="1"> < 15 </option>
                                        <option value="2">15-20</option>
                                        <option value="3">20-25</option>
                                        <option value="4">25-30</option>
                                        <option value="5"> > 30</option>
                                        <option value="6"> Nhiều độ tuổi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Trình độ:</label>
                                    <select class="form-control" id="club_type" name="club_type">
                                        <option value="1">Chuyên nghiệp</option>
                                        <option value="2">Bán chuyên nghiệp</option>
                                        <option value="3">Phủi</option>
                                        <option value="4">Vui</option>
                                        <option value="5">Khác</option>
                                    </select>
                                </div>
                                <div id="upload-logo">
                                </div>
                                <div id="upload-uniform">
                                </div>
                            </div>
                            <hr>
                            <!-- Đồng phục -->
                            <div class="col-md-4" id="club-uniform">
                                <div class="text-center">
                                    <label>Đồng phục:</label>
                                </div>
                                <div>
                                    <div id="preview-crop-uniform">
                                        @if (isset($club->uniform))
                                            <img src="{{ asset('/storage/club-uniforms').'/'.$club->uniform }}" alt="">
                                        @else
                                            <img src="{{ asset('/storage/club-uniforms/uniform_default.png') }}">
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-submit set-uniform" data-toggle="modal" data-target="#uniformModal">
                                        Thêm ảnh
                                    </button>
                                </div>
                            </div>
                            <!-- Thông tin liên hệ-->
                            <div class="col-md-8" id="contact">
                                <div class="form-group">
                                    <label>Số điện thoại:</label>
                                    <input class="form-control" type="string" name="phone" value="{{ $club->phone }}">
                                    @if ($errors->has('phone'))
                                        <p class="error-danger">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input class="form-control" type="text" name="email" value="{{ $club->email }}">
                                    @if ($errors->has('email'))
                                        <p class="error-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <!-- Giới thiệu -->
                            <div class="col-md-12" id="introduce">
                                <div class="form-group">
                                    <label for="">Giới thiệu đội bóng: </label>
                                    <textarea name="description" id="description" cols="30" rows="10">{{ $club->description }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Button  -->
                            <div class="col-md-12">
                                <button id="club-create" type="submit" class="btn btn-primary submit-create">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Logo Upload Modal-->
            <div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content update-banner">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h6 class="modal-title" id="myModalLabel">Đặt lại Logo</h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class=" text-center">
                                    <div id="logo-demo"></div>
                                </div>
                                <div>
                                    <strong class="text-center text-select">Select image to crop:</strong>
                                    <input type="file" id="logo">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-primary btn-block upload-logo">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Uniform Upload Modal -->
            <div class="modal fade" id="uniformModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content update-banner">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h6 class="modal-title" id="myModalLabel">Đặt lại Đồng phục</h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class=" text-center">
                                    <div id="uniform-demo"></div>
                                </div>
                                <div>
                                    <strong class="text-center text-select">Select image to crop:</strong>
                                    <input type="file" id="uniform">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-primary btn-block upload-uniform">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('bower_components/Croppie/croppie.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script src={{ url('bower_components/ckeditor/ckeditor.js') }}></script>
    <!-- CKFinder và CKEditor -->
    <script>
        CKEDITOR.replace( 'description', {
            filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',

        } );
    </script>
    @include('ckfinder::setup')

    <!-- Upload images -->
    <script type="text/javascript">
        $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });
       /* Show Modal Update Logo*/
       $(document).on('click', '.set-logo', function(){
           $('#logoModal').modal('show');
       });
       $(document).on('click', '.set-uniform', function(){
           $('#uniformModal').modal('show');
       });

       /*Upload logo*/
           // Resize Image
           var resize_logo = $('#logo-demo').croppie({
               enableExif: true,
               enableOrientation: true,    
               viewport: { // Default { width: 100, height: 100, type: 'square' } 
                   width: 400,
                   height: 400,
                   type: 'square' //square
               },
               boundary: {
                   width: 450,
                   height: 450
               }
           });
           // Upload logo cut
           $('#logo').on('change', function () { 
           var reader_logo = new FileReader();
               reader_logo.onload = function (e) {
               resize_logo.croppie('bind',{
                   url: e.target.result
               }).then(function(){
                   console.log('Logo bind complete');
               });
               }
               reader_logo.readAsDataURL(this.files[0]);
           });
           // Demo image
           $('.upload-logo').on('click', function () {
               resize_logo.croppie('result', {
                   type: 'canvas',
                   size: 'viewport'
               }).then(function (img1) {
                   $.ajax({
                       url: '{!! route("club.crop-logo") !!}',
                       dataType : 'json',
                       type: 'post',
                       data: {
                           'logo':img1,
                       },
                       success: function (data1) {
                           var logo_name = data1.logo_name;
                           // console.log(logo_name);
                           $('#logoModal').modal('hide');

                           html1 = '<img src="' + img1 + '" />';
                           logo = '<input name="logo" value ="' + logo_name + '" hidden>';
                           $("#upload-logo").html(logo);
                           $("#preview-crop-logo").html(html1);
                       }
                   });
               });
           });
       /*End Upload logo*/
       /*----------------------------------------------------------*/ 
       /*Upload Uniform*/
           // Resize Image
           var resize_uniform = $('#uniform-demo').croppie({
               enableExif: true,
               enableOrientation: true,    
               viewport: { // Default { width: 100, height: 100, type: 'square' } 
                   width: 335,
                   height: 200,
                   type: 'square' //square
               },
               boundary: {
                   width: 435,
                   height: 300
               }
           });
           // Upload image cut
           $('#uniform').on('change', function () { 
           var reader_uniform = new FileReader();
               reader_uniform.onload = function (e) {
               resize_uniform.croppie('bind',{
                   url: e.target.result
               }).then(function(){
                   console.log('jQuery bind complete');
               });
               }
               reader_uniform.readAsDataURL(this.files[0]);
           });
           // Demo image
           $('.upload-uniform').on('click', function (ev) {
               resize_uniform.croppie('result', {
                   type: 'canvas',
                   size: 'viewport'
               }).then(function (img2) {
                   $.ajax({
                       url: '{!! route("club.crop-uniform") !!}',
                       dataType : 'json',
                       type: 'post',
                       data: {
                           'uniform':img2,
                       },
                       success: function (data2) {
                           var uniform_name = data2.uniform_name;
                           // console.log(image_name);
                           $('#uniformModal').modal('hide');

                           html2 = '<img src="' + img2 + '" />';
                           uniform = '<input name="uniform" value ="' + uniform_name + '" hidden>';
                           $("#upload-uniform").html(uniform);
                           $("#preview-crop-uniform").html(html2);
                       }
                   });
               });
           });
       /*End Upload logo*/
    </script>

    <!-- Selected option -->
    <script type="text/javascript">
        var gender = $('#input-gender').val();
        var ages = $('#input-ages').val();
        var club_type = $('#input-club-type').val();

        $("select#gender").val(gender);
        $("select#ages").val(ages);
        $("select#club_type").val(club_type);
    </script>
     <!-- Notification with Toastr -->
    <script>
        toastr.options.positionClass = 'toast-bottom-right';
        @if(Session::has('update_club'))
            toastr.success("{{ Session::get('update_club') }}");
        @endif
        @if(Session::has('name_false'))
            toastr.error("{{ Session::get('name_false') }}");
        @endif    
    </script>
@endsection