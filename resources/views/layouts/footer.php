
 

<?php if(CONTROLLER !== 'home'): ?>
 <!--  Si estamos en el login esto no se mostrará -->
  <footer class="main-footer">
      <strong>Copyright © 2019 <a href="#">AndresPe</a></strong>
      All rights reserved.

      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
      </div>
  </footer>
  <?php endif; ?>

   <!-- Control Sidebar -->
   <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  </div>
  <!-- jQuery -->
  <script src="<?php echo PUBLIC_C ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo PUBLIC_C ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo PUBLIC_C ?>plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?php echo PUBLIC_C ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <!-- DataTables - Responsive  -->
  <script src="<?php echo PUBLIC_C ?>plugins/datatables/dataTables.responsive.min.js"></script>
  <!-- <script src="<?php //echo PUBLIC_C ?>plugins/datatables/responsive.bootstrap4.min.js"></script> -->
  <!-- Select2 -->
  <script src="<?php echo PUBLIC_C ?>plugins/select2/js/select2.full.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo PUBLIC_C ?>dist/js/adminlte.min.js"></script>
   <!-- pace-progress -->
  <script src="<?php echo PUBLIC_C ?>plugins/pace-progress/pace.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?php echo PUBLIC_C ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?php echo PUBLIC_C ?>plugins/toastr/toastr.min.js"></script>
  <!-- ChartJS -->
  
  <?php if(CONTROLLER == 'dashboard'): ?>
    <script src="<?php echo PUBLIC_C ?>plugins/chart.js/Chart.min.js"></script>
    <script src="<?php echo JS ?>dashboard.js"></script>
  <?php endif; ?>

  <?php if(CONTROLLER == 'sale'): ?> 
    <script src="<?php echo JS ?>numero_letra.js"></script>
  <?php endif; ?>
  
  
  <?php if(CONTROLLER == 'salereport'): ?>
    <script src="<?php echo PUBLIC_C ?>plugins/chart.js/Chart.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo PUBLIC_C ?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo PUBLIC_C ?>plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?php echo PUBLIC_C ?>plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo PUBLIC_C ?>plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo PUBLIC_C ?>plugins/morris/morris.min.js"></script>
     
    <script src="<?php echo JS ?>salereport.js"></script>
  <?php endif; ?>


  
  
  <script src="<?php echo JS; ?>JsBarcode.all.min.js"></script>

  <script src="<?php echo JS; ?>template.js"></script>
  <script src="<?php echo JS; ?>app.js"></script>
  <script>
      
  //   toastr.options = {
  //     "closeButton": true,
  //     // "positionClass": "toast-bottom-right",
  //   }
  //  toastr.error('Usuario o Contraseña Incorrectos')

  // $(document).ready(function(){
   
    



// })
  </script>
</body>
</html>