
<div class="container">
  <div class="row">
    <div class="col-sm-10">
      <h2><?= $user->first_name.' '.$user->last_name ?>'s Profile </h2>
    </div>
    <div class="col-sm-2">
      <a href="/users-edit/<?= $user->user_id ?>"  type="button" class="btn btn-md btn-success">Edit</a>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <dl class="row">
        <dt class="col-sm-3">First Name</dt>
        <div class="col-sm-9 "><?= $user->first_name ?><input class="form-control" type="hidden"  id="first_name" value="<?= $user->first_name ?>"></div>
        <dt class="col-sm-3">Last Name</dt>
        <div class="col-sm-9 " ><?= $user->last_name ?><input class="form-control" type="hidden"  id="last_name" value="<?= $user->last_name ?>"></div>
        <dt class="col-sm-3">Username</dt>
        <div class="col-sm-9 "><?= $user->user_name ?><input class="form-control" type="hidden"  id="last_name" value="<?= $user->user_name ?>"></div>
        <dt class="col-sm-3 text-truncate">QR Code: </dt>
 
        
        <div class="mb-3">
            <div class="form-text" id="generated_qr"></div>  
        </div> 
        <!-- <dd class="col-sm-9"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='+src_value+'&choe=UTF-8" title="'+title_value+'" /></dd> -->
        <div class="row">
          <div class="col-sm-12">
            <h4>Employee Time Record </h4>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <table id="datatable" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Date</th>
                  <th scope="col">Time In</th>
                  <th scope="col">Time Out</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $ctr = 1;
                  foreach ($time_records as $value) : 
                ?>
                  <tr>
                    <th scope="row"><?= $ctr; ?></th>
                    <td><?= date('F d, Y', strtotime($value->datetime_added));?></td>  
                    <td><?= ($value->time_in == "00:00:00" ) ? '' : $value->time_in; ?></td>  
                    <td><?= ($value->time_out == "00:00:00" ) ? '' : $value->time_out; ?></td>  
                  </tr> 
                <?php 
                    $ctr++;
                  endforeach; 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </dl>
    </div>
  </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script> 
$(document).ready(function() {
    var username = $("#user_name").val();
    var first_name = $('#first_name').val();
    var last_name = $("#last_name").val();
    
    
    //this will hash username value and show QR code
        $( ".genqr" ).remove(); 
        $.ajax({
            url: '/home/hash_username/'+username+'/encode',
            type: 'get',
            success: function(response){ 
                var src_value ='/home/time_record_save/'+response; 
                var title_value = first_name+last_name+'\'s Profile';
                $('#generated_qr').append('<div class="genqr" ><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='+src_value+'&choe=UTF-8" title="'+title_value+'" /></div>');
                    
            },error:function(){
              console.log('error')
            }
        }); 
  
 
          
}); 
</script>