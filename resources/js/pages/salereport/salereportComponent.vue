<template>
  <div class="content-wrapper">
    <content-header
    nameContent="Reporte Ventas"
    nameMain = "Home"
    nameAct = "SaleReport"
    ></content-header>

    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                         <!-- Date and time range -->
                       
                            <div class="form-group form-group-inline ">
                                <button type="button" class="btn btn-default float-left btn-sm" id="daterangepe">
                                    <span></span>
                                    <i class="fas fa-caret-down"></i>
                                </button>
                                <button type="button" @click="descargareport()" class="btn btn-success  float-right btn-sm" id="descargarreport">
                                    <span>Descargar Reporte en Excel</span> 
                                </button>
                            </div> 
                     
                         <!-- /.form group -->
                    </div>
                    <div class="card-body">
                        
                        <div class="card bg-gradient-indigo">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-th mr-1"></i>
                                    Gráfico de Reporte
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-indigo btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-indigo btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                                </div>
                            </div>
                            <div class="card-body charventaspe">
                                <div class="chart" id="line-chart-ventas" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRODUCT - SALES OF TODAY -->
        <div class="row">
            <product-report ></product-report>
            <sale-of-today></sale-of-today>
            <!-- END -->
        </div>
        <client-report></client-report>
    </div>


  </div>
</template>

<script>
 
export default {
    data(){
        return{
           data_gra_report :[],
        }
    },
    mounted(){
        this.date_picker();
        this.getreportDate('','');
        this.date_day();
    },
    methods:{
        getreportDate(fechaIni,fechaFin){
            localStorage.setItem('fechas',`({"fechai":"${fechaIni}","fechaf":"${fechaFin}"})`)
            axios.post('salereport/reportdate',{
                fechaIni:fechaIni,
                fechaFin : fechaFin
            })
            .then(res => { 
                // console.log(res.data)
                morris_line(res.data.data)
            })
        },
        grafico_report(datos){
            var line = new Morris.Line({
                    element          : 'line-chart-ventas',
                    resize           : true, 
                    data             : datos,
                    xkey             : 'awomes',
                    ykeys            : ['sale'],
                    labels           : ['Ventas'],
                    lineColors       : ['#efefef'],
                    lineWidth        : 2,
                    hideHover        : 'auto',
                    gridTextColor    : '#fff',
                    gridStrokeWidth  : 0.4,
                    pointSize        : 4,
                    pointStrokeColors: ['#efefef'],
                    gridLineColor    : '#efefef',
                    gridTextFamily   : 'Open Sans',
                    preUnits         : 'S/. ',
                    gridTextSize     : 12, 
                });

        },
        date_picker(){
           var aa = $('#daterangepe').daterangepicker(
                Datadasepicker,
                 function (start, end) {
                     $("#line-chart-ventas" ).remove();
                    $('#daterangepe span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                    let fechaInicial = start.format('YYYY-MM-DD');
                    let fechaFinal = end.format('YYYY-MM-DD');
                    // let capturarRango2 = $('#daterangepe span').html();
                   localStorage.setItem('fechas',`({"fechai":"${fechaInicial}","fechaf":"${fechaFinal}"})`)
                    $( ".charventaspe" ).append( '<div class="chart" id="line-chart-ventas" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>' )
                    axios.post('salereport/reportdate',{
                        fechaIni:fechaInicial,
                        fechaFin : fechaFinal
                    })                   
                    .then(res => { 
                          morris_line(res.data.data)
                    });
                    
                    
                },
                
                  
            ); 
        },
        date_day(){
            // $(".daterangepicker.opensright .ranges li").on("click", function(){
            //     let d = new Date();
            //     let dia = d.getDate();
            //     let mes = d.getMonth();
            //     let awo = d.getFullYear();
            //     if(mes < 10){
            //         var fechaInicial = awo+"-0"+mes+"-"+dia;
            //         var fechaFinal = awo+"-0"+mes+"-"+dia;
            //     }else if(dia < 10){
            //         var fechaInicial = awo+"-"+mes+"-0"+dia;
            //         var fechaFinal = awo+"-"+mes+"-0"+dia;
            //     }else if(mes < 10 && dia < 10){
            //         var fechaInicial = awo+"-0"+mes+"-0"+dia;
            //         var fechaFinal = awo+"-0"+mes+"-0"+dia;
            //     }else{
            //         var fechaInicial = awo+"-"+mes+"-"+dia;
            //         var fechaFinal = awo+"-"+mes+"-"+dia;
            //     }
            // localStorage.setItem('fechas',`({"fechai":"${fechaInicial}","fechaf":"${fechaFinal}"})`)
                // console.log(fechaInicial,fechaFinal)
                // this.getreportDate((fechaInicial),(fechaFinal));
            
            // })
        },
        descargareport(){

            let fe = eval(localStorage.getItem('fechas'))
            // console.log( typeof(fe.fechai)); return true;
            if(fe.fechai && fe.fechaf){
                let feini = fe.fechai.replace(/-/g,'t');
                let fefin = fe.fechaf.replace(/-/g,'t');
                window.location.href = `salereport/descargareporte/excel/${feini}/${fefin}`;
                return true;
            }else{
                window.location.href = `salereport/descargareporte/excel`;
                return true;
            }
        }
       

    }
}
</script>

<style>

</style>