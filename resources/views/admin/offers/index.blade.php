@extends('admin.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ url('../assets/admin/css/student_list.css') }}">
<link rel="stylesheet" href="{{ url('../assets/admin/css/room_view.css') }}">

<!-- Main content -->
    <section class="content">
        <div class="main_div" style="max-width:1564px">
            <div class="sale_list">
                <button class="add_btn" > <a href="{{route('admin.offers.create')}}" style=" color: #fff;"> + New Entry</a></button><br>
                @if (session('success'))
                <div class="alert alert-success" style="color: red; text-align:center;">
                    {{ session('success') }}
                </div>
                @endif
            
                <table class='table table-striped table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Offer Name</th>
                            <th>Disccount %</th>
                            <th>Start date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th colspan=2>Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offers as $key => $offer)
                        <tr>
                            <td>{{ $loop->iteration + $offers->firstItem() - 1 }}</td>
                            <td>{{ $offer->offer_name }}</td>
                            <td>{{ $offer->discount_percentage }}</td>
                            <td>{{ $offer->start_date }}</td>
                            <td>{{ $offer->end_date }}</td>
                            <td>
                                {{-- Check if the offer status is not closed --}}
                                @if ($offer->status == 0)
                                    Closed
                                @else
                                    <form action="{{ route('admin.offers.update.status', ['id' => $offer->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-block btn-info btn-sm">Close Offer</button>
                                    </form>
                                @endif
                            </td>
                            
                            <td> 
                                <a href="{{ route('admin.offers.edit', ['id' => $offer->id]) }}" class="edit_btn btn-sm">Edit</a>
                            </td>
                            <td>
                                <form action="{{route('admin.offers.delete', $offer->id)}}" method="POST" class="delete-form" style="display: inline;">
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
