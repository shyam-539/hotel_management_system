@extends('admin.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ url('../assets/admin/css/student_list.css') }}">
<link rel="stylesheet" href="{{ url('../assets/admin/css/room_view.css') }}">
<link rel="stylesheet" href="{{ url('../assets/admin/css/loyality.css') }}">

<!-- Main content -->
    <section class="content">
        <div class="main_div" style="max-width:1564px">
            <div class="sale_list">
                @if (session('success'))
                <div class="alert alert-success" style="color: red; text-align:center;">
                    {{ session('success') }}
                </div>
                @endif
                <form id="addLoyality" action="{{ route('admin.loyality.store') }}" method="post"class="form-inline">
                    @csrf
                    <div class="form-group">
                        <div class="input-box">

                            <label for="programme_name">Programme Name:</label>
                            <input type="text" class="form-control" id="programme_name" name="programme_name" value="{{old('programme_name')}}" required>
                            @error('programme_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-box">
                            <label for="points"> Points:</label>
                            <input type="text" class="form-control" id="points" name="points" value="{{old('points')}}" required>
                            @error('points')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                 
                    <button type="submit" class="btn btn-primary">Add Loyality</button>
                </form>
                <table class='table table-striped table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Programme Name</th>
                            <th>Points</th>
              
                            <th colspan=2>Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loyalities as $key => $loyality)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $loyality->programme_name }}</td>
                            <td>{{ $loyality->points }}</td>
                            
                            <td> 
                                <a href="{{ route('admin.loyality.edit', ['id' => $loyality->id]) }}" class="edit_btn btn-sm">Edit</a>
                            </td>
                            <td>
                                <form action="{{route('admin.loyality.delete', $loyality->id)}}" method="POST" class="delete-form" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="del_btn">Delete</button>
                                </form> 
                            </td>     
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </section>


    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault(); 
                
                var form = $(this);
                var borrowURL = form.attr('action');
                var rowElement = form.closest('tr');
    
                if (confirm("Are you sure you want to delete this Record?")) {
                    $.ajax({
                        url: borrowURL,
                        type: 'DELETE',
                        dataType: 'json',
                        data: form.serialize(), 
                        success: function(data) {
                            alert(data.success); 
                            rowElement.remove(); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); 
                        }
                    });
                } 
            });
        });

    </script>
   
@endsection
