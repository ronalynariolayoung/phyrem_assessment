
<div class="container">

<div class="row">
    <div class="col-sm-12">
      <h2>List of Employees </h2>
    </div>
  </div> 
  <div class="row">  
    <div class="col-sm-12">
        <h6 id="flashmessage">
          <?php 
          $save_result = $this->session->flashdata('save_result');
          echo '<label class="form-label text-success">'.$this->session->flashdata('message').'</label>';
          ?>
        </h6>
    </div> 
  </div>
  <div class="row">  
    <div class="col-sm-4"></div>
        <div class="col-sm-2 justify-content-sm-right " id="unSelectedAll">
           <input class=" form-check-input" type="checkbox" name="selectUser" value="1" /> Uncheck Selected
        </div>
        <div class="col-sm-2 justify-content-sm-right " id="deleteSelected">
            <a href="#" id="deleteSelectedbtn" class="btn btn-sm btn-danger">Delete Selected</a>
        </div>
        <div class="col-sm-2 justify-content-sm-right " id="deleteSelectedAll">
           <input class="selectUser form-check-input" type="checkbox" name="selectUser" value="1" /> Select All
        </div>
        <div class="col-sm-2 justify-content-sm-right">
            <a href="/home/users_create" class="btn btn-sm btn-primary">Add new employee</a>
        </div>
  </div>
   
  <div class="row" id="datatableDiv"> 
    <table id="datatable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Username</th>
                <th>User Type</th> 
            </tr>
        </thead>
        <tbody>
            <?php  
              foreach ($users as $value) : 
            ?>
              <tr>
                <td>
                    <div class="btnActions">
                      <!-- NOTE: dapat naka json encode ang username, firstname and last name na pinapasa sa URL -->
                        <a href="/users-edit/<?= $value->user_id ?>"  type="button" class="btn btn-sm btn-secondary">Edit</a>
                        <a href="/users-view/<?= $value->user_id ?>" type="button" class="btn btn-sm btn-primary">View</a>
                        <!-- <button type="button" class="btn btn-sm btn-danger">Delete</button>
                       -->
                       <?php 
                        if($loggedInUser['user_name'] != $value->user_name ){
                          echo '<a href="/home/deleteuser/<?= $value->user_id ?>"  type="button" class="btn btn-sm btn-danger" onclick="return confirm("Are you sure you want to delete this user?");">Delete</a>';
                       
                        }
                       ?>
                        <!-- NOTE: -Remove existing user
                            oUser can remove single or multiple records but cannot remove his account. -->
                    </div>
                    <?php
                    
                    if($loggedInUser['user_name'] != $value->user_name ){
                      echo '<input class="selectUser selected-user form-check-input" data-id="'.$value->user_id.'" type="checkbox" name="selectUser" value="1" />';
                    
                    }
                    ?>
                     
                </td>
                <td><?= $value->first_name.' '.$value->last_name  ?></td>
                <td><?= $value->user_name ?></td>
                <td><?= ($value->user_type == 1) ? 'Super Admin' : 'Admin'; ?>  </td> 
            </tr>
          <?php endforeach; ?>
            
            
    </table>
  </div>
 

 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>





<script> 
$(document).ready(function() {
 

    $(".btnActions").show();
    $("#deleteSelected").hide();
    $("#unSelectedAll").hide();
    

    $("#deleteSelectedAll").click(function () { 
      $(".selectUser").each(function() {
        this.checked=true;
      }); 
    });
    $("#unSelectedAll").click(function () { 
      $(".selectUser").each(function() {
        $(".btnActions").show();
        $("#deleteSelectedAll").show();
        $("#deleteSelected").hide();
        $("#unSelectedAll").hide();
        this.checked=false;
      }); 
    });

    $(".selectUser").click(function() {
      if($(this).is(":checked")) {
        $(".btnActions").hide();
        $("#deleteSelected").show();
        $("#unSelectedAll").show();
        $("#deleteSelectedAll").hide();
        
      } else {  
        if ($('.selectUser:checked').length > 1 ) {
          $("#deleteSelected").show(); 
          $("#unSelectedAll").show();
          $("#deleteSelectedAll").hide();
          $(".btnActions").hide();   
        }else{ 
          $(".btnActions").show();  
          $("#deleteSelected").hide(); 
          $("#unSelectedAll").hide();
          $("#deleteSelectedAll").show();
          $('#deleteSelectedAll').this.checked=false;

        }
        
      }
  
      if ($('.selectUser:checked').length == $('.selectUser').length) {
        $("#deleteSelected").show(); 
        $("#unSelectedAll").show();
        $("#deleteSelectedAll").hide();
      }
      if ($('.selectUser:checked').length == 0 ) {
        $("#deleteSelected").hide(); 
        $("#unSelectedAll").hide();
        $("#deleteSelectedAll").show();
      }
    
    }); 

    $("#deleteSelectedbtn").click(function () { 
      var ids = [];
      $(".selected-user").each(function() {
        if(this.checked){
          ids.push($(this).data("id"));
        }
      }); 
      $.ajax({
        url: '/home/deleteuser',
        type: 'post',
        data: {ids : ids},
        success: function(response){
          
          $('#flashmessage').append('<label class="text-success">Users successfully deleted.</label>');
          $("#datatableDiv").load(location.href + " #datatableDiv");
          
        },
        error: function() {
          alert("some error");
        }
      }); 
    });
});




</script>