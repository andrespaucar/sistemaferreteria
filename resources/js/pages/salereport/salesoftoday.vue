<template>
   <!-- <div class="col-6">
        <div class="card">
            <div class="card-header">
                <p class="card-title text-center">
                    <strong>Total ventas del Día</strong>
                </p>
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
                
                <div class="card-md-4">
                    
                    <div class="chart" > 
                        <canvas id="pieChartsaletoday" width="auto" height="250px"  ></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div> -->
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <p class="card-title text-center">
                    <strong>Total ventas del Día</strong>
                </p>
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
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-info">
                        <div class="inner text-center">
                            <h3 >S/. {{ bday }}</h3>
                            <p>Boletas del Dia</p>
                        </div>
                        <!-- <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div> -->
                        <!-- <div class="small-box-footer">Total emitidos : 5</div> -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-info">
                        <div class="inner text-center">
                            <h3 >S/. {{fday}}</h3>
                            <p>Facturas del Dia</p>
                        </div>
                        <!-- <div class="small-box-footer">Total emitidos : 95</div> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="small-box bg-teal">
                        <div class="inner text-center">
                            <h3 >S/. {{tday}}</h3>
                            <p>Total Ventas</p>
                        </div>
                        <!-- <div class="small-box-footer">Total emitidos : 100</div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            fday :  '',
            bday :  '',
            tday :  '',
        }
    },
    mounted(){
        this.ventasdeldia();
    },
    methods:{
        ventasdeldia(){
            axios.get('salereport/salesoftoday')
            .then(res =>{
                console.log(res.data)
                this.fday = res.data.tfactura;
                this.bday = res.data.tboleta;
                this.tday = res.data.totalpe;

                this.initcharsales('',Object.values([res.data.tboleta,res.data.tfactura]))
            })
        },
        initcharsales(names,cant){
            let pieChartCanvas = $('#pieChartsaletoday').get(0).getContext('2d')
            let pieData        = {
                labels: ['Facturas','Boletas'],
                datasets: [
                    {
                    data: cant,
                    backgroundColor : [ '#00c0ef', '#3c8dbc','#333333'],
                    borderWidth:0
                    }
                ]
            }
            let pieOptions     = {
                responsive : true,
                maintainAspectRatio: false,
                stales:{
                    yAxes:[{
                        ticks:{
                            callback: function(value,index,values){
                                return "S/. " + value;
                            }
                        }
                    }]
                },
                legend: {
                    // display: true,
                    position: 'bottom',
                    labels : {
                    fontColor: 'rgb(154, 154, 154)',
                    fontSize: 11,
                    usePointStyle : true,
                    padding: 20, 
                    }
                },
                pieceLabel: {
                    render: 'percentage',
                    fontColor: 'white',
                    fontSize: 14,
                }, 
            
            }
            let pieChart = new Chart(pieChartCanvas, {
                // type: 'doughnut',
                type: 'pie',
                data: pieData, 
                options: pieOptions      
            })
        }
    }

}
</script>

<style>

</style>