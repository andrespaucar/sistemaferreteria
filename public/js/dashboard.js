 
 
$(function () {
    

    // var salesChartCanvas = $('#salesChart').get(0).getContext('2d')
    var salesChartCanvas = document.getElementById('salesChart').getContext('2d');
    let gradientFill = salesChartCanvas.createLinearGradient(500, 0, 100, 0);
    let gradientFill2 = salesChartCanvas.createLinearGradient(500, 0, 100, 0);
    let gradientStroke = salesChartCanvas.createLinearGradient(500, 0, 100, 0);
    let gradientStroke2 = salesChartCanvas.createLinearGradient(500, 0, 100, 0);

    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, '#f49080');
    gradientStroke2.addColorStop(0, '#542bc1');
    gradientStroke2.addColorStop(1, '#213ec5');

    gradientFill.addColorStop(0, "rgba(128, 182, 244, 0.7)");
    gradientFill.addColorStop(1, "rgba(244, 144, 128, 0.7)");
    gradientFill2.addColorStop(0, "rgba(84, 43, 193, 0.7)");
    gradientFill2.addColorStop(1, "rgba(33, 62, 197, 0.7)"); 

    async function obternerpeoe(){
      const respe = await axios.get('dashboard/ventasanual');
      const dataventa= await respe.data
      console.log(dataventa)
      saleschartpe(Object.values(dataventa)) 

    }
    obternerpeoe()
    // console.log(datapepea)
    function saleschartpe(datavensanual){
    var dataventasanual = datavensanual;
    var salesChartData = {
      labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Noviembre','Diciembre'],
      datasets: [
        // {
          
        //   label               : 'Total de Ventas',
        //   backgroundColor     : gradientFill,
        //   borderColor         : gradientStroke,
        //   pointRadius          : 3,
        //   fill :  true,
        //   pointColor          : gradientStroke,
        //   pointBorderColor    : gradientStroke,pointBackgroundColor: gradientStroke,pointHoverBackgroundColor: gradientStroke,pointHoverBorderColor: gradientStroke,
        //   pointBorderWidth: 10,
        //   pointHoverRadius: 10,pointHoverBorderWidth: 1,borderWidth: 4, 
        //   data                : [28, 28, 20, 19, 16, 27, 31,15,20,8,11,12]
        // },
        {
          label               : 'Total de Ventas',
          backgroundColor     : gradientFill2,
          borderColor         : gradientStroke2,
          pointRadius          : 3,
          fill :  true,
          pointColor          : gradientStroke2,
          pointBorderColor    : gradientStroke2,pointBackgroundColor: gradientStroke2,pointHoverBackgroundColor: gradientStroke2,pointHoverBorderColor: gradientStroke2,
          pointBorderWidth: 10,
          pointHoverRadius: 10,pointHoverBorderWidth: 1,borderWidth: 4, 
          data                : dataventasanual
        },
      ]
    }
     
    var salesChartOptions = {
      animation: {
        easing: "easeInOutBack"//easeInOutQuad
      },
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
            gridLines: {
              color: 'rgba(200, 200, 200, 0.05)',
              lineWidth: 1
            }
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          },
          ticks:{
            callback: function(value,index,values){
                return "S/. " + value;
            }
          }
        }]
      }
    }
  
    // This will get the first returned node in the jQuery collection.
    var salesChart = new Chart(salesChartCanvas, { 
        type: 'line', 
        data: salesChartData, 
        options: salesChartOptions
      }
    )
      }
    //---------------------------
    //- END MONTHLY SALES CHART -
    //---------------------------

      //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    let pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    let pieData        = {
      labels: ['Chrome','IE','FireFox','Safari','Opera'],
      datasets: [
        {
          data: [20,40,50,80,30],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
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
      // tooltips: true,
      // layout: {
      //   padding: {
      //     left: 10,
      //     right: 10,
      //     top: 10,
      //     bottom: 10, 
      //   }
      // }
    }
    let pieChart = new Chart(pieChartCanvas, {
      // type: 'doughnut',
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })
  //------------------------------------------
  
  });