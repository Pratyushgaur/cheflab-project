<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Form</title>
  <style>
    html,body {
  height: 100%;
}
body {
  margin: 0;
}
.container {
  background: url({{URL::TO('loginback.jpg')}});
  background-repeat: no-repeat;
  background-size: cover;
  font-family: Arial,Helvetica,sans-serif;
  height: inherit;
  display: flex;
  justify-content: center;
  align-items: center;
  
}
.form{
  margin: 0;
  position: relative;
  background: rgba(0,0,0,.7);
  padding: 60px 10px 20px 10px;
  color: #fff;
  display: flex;
  flex-direction: column;
  width: 300px;
}
.avatar {
  position: absolute;
  background: #FFF;
  border-radius: 50%;
  top:-10%;
  left: 40%;
  z-index: 4;
}
.avatar img {
  width: 64px;
  height: 64px;
}

.form-item {
  padding: 15px 10px 10px 10px;
  flex:1;
  display: flex;
  flex-direction: column;
  letter-spacing: 0.5px;
}

.form-item label {
  display: block;
  flex:1;
  margin-bottom: 5px;
  cursor: pointer;
}

.form-item input {
  padding: 4px 11px;
  flex:1;
  background: transparent;
  border-top: none;
  outline: none;
  border-left: none;
  border-right: none;
  caret-color: #fff;
  color:#fff;
  transition: all 200ms;
  border-bottom-color: #fff;
}

.form-item input:focus{
  border-bottom-color: coral;
}

::placeholder,
::ms-input-placeholder,
:ms-input-placeholder{
  color:#ccc;
  font-size:12px;
}

.form-item button {
  flex:1;
  display: block;
  padding: 10px;
  font-weight: bold;
  font-size: 1em;
  color:#fff;
  letter-spacing: .5px;
  border-radius: 30px;
  background-color: #ff3838;
  border: none;
  outline:none;
  transition: all 200ms;
}
.form-item button:hover {
  cursor:pointer;
  background: rgba(255, 56, 56,.7);
}
.form-item a {
  text-decoration: none;
}

.is-link {
  color: #fff;
  flex:1;
  font-size: 14px;
}

.is-link:hover {
  text-decoration: underline;
}
.swal2-modal{
  background: rgba(0,0,0,.7);
  color:#fff !important;
}
.swal2-confirm{ 
  background-color:#ff3838;

} 


  </style>
</head>
<body>
  <div class="container">
    
    <form  method="POST" action="{{route('app.action.vendor.login')}}" class="form" autocomplete="off">
    @csrf
    
    <div class="avatar">
      <img src="{{URL::TO("")}}/192x192.jpg" alt="avatar">
    </div>
      <h5 style="text-align:center;letter-spacing:3px;padding-top:2px;margin-top: 0px;">Vendor Login</h5>
      <div class="form-item">
        <label for="email">Email</label>
        <input type="text" name="email" class="is-input" placeholder="Email" id="email" autocomplete="off">
      </div>
      <div class="form-item">
        <label for="password">Password</label>
       <input type="password" name="password" class="is-input" placeholder="Password" id="password">
      </div>
      <div class="form-item">
        <button type="submit" class="button is-button">Sign in</button>
      </div>
     <div class="form-item">
       
     </div>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if (\Session::has('error'))
                    
      <script>
        $(document).ready(function(){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{!! \Session::get('error') !!}",
          })
        })
        
      </script>
  @endif
  

</body>
</html>