<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-RE3t+uPxbvY3AI2zIh+WLgJGjdFfzskZGv1EfeN/zOZ2RCwo/6JgVWAz4FzDOdiYMXqah7kp5PU+Trp6fdk3OQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>

<style>

</style>

<div class="w3-bar w3-white w3-large">
    <img class="logo_img w3-bar-item w3-button w3-mobile" src="{{url('../storage/images/logo11.png')}}" alt="hotel logo">
    <a href="{{route('user.index')}}" class="w3-bar-item w3-button w3-mobile">Home</a>
    <a href="{{route('user.booking.show')}}" class="w3-bar-item w3-button w3-mobile">Bookings</a>
    <a  class="w3-bar-item w3-button w3-mobile dropdownn">
      <ul class="notification-drop">
          <li class="item">
              <i class="fa fa-bell-o notification-bell" aria-hidden="true"></i> <span class="btn__badge pulse-button">{{$notificationCount}}</span>
              <ul class="notification-content">
                <div class="notification-container">
                    @foreach($notifications as $notification)
                    <li class="notification-box" data-notification-id="{{ $notification->id }}" data-booking-id="{{ $notification->booking_id }}">
                        <p>{{ $notification->message }}</p>
                        <p>
                          <span style="color: {{ $notification->status == 1 ? 'red' : 'green' }}">
                              {{ $notification->status == 1 ? 'Unseen' : 'Seen' }}
                          </span>
                          - {{ $notification->created_at }}
                        </p>
                      </li>
                    @endforeach
                </div>
              </ul>
          </li>
      </ul>
  </a>
    
  
      <div class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile" style=" margin-right: 22px;">

          <div class="relative" style=" margin-right: 22px;">
            @if(Auth::check())
              <a class="dropbtn">  {{ Auth::user()->first_name }}  {{ Auth::user()->last_name }}  <i class="fas fa-caret-down"></i> </a>
              <div class="dropdown">
                <a href="{{route('user.profile.edit')}}">Profile</a>

                <a>
                  <form method="POST" action="{{ route('user.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                  </form>
                </a>
              </div>
              @endif 
            </div>
            
       </div>
  </div>

  <script>
    $(document).ready(function() {
        $('.notification-box').click(function() {
            var notificationId = $(this).data('notification-id');
            var editUrl = "{{ route('user.notification.edit', ':id') }}";
            editUrl = editUrl.replace(':id', notificationId);
            window.location.href = editUrl;
        });
    });
</script>

