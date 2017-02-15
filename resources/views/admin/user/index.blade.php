@extends('layouts.body')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">用户列表</h3>
                </div>
                <div class="box-header">
                    <a href="{{ url('/admin/user/create') }}"><button class="btn btn-success btn-flat">+ 添加用户</button></a>
                </div>

                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>操作</th>
                        </tr>

                        @if($user_list)
                            @foreach($user_list as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td>
                                        <a href="{{ url('/admin/user/'.$value->id.'/edit')}}">编辑</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                {!! $user_list->appends(\Illuminate\Support\Facades\Input::get())->render() !!}
            </div>
        </div>
    </div>
@endsection