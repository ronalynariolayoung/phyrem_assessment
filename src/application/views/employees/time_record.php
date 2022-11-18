<div class="container">

<div class="row">  
    <div class="col-sm-12">
        <h2>Employees Time Record Module</h2>
    </div> 
  </div>
  
  <div class="row">  
    <div class="col-sm-12">
        <h6 id="serverMessage"></h6>
    </div> 
  </div>

  
   
  <div class="row">  
    <div class="col-sm-12">
             
            <div class="mb-3">
                <label class="form-label">Input your Employee ID or Username</label> 
                <input type="text" class="form-control" id="employee_data" name="employee_data"  required>
            </div> 
    </div>
</div>
 

<div class="row">   
    <div class="col-sm-12" style="display: flex; justify-content: flex-end" >
        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
    </div> 
</div>
      
  <?php
if ($loggedInUser['user_type'] == 1)
{
    echo '
    <div class="row">   
        <div class="col-sm-12" style="display: flex; justify-content: " >
            <a href="/home" type="submit" class="btn btn-success">Back to Home</a>
        </div> 
    </div>';
}
?>

<div class="row">   
    <div class="col-sm-12" style="display: flex; justify-content: " >
        <a href="/login/logout" type="submit" class="btn btn-danger">Logout</a>
    </div> 
</div>
 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script> 
$(document).ready(function() {
    
     
    $( "#submitBtn" ).click(function() { 
        
        $('.responseLabel').remove();
        var employee_data = $('#employee_data').val();
        if(employee_data.length>0){
            //this ajax will process time in and time out 
            $.ajax({
                url: '/home/time_record_save/'+employee_data+'/0',
                type: 'get',
                success: function(response){
                    // console.log(response)
                    $('#serverMessage').append('<label class="text-primary responseLabel">'+response+'</label>');
                },
                error: function () {
                    
                    $('#serverMessage').append('<label class="text-danger responseLabel">User does not exist!</label>');
                }
            }); 
        } 
    }); 

          


          
}); 
</script>
