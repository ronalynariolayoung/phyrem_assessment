<div class="container">

  <div class="row">  
    <div class="col-sm-12">
        <h2>Login</h2>
    </div> 
  </div> 

  <div class="row">  
    <div class="col-sm-12">
        <h6><?php  
        $save_result = $this->session->flashdata('save_result');
        if($save_result==1){
          echo '<label class="text-success">'.$this->session->flashdata('message').'</label>';
        }else{
          echo '<label class="text-danger">'.$this->session->flashdata('message').'</label>';
        }
        ?></h6>
    </div> 
  </div>
  
  
  <form method="post" action="/login/process_login">
    <div class="row">  
      <div class="col-sm-12"> 
          <div class="mb-3">
              <label class="form-label">Username</label> 
              <input type="text" class="form-control" id="username" name="user_name"  >
          </div>
          <div class="mb-3">
              <label for="Password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" minlength="10"> 
          </div>  
      </div>
  </div>

  

  <div class="row">   
      <div class="col-sm-12" style="display: flex; justify-content: flex-end" >
          <button type="submit" class="btn btn-primary">Login</button>
      </div> 
    </div>
</form>
     
  


</div> 

<script>

</script>