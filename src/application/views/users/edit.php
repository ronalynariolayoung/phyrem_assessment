<div class="container">

  <div class="row">  
    <div class="col-sm-12">
        <h2>Edit Employee Details</h2>
    </div> 
  </div> 
  <div class="row">  
    <div class="col-sm-12">
        <h6><?php  
        $save_result = $this->session->flashdata('save_result');
        echo '<label class="text-success">'.$this->session->flashdata('message').'</label>';
        ?></h6>
    </div> 
  </div>

  
  <form method="post" action="/home/edit_save">
    <div class="row">  
        <div class="col-sm-12">
                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>">
                <input type="hidden" name="employee_id" value="<?= $user->employee_id; ?>">
                
            <div class="mb-3">
                <label class="form-label">Select User Type</label>
                <select class="form-control" id="user_type" name="user_type">  
                    <option value="<?= $user->user_type; ?>"><?= ($user->user_type == 1) ? 'Super Admin' : 'Admin'; ?> </option> 
                    <option value="1">super admin</option>
                    <option value="2">admin</option> 
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">First Name</label> 
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user->first_name; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label> 
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user->last_name; ?>">
            </div>
            <div class="mb-3" id="username_div">
                <label class="form-label">Username</label> 
                <input type="text" class="form-control" id="username" name="user_name" value="<?= $user->user_name; ?>">
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" minlength="10" placeholder="***********">
                <div class="form-text" id="generated_password"></div>
                <a class="btn btn-sm btn-success" id="generate_password">Generate Password</a>
            </div> 

    
        </div>
    </div>
    

    <div class="row">   
        <div class="col-sm-12" style="display: flex; justify-content: flex-end" >
            <button type="submit" class="btn btn-primary" id="submitBtn"> Submit</button>
        </div> 
    </div>

    <div class="mb-3">
        <div class="form-text" id="generated_qr"></div>  
    </div> 
     
  
</form>


</div> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script> 

$(document).ready(function() {
    var username = $('#username').val();
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var password = $('#password').val();
        
    //initialize QR code
    if ((username.length > 0) && (first_name.length > 0) && (last_name.length > 0) ){ 
        $( ".genqr" ).remove();  
        hashUsername(username,first_name,last_name); 
    }else{ 
        $('#generated_qr').append('<div class="genqr" ><label  class="form-label text-danger">Cannot Generate QR. Please complete the form.</label></div>');
    }


    //this function will allow users to generate password multiple times
    $( "#generate_password" ).click(function() { 
        $( "#genpass" ).remove(); 
        $.ajax({
        url: '/home/generatePassword',
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
        var username = $('#username').val();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
            if ((username.length > 0) && (first_name.length > 0) && (last_name.length > 0) ){ 
            $('#submitBtn').prop('disabled', false); 
                hashUsername(username,first_name,last_name);
                
            }else{  
            $('#submitBtn').prop('disabled', true);
                $( ".genqr" ).remove(); 
            }
    });


    //this function will hash username value
    function hashUsername(username,first_name,last_name){
        $( ".genqr" ).remove(); 
        $.ajax({
            url: '/home/hash_username/'+username+'/encode',
            type: 'get',
            success: function(response){ 
                var src_value ='/home/time_record_save/'+response; 
                var title_value = first_name+last_name+'\'s Profile';
                $('#generated_qr').append('<div class="genqr" ><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='+src_value+'&choe=UTF-8" title="'+title_value+'" /></div>');
                    
            }
        }); 
    }
 
          
}); 
</script>
