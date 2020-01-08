<?php require_once LAYOUTS.'header.php' ?>
<?php require_once LAYOUTS.'main_header.php' ?>
<?php require_once LAYOUTS.'menu.php' ?>

<?php
 



?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Inicio 
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="content-fluid">
            <div class="row">
                <!-- small box -->
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3  style="font-size:22px;"><?php echo( $data->users[0]['count_users'])  ?></h3>
                            <p>Usuarios</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="users" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- small box -->
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3  style="font-size:22px;"><?php echo( $data->produts[0]['count_products'])  ?></h3>
                        <p>Productos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="products" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- small box -->
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3  style="font-size:22px;"><?php echo( $data->cursomers[0]['count_customers'])  ?></h3>
                        <p>Clientes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                    <a href="customers" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- small box -->
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-orange">
                    <div class="inner">
                        <h3 style="font-size:22px;"><?php echo "S/. " . number_format($data->tfactura['total'],2,'.',',')   ?></h3>
                        <p>Facturas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="saleall" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- small box -->
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-pink">
                    <div class="inner">
                        <h3  style="font-size:22px;"><?php echo "S/. " . number_format($data->tboleta['total'],2,'.',',')   ?></h3>
                        <p>Boletas </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="saleall" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- small box -->
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-danger">
                    <div class="inner">
                        <?php //dd($data) ?>
                        <h3  style="font-size:22px;"><?php echo "S/. " . number_format($data->totalpe['total'],2,'.',',')   ?></h3>
                        <p>Total Anual</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="saleall" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>



            </div>

            <!-- REPORT - PRODUCTS -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Reporte de Productos</h4>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center">
                                    <strong> Total de Ventas por Mes en el <?php echo date('Y') ?></strong>
                                    </p>
                                    <div class="chart"> 
                                        <canvas id="salesChart" height="180" style="height: 280px;"></canvas>
                                    </div>
                                </div>

                                <!-- <div class="card-md-4">
                                    <p class="text-center">
                                        <strong>Productos</strong>
                                    </p>
                                    <div class="chart" > 
                                        <canvas id="pieChart" width="auto" height="250px"  ></canvas>
                                    </div>

                                </div> -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
       <?php
             
          
       ?> 
    </section>
</div>


<?php require_once LAYOUTS.'footer.php' ?>