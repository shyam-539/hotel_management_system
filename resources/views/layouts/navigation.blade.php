<div class="w3-bar w3-white w3-large">
    <img class="logo_img w3-bar-item w3-button w3-mobile" src="../storage/images/logo11.png" alt="hotel logo">
    {{-- <a href="#" class="w3-bar-item w3-button  w3-mobile"><img class="logo_img" src="../storage/images/logo2.png" alt="hotel logo"></a> --}}
    <a href="{{route('index')}}" class="w3-bar-item w3-button w3-mobile">Home</a>
    <a href="#about" class="w3-bar-item w3-button w3-mobile">About</a>
    <a href="#contact" class="w3-bar-item w3-button w3-mobile">Contact</a>
      <div class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">
          <div class="relative">
            <a class="dropbtn">Account</a>
            <div class="dropdown">
              <a href="{{ route('user.register') }}" >Register</a>
              <a href="{{ route('admin.login') }}">Admin</a>
            </div>
          </div>
          <a href="{{ route('user.login') }}" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Log in</a>

       </div>
  </div>