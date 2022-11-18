
<div class="container">

<div class="row">  
    <div class="col-sm-12">
        <h2>Add New Employee</h2>
    </div> 
  </div> 

  
  
  <form method="post" action="/home/create_save">
    <div class="row">  
        <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label">Select User Type</label>
                    <select class="form-control" id="user_type" name="user_type" required> 
                        <option value="1">super admin</option>
                        <option value="2">admin</option> 
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">First Name</label> 
                    <input type="text" class="form-control" id="first_name" name="first_name"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label> 
                    <input type="text" class="form-control" id="last_name" name="last_name"  required>
                </div>
                <div class="mb-3" id="username_div">
                    <label class="form-label">Username</label> 
                    <input type="text" class="form-control" id="username" name="user_name"  required>
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="10" required> 
                    <div class="form-text" id="generated_password"></div>
                    <a class="btn btn-sm btn-success" id="generate_password">Generate Password</a>
                </div> 
            </div>
        </div>
 
        <input type="hidden" class="form-control" name="created_by" value="<?= $loggedInUser["id"] ?>">

        <div class="row">   
            <div class="col-sm-12" style="display: flex; justify-content: flex-end" >
                <button type="submit" class="btn btn-primary" id="submitBtn"> Submit</button>
            </div> 
        </div>
     
    </form>
    <div class="mb-3">
        <div class="form-text" id="generated_qr"></div>  
    </div> 
  


</div> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script> 
$(document).ready(function() { 
    var password = $('#password').val();

    //this function will allow users to generate password multiple times
    $( "#generate_password" ).click(function() { 
        $( "#genpass" ).remove(); 

        //this ajax will get a generated password
        $.ajax({
        url: '/home/generate_password',
        type: 'get',
        success: function(response){
            $('#password').val(response);
            $('#generated_password').append('<div id="genpass"><label class="form-label">Generated Password:&emsp;</label>'+response+'</div>');
        }
        }); 
    }); 

    //check if password should contains lowercase, uppercase, number, and special character.
    //check if password has a minimum of 10 characters.
    $("#password").on("keyup change", function(e) {
        $("#genpass").remove();
        var pass = $("#password").val();
        if (pass.length>=10 && (pass.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9!@#$%&*]+$/))) {
            $('#submitBtn').prop('disabled', false);
        }else{
            $('#generated_password').append('<div id="genpass"><label class="text-danger">Your password should contain a minimum of 10 characters and consists of lowercase, uppercase, number, and special character. </label></div>');
            
            $('#submitBtn').prop('disabled', true);
        }
    }); 


    //this function will autogenerate qr code if username, first_name and last_name are not empty
    $("#username, #first_name, #last_name").on("keyup change", function(e) { 
        $( ".genqr" ).remove(); 
        var username = $('#username').val();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
            if ((username.length > 0) && (first_name.length > 0) && (last_name.length > 0) ){ 
            $('#submitBtn').prop('disabled', false); 
                $( ".genqr" ).remove(); 

                //this ajax will hash username value
                $.ajax({
                    url: '/home/hash_username/'+username+'/encode',
                    type: 'get',
                    success: function(response){ 

                        $( ".genqr" ).remove(); 
                        var src_value ='/home/time_record_save/'+response; 
                        var title_value = first_name+last_name+'\'s Profile';
                        
                        $('#generated_qr').append('<div class="genqr" ><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='+src_value+'&choe=UTF-8" title="'+title_value+'" /></div>');
                    
                    }
                }); 
            }else{  
            $('#submitBtn').prop('disabled', true);
                $( ".genqr" ).remove(); 
            }
    });

    //this function will check if username is unique
    $("#username").on("keyup change", function(e) { 
        var username = $('#username').val();
        if (username.length > 0){
            //this ajax will check if username already exist
            $.ajax({
                url: '/home/check_username/'+username,
                type: 'get',
                success: function(response){
                    $('#response-label').remove(); 
                    if(response!=''){
                        $('#submitBtn').prop('disabled', true);
                        $('#username_div').append('<label class="form-label text-danger " id="response-label">'+response+'</label>');
                    
                    }else{
                        $('#submitBtn').prop('disabled', false); 
                    } 
                }
            });   
        }
    });

          


          
}); 
</script>
