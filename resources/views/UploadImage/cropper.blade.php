


<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>How to Crop And Upload Image in Laravel 6 using jQuery Ajax</title>
  <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous"></script>
 </head>
 <body>
  <div class="container">    
    <br />
        <h3 align="center">How to Crop And Upload Image in Laravel 6 using jQuery Ajax</h3>
      <br />
      <div class="card">
        <div class="card-header">Crop and Upload Image</div>
        <div class="card-body">
          <div class="form-group">
            @csrf
            <div class="row">
              <div class="col-md-4" style="border-right:1px solid #ddd;">
                <div id="image-preview"></div>
              </div>
              <div class="col-md-4" style="padding:75px; border-right:1px solid #ddd;">
                <p><label>Select Image</label></p>
                <input type="file" name="upload_image" id="upload_image" />
                <br />
                <br />
                <button class="btn btn-success crop_image">Crop & Upload Image</button>
              </div>
              <div class="col-md-4" style="padding:75px;background-color: #333">
                <div id="uploaded_image" align="center"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br />
          <br />
          
          <br />
          <br />
    </div>
 </body>
</html>

<script type="text/javascript">  

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){
  
  $image_crop = $('#image-preview').croppie({
    enableExif:true,
    viewport:{
      width:200,
      height:200,
      type:'circle'
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').change(function(){
    var reader = new FileReader();

    reader.onload = function(event){
      $image_crop.croppie('bind', {
        url:event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type:'canvas',
      size:'viewport'
    }).then(function(response){
      var _token = $('input[name=_token]').val();
      $.ajax({
        url:'{{ route("image_crop.upload") }}',
        type:'POST',
        data:{"image":response, _token:_token},
        dataType:"json",
        success:function(data)
        {
			console.log(data);	
			var crop_image = '<img src="'+data.path+'" />';
			$('#uploaded_image').html(crop_image);
		 
        }
      });
    });
  });
  
});  
</script>