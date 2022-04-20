
<form method="POST" id="update_profile" action="{{ route('profile.store') }}" enctype="multipart/form-data">
@csrf
<input type="file" name="imgupload" id="imgupload" accept="image/png, image/gif, image/jpeg" style="display:none"/> 
<div class="row mt-3">
    <div class="col-md-3 py-3">
        
        <a href="#" onclick="$('#imgupload').trigger('click'); return false;">
            @if( isset(Auth::user()->profile) && Auth::user()->profile->photo == 1 )
            <img style="height:300;width:300" name="photo" id="photo" class="shadow img-fluid rounded border border-secondary" src="{{ $avatar }}" />
            @else
            <img style="height:300;width:300" name="photo" id="photo" class="shadow img-fluid rounded border border-secondary" src="https://via.placeholder.com/600x600.png/EAEAEA?text=photo" />
            @endif
        </a>
        @error('imgupload')
      
            <strong><span class="text-red">{{ $message }}</span></strong>
   
        @enderror 
    
        
    </div>
    <div class="col-md-9">
        
        <div class="row mt-3 g-2">
            <div class="col-md-6">
                <div class=" px-4"><span class="text-uppercase"><i class="fas fa-user"></i> <strong>Fullname</strong></span> 
                    <input name="name" id="name"  value="{{ $user->name }}" type="text" class="form-control @error('name') is-invalid @enderror"> 
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class=" px-4"> <span class="text-uppercase"><i class="fas fa-envelope"></i> <strong>Email</strong></span> 
                    <input readonly name="email_readonly" id="email"  value="{{ $user->email }}" type="text" class="readonly form-control @error('email') is-invalid @enderror"> 
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                    @enderror 
                </div>
            </div>
        </div>

        <div class="px-4 py-3"> <span class="text-uppercase"><i class="fas fa-address-card"></i> <strong>Address</strong></span>
        
            <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror"  cols="30" rows="5">{{ isset($user->profile->address) ? $user->profile->address : '' }}</textarea>
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror 

        </div>

        <div class="px-4 py-3 col-md-6"> <span class="text-uppercase"><i class="fas fa-phone"></i> <strong>Phone Number</strong></span> 
     
            <input name="phone" id="phone"  value="{{ isset($user->profile->phone) ? $user->profile->phone : '' }}" type="text" class="form-control @error('phone') is-invalid @enderror"> 
            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror  
      
        </div>

        <div class="row mt-3 g-2">
            <div class="col-md-6">
                <div class="inputs px-4"><span class="text-uppercase"><i class="fas fa-lock"></i> <strong>Password</strong></span> 
                    <input name="password" id="password"   type="password" class="form-control @error('password') is-invalid @enderror"> 
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="inputs px-4"><span class="text-uppercase"><i class="fas fa-lock"></i> <strong>Comfirm Password</strong></span> 
                    <input name="password_confirmation" id="password"   type="password" class="form-control @error('password') is-invalid @enderror"> 
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

    </div>
</div>
</form>

<script>
// image display
function previewFile(name,element,width,height){

    var file = $("input[name="+name+"]").get(0).files[0]; // selector

    if(file){
        var reader = new FileReader();
        reader.onload = function(){
            $(element).attr("src", reader.result).height(height).width(width); // previewer
        }
        reader.readAsDataURL(file);
    }
} // preview 

$("#imgupload").change(function() {
    previewFile('imgupload','#photo',300,300);
    //alert('berjaya');
});
</script>