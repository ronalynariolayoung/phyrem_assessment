<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Phyrem</title>
 
  <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <!-- bootstrap5 dataTables css cdn -->
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css"
    /> 
	<!-- CSS only --> 
  <!-- <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"/> -->
  <!-- <link href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css"/> -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" /> -->
  <!-- <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" /> -->
<!--  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" />
  <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />
  <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css" /> -->
  




	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
  <link href="/assets/css/main.css" rel="stylesheet" />
  





</head>
<body>
<!-- HEADER -->
<?php //$this->load->view('layouts/partials/header.php') ?>
<div class="container-fluid">
  <div class="row">
    <?php //$this->load->view('layouts/partials/sidebar.php') ?>
    <!-- SIDEBAR -->

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <!-- START SPECIFIC PAGE -->
      <?php $this->load->view($primaryView);?>
      <!-- END SPECIFIC PAGE -->
    </main>
  </div>
</div>



<!-- JavaScript Bundle with Popper -->

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script> -->


<!-- <script src="https://cdn.datatables.net/autofill/2.5.1/js/dataTables.autoFill.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="/assets/js/main.js"></script>
<!-- bootstrap5 dataTables js cdn -->
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    
</body>

</html>



<script>
      $(document).ready(function () {
        $('#datatable').DataTable();
      });
    </script> 
