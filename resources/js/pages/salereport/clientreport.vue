<template>
  <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title text-center">
                        <strong>Compradores</strong>
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
                            <canvas id="pieChartclientreport" width="auto" height="250px"  ></canvas>
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
            namesclient:[],
            totalvent : [],
        }
    },
    mounted(){
        console.log("Component Client Mounted")
        axios.get('salereport/reportclient')
        .then(res => { 
            console.log('CLIENT',res.data)
            for (let i = 0; i < res.data.length; i++) {
                this.namesclient[i] = res.data[i]['clientepe']
                this.totalvent[i] = res.data[i]['total_compras']
            }
            console.log(this.namesclient,this.totalvent)
            this.initclient(this.namesclient,this.totalvent);
        }) 
    },
    methods:{
        initclient(names,cant){
            let pieChartreport = $('#pieChartclientreport').get(0).getContext('2d')
            let pieDatape        = {
                labels: names,
                datasets: [
                    {
                        label: "Ventas",
                        data: cant,
                        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc','#333333','#6f81de','#9966ff','#ffcd56','#bac3c7'],
                        borderWidth:0, 
                    }
                ]
            }
            let pieOptions     = { 
                responsive : true,
                maintainAspectRatio: false, 
                legend: {
                    display: false,
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
            let pieChartcl = new Chart(pieChartreport, {
                type: 'bar', 
                data: pieDatape, 
                options: pieOptions      
            })
        }
    }
}
</script>

<style>

</style>