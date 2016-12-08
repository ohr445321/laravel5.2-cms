<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理|盛世创富</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/static/admin/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/skins/skin-green.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/skins/skin-green-light.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('/static/admin/css/skins/_all-skins.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/static/admin/css/jquery.tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/plugins/uploadify/uploadify.css') }}">
    @yield('css')
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
@include('layouts.header')
@include('layouts.left')
    <div class="content-wrapper">
        <section class="content">
            @yield('body')
        </section>
    </div>
@include('layouts.footer')
    <script src="{{ asset('/static/admin/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('/static/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/static/admin/js/app.min.js') }}"></script>
    <script src="{{ asset('/static/admin/plugins/uploadify/jquery.uploadify.min.js') }}"></script>
    <script src="{{ asset('/static/admin/plugins/layer/layer.js') }}"></script>
    <script src="{{ asset('/static/admin/plugins/laydate/laydate.js') }}"></script>
    <script type="text/javascript">
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        laydate.skin('molv');

        function jsonAjax(url,type,param,dataType,callback){
            $.ajax({
                url: url,
                type: type,
                dataType: dataType,
                data: param,
                async:false,
                success: callback,
            });
        }
        $(function () {
            $('#submit').click(function () {
                var url = $('#form').attr('action');
                var location_href = $('#form').attr('location_href');
                $.ajax({
                    type: "POST",
                    url:url,
                    data:$('#form').serialize(),
                    async: false,
                    datatype:'json',
                    success:function (return_data) {
                        if (return_data.code == 0) {
                            layer.msg(return_data.msg, {icon: 1,time: 1500},function(){
                                window.location.href = location_href;
                            });
                        }else{
                            layer.msg(return_data.msg, {icon: 5,time: 1500});
                        }
                    }

                });
            });


            $('.article').click(function () {
                var type = $(this).attr('article-type');
                var url = $('#form_'+type).attr('action');
                var data = $('#form_'+type).serialize();
                $.ajax({
                    type: "POST",
                    url:url,
                    data:data,
                    async: false,
                    datatype:'json',
                    success:function (return_data) {
                        if (return_data.code == 0) {
                            layer.msg(return_data.msg, {icon: 1,time: 1500},function(){
                                window.location.href = '{{ url('/admin/article/article-list') }}';
                            });
                        }else{
                            layer.msg(return_data.msg, {icon: 5,time: 1500});
                        }
                    }

                });
            });


            $('.change_status').click(function(event) {
                var thisObj = $(this);
                var data = thisObj.data();
                //询问框
                layer.confirm(data.text, {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    jsonAjax(data.url,'GET',null,'json',function(retrunData){
                        if (retrunData.code == 0) {
                            layer.msg(retrunData.msg, {icon: 1,time: 1000},function(){
                                window.location.reload();  //刷新
                            });
                        }else{
                            layer.msg(retrunData.msg, {icon: 5,time: 1000});
                        }
                    });

                });
            });
        })
    </script>
    @yield('js')
</div>
</body>