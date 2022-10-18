@extends('layouts.app')

@section('content')

<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center text-light">القائمة</div>
                <div class="card-body text-right">
                        <ul class="list-group">
                            <a href="{{route('meal.index')}}" class="list-group-item list-group-item-action">عرض الوجبات</a>
                            <a href="{{route('meal.create')}}" class="list-group-item list-group-item-action">اضافة وجبة</a>
                            <a href="{{route('home')}}" class="list-group-item list-group-item-action">طلبات المستخدمين</a>
                        </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
             <div class="card">
                 <div class="card-header bg-danger text-center text-light">جميع الوجبات</div>
                 <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">صورة الوجبة</th>
                                <th scope="col">اسم الوجبة</th>
                                <th scope="col">الوصف</th>
                                <th scope="col">الصنف</th>
                                <th scope="col">السعر ($)</th>
                                <th scope="col">تعديل</th>
                                <th scope="col">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($meals) > 0)
                                @foreach($meals as $row)
                                    <tr>
                                        <th scope="row">{{ $row->id }}</th>
                                        <td><img src="{{ asset('upload/Meals/' . $row->image) }}" width="80"></td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td>{{ $row->category }}</td>
                                        <td>{{ $row->price }}</td>
                                        <td><a href="{{ route('meal.edit',$row->id) }}"><button class="btn btn-primary">تعديل</button></a></td>
                                        <td><a href=""><button id="delete" class="btn btn-danger">حذف</button></a></td>
                                    </tr>
                                @endforeach
                            @else
                                <p>لا توجد وجبات</p>
                            @endif
                        </tbody>
                    </table>
                    {{ $meals->links(); }}
                 </div>
             </div>   
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>
</div>

@endsection