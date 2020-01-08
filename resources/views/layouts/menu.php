<!-- Main Sidebar Container -->
<aside class="main-sidebar  sidebar-light-indigo elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link navbar-indigo ">
      <img src="<?php echo PUBLIC_C?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-1"
           style="opacity: .8">
      <span class="brand-text font-weight-light">FERRETERIA ANYELA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar"> 
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <!-- INICIO -->
            <li class="nav-item">
                <a href="<?php echo URL_L ?>dashboard" class="nav-link <?php echo (CONTROLLER == 'dashboard')? 'active' :'' ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p> Inicio </p>
                </a>
            </li>

            <!-- USUARIOS -->
            <?php if($_SESSION['perfil'] == 'administrador'): ?>
            <li class="nav-item ">
                <a href="<?php echo URL_L ?>users" class="nav-link <?php echo (CONTROLLER == 'users')? 'active' :'' ?>">
                    <i class="nav-icon fas fa-user"></i>
                    <p> Usuarios </p>
                </a>
            </li>
            <?php endif; ?>

            <!-- ALMACEN - INVENTARIO -->
            <?php if($_SESSION['perfil'] == 'alamcen' || $_SESSION['perfil'] == 'administrador'): ?>
            <li class="nav-item has-treeview <?php echo (CONTROLLER == 'products'|| CONTROLLER == 'categories')? 'menu-open' :'' ?> ">
                <a href="#" class="nav-link <?php echo (CONTROLLER == 'products' || CONTROLLER == 'categories')? 'active' :'' ?>">
                    <i class="nav-icon fas fa-warehouse"></i>
                    <p> Almacén <i class="right fas fa-angle-left"></i> </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo URL_L ?>products" class="nav-link <?php echo (CONTROLLER == 'products')? 'active' :'' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Productos</p>
                        </a>  
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo URL_L ?>categories" class="nav-link <?php echo (CONTROLLER == 'categories')? 'active' :'' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categorías</p>
                        </a> 
                    </li>
                </ul>
            </li>
            <?php endif; ?>
             
            <!-- CLIENTES -->
            <li class="nav-item">
                <a href="<?php echo URL_L ?>customers" class="nav-link <?php echo (CONTROLLER == 'customers')? 'active' :'' ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p> Clientes </p>
                </a>
            </li>
            
            <!-- VENTAS -->
            <?php if($_SESSION['perfil'] == 'vendedor' || $_SESSION['perfil'] == 'administrador'): ?>
            <li class="nav-item has-treeview <?php echo (CONTROLLER == 'sale' ||CONTROLLER == 'saleall' ||CONTROLLER == 'salereport')? 'menu-open' :'' ?>">
                <a href="#" class="nav-link <?php echo (CONTROLLER == 'sale' ||CONTROLLER == 'saleall' ||CONTROLLER == 'salereport')? 'active' :'' ?>">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <p> Ventas <i class="right fas fa-angle-left"></i> </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo URL_L ?>sale" class="nav-link <?php echo (CONTROLLER == 'sale' )? 'active' :'' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Crear Venta</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link ">
                            <i class="fas fa-plus nav-icon "></i>
                            <p>Emitir Factura</p>
                        </a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link ">
                            <i class="fas fa-plus nav-icon"></i>
                            <p>Emitir Boleta</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="<?php echo URL_L ?>saleall" class="nav-link <?php echo (CONTROLLER == 'saleall' )? 'active' :'' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Administrar de Ventas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo URL_L ?>salereport" class="nav-link <?php echo (CONTROLLER == 'salereport' )? 'active' :'' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Reporte de Ventas</p>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Simple Link
                    <span class="right badge badge-danger">New</span>
                </p>
                </a>
            </li> -->

            <!-- Configuracion -->
            <?php if($_SESSION['perfil'] == 'administrador' || $_SESSION['perfil'] == 'administrador'): ?>
            <li class="nav-item">
                <a href="<?php echo URL_L ?>settingcompany" class="nav-link <?php echo (CONTROLLER == 'settingcompany')? 'active' :'' ?>">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>Configuracion</p>
                </a>
            </li>
            <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
