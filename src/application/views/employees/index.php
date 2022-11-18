<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2>Employees Time Record Module</h2>
    </div>
  </div>  
        <div class="row">
          <div class="col-sm-12">
            <table id="datatable" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Employee Name</th>
                  <th scope="col">Date</th>
                  <th scope="col">Time In</th>
                  <th scope="col">Time Out</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $ctr = 1;
                  foreach ($employeeRecords as $value) : 
                ?> 
                  <tr>
                    <th scope="row"><?= $ctr; ?></th>
                    <td><?= $value->first_name.' '.$value->last_name  ?></td>
                    <td><?= $value->datetime_added  ?></td>  
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
<script></script>