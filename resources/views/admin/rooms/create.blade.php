@extends('admin.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ url('../assets/admin/css/student_form.css') }}">
  <!-- Main content -->
  <section class="content">
    <div class="main_div" style="max-width:1564px">
        <div class="sale_list">
        <h2>Room Entry</h2>
        @if(session('success'))
            <div class="alert alert-success" style="color: green; text-align:center;">
                {{ session('success') }}
            </div>
        @endif

        <!-- form begin here -->
        <div class="w3-container">
        <form action="{{route('admin.rooms.store')}}" method="POST" id="myform" enctype="multipart/form-data">
            @csrf
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Room Type</span>
                    <select name="lookuproom_id" id="lookuproom_id" class="form-control"  autofocus>
                        <option value="">Select Room Type</option>
                        @foreach($lookupRooms as $lookupRoom)
                            <option value="{{ $lookupRoom->id }}" {{ old('lookuproom_id') == $lookupRoom->id ? 'selected' : '' }}>{{ $lookupRoom->name }}</option>
                        @endforeach
                    </select>
                    @error('lookuproom_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>          
                <div class="input-box">
                    <span class="details">Room Count</span>
                    <input type="number" name="room_count" id="room_count" placeholder="Enter Room count" value="{{ old('room_count') }}"  autofocus>
                    @error('room_count')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
           
                <div class="input-box">
                    <span class="details">Bed</span>
                    <select name="bed_id" id="bed_id" class="form-control"  autofocus>
                        <option value="">Select Bed Type</option>
                        @foreach($beds as $bed)
                            <option value="{{ $bed->id }}">{{ $bed->bed_type }}</option>
                        @endforeach
                    </select>
                    <div id="selected_beds_container">
                        <!-- Selected beds will be dynamically added here -->
                    </div>
                    @error('bed_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
              
                <div class="input-box">
                    <span class="details"> Room Size</span>
                    <input type="text" name="room_size" placeholder="Enter room size" value="{{ ('75 m²/807 ft² ')}}"   autofocus>
                    @error('room_size')create
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>  
                <!-- Facility Section -->
                <div class="facility-section">
                    <span class="details"> Facility</span>
                    <div class="facility-checkboxes">
                        @foreach($lookupFacilities as $facility)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facility_ids[]" id="facility_{{ $facility->id }}" value="{{ $facility->id }}" {{ in_array($facility->id, old('facility_ids', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="facility_{{ $facility->id }}">
                                    {{ $facility->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('facility_ids')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            <div class="user-details">
                <div class="input-box">
                    <span class="details">Description</span>
                    <textarea type="text" name="description" placeholder="Enter description"   >{{ old('description') }}
                    </textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-box">
                    <span class="details">Price</span>
                    <input type="float" name="price" placeholder="Enter price" value="{{ old('price') }}"  autofocus>
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-box">
                    <span class="details">Image</span>
                    <input type="file" name="images[]" id="images" multiple value="{{ old('images') }}"  autofocus>
                    @error('images')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="image-preview" id="imagePreview">
                    <!-- Selected images will be dynamically added here -->
                </div>
            </div>
            <div class="button">
                <input type="submit" name="submit_btn" value="Submit">
            </div>
        </form>
                    
         

        </div>
    </div>
</section>
<script>
      document.addEventListener('DOMContentLoaded', function() {
        var bedDropdown = document.getElementById('bed_id');
        var selectedBedsContainer = document.getElementById('selected_beds_container');

        bedDropdown.addEventListener('change', function() {
            var selectedOption = bedDropdown.options[bedDropdown.selectedIndex];
            var selectedBedId = selectedOption.value; // Get the selected bed ID
            var selectedBedText = selectedOption.textContent;

            var selectedBedItem = document.createElement('div');
            selectedBedItem.textContent = selectedBedText + ', ';
            selectedBedsContainer.appendChild(selectedBedItem);

            bedDropdown.selectedIndex = 0;

            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'selected_bed_ids[]';
            hiddenInput.value = selectedBedId;
            document.getElementById('myform').appendChild(hiddenInput);
        });

        var imagesInput = document.getElementById('images');
        var imagePreview = document.getElementById('imagePreview');

        imagesInput.addEventListener('change', function() {
            imagePreview.innerHTML = ''; // Clear previous preview

            var files = imagesInput.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (file.type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var imgElement = document.createElement('img');
                        imgElement.src = event.target.result;
                        imagePreview.appendChild(imgElement);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    });
</script>

@endsection