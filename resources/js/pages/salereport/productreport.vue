<template>
 
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <p class="card-title text-center">
                    <strong>Productos más Vendidos</strong>
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
                        <canvas id="pieChartreport" width="auto" height="250px"  ></canvas>
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
            namesprod:[],
            cantidadvent:[]
        }
    },
    mounted(){
        console.log('Mounted Product Report Model')
        axios.get('salereport/reportProduct')
        .then(res => { 
            for (let i = 0; i < res.data.length; i++) {
                this.namesprod[i] = res.data[i]['name']
                this.cantidadvent[i] = res.data[i]['c_ventas']
            }
            this.initchar(this.namesprod,this.cantidadvent);
        }) 
        
    },
    methods:{

        initchar(names,cant){
            let pieChartCanvas = $('#pieChartreport').get(0).getContext('2d')
            let pieData        = {
                labels: names,
                datasets: [
                    {
                    data: cant,
                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc','#333333','#6f81de','#9966ff','#ffcd56','#bac3c7'],
                    borderWidth:0
                    }
                ]
            }
            let pieOptions     = {
                responsive : true,
                maintainAspectRatio: false,
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
                type: 'doughnut',
                // type: 'pie',
                data: pieData, 
                options: pieOptions      
            })
        }
        
    }

}
</script>

<style>

</style>