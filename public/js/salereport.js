// MOMENT IN SPANISH
moment.lang('es', {
    months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
    monthsShort: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
    weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
    weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
    weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
}) 
 
const Datadasepicker ={
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Até",
        "customRangeLabel": "Rango Personalizado",
        // "daysOfWeek": [
        //     "Dom",
        //     "Lun",
        //     "Mar",
        //     "Mie",
        //     "Jue",
        //     "Vie",
        //     "Sáb"
        // ],
        // "monthNames": [
        //     "Enero",
        //     "Febrero",
        //     "Marzo",
        //     "Abril",
        //     "Mayo",
        //     "Junio",
        //     "Julio",
        //     "Agosto",
        //     "Septiembre",
        //     "Octubre",
        //     "Noviembre",
        //     "Diciembre"
        // ],
        "firstDay": 0
    },
    ranges   : {
        'Hoy'       : [moment(), moment()],
        'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes' : [moment().startOf('month'), moment().endOf('month')],
        'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    
    startDate: moment().subtract(29, 'days'),
    endDate  : moment(),
    
};
function morris_line(datape){
  let line = new Morris.Line({
  element          : 'line-chart-ventas',
  resize           : true, 
  data             : datape,
  xkey             : 'awomes',
  ykeys            : ['sale'],
  labels           : ['Ventas'],
  lineColors       : ['#efefef'],
  lineWidth        : 2,
  hideHover        : 'tue',
  gridTextColor    : '#fff',
  gridStrokeWidth  : 0.4,
  pointSize        : 4,
  pointStrokeColors: ['#efefef'],
  gridLineColor    : '#efefef',
  gridTextFamily   : 'Open Sans',
  preUnits         : 'S/. ',
  gridTextSize     : 12, 
 
}); 
}

//-------------------------------------------------------------------------
$(function () {
/*=======================================================
DATE RANGE AS BUTTON
/*=======================================================*/
if(localStorage.getItem("capturarRango22") != null){
	// $("#daterangepe span").html(localStorage.getItem("capturarRango2")); 
}else{ 
	$("#daterangepe span").html('<i class="far fa-calendar-alt"></i> Rango de fecha') 
}

 
/*=============================================
CAPTURAR HOY
==============================================*/
$(".daterangepicker.opensright .ranges li").on("click", function(){
    var textoHoy = $(this).attr("data-range-key");

    if(textoHoy == "Hoy"){

      let d = new Date();
      let dia = d.getDate();
      let mes = d.getMonth();
      let awo = d.getFullYear();
      // this.fechaFinal = "GOGOGOGOGO"
      // console.log(fechaFinal)
      if(mes < 10){
      
          var fechaInicial = awo+"-0"+mes+"-"+dia;
          var fechaFinal = awo+"-0"+mes+"-"+dia;
      
        }else if(dia < 10){
      
          var fechaInicial = awo+"-"+mes+"-0"+dia;
          var fechaFinal = awo+"-"+mes+"-0"+dia;
      
        }else if(mes < 10 && dia < 10){
      
          var fechaInicial = awo+"-0"+mes+"-0"+dia;
          var fechaFinal = awo+"-0"+mes+"-0"+dia;
      
        }else{
      
          var fechaInicial = awo+"-"+mes+"-"+dia;
          var fechaFinal = awo+"-"+mes+"-"+dia;
      
        }
      
      //   localStorage.setItem("capturarRango2", "Hoy");
        console.log(fechaInicial,fechaFinal)
    }


      
 
 })

  //---------------------------
    //- END MONTHLY SALES CHART -
    //---------------------------
      //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
   
  //------------------------------------------
// var salesGraphChartCanvas = $('#line-chart-venta').get(0).getContext('2d');
//     var salesGraphChartData = {
//         labels  : ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
//         datasets: [
//         {
//             label               : ['ventas'],
//             fill                : false,
//             borderWidth         : 2,
//             lineTension         : 0,
//             spanGaps : false,
//             borderColor         : '#efefef',
//             pointRadius         : 3,
//             pointHoverRadius    : 7,
//             pointColor          : '#efefef',
//             pointBackgroundColor: '#efefef',
//             preUnits         : 'S/.',
//             data                : [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
//         }
//         ]
//     }
//      var salesGraphChartOptions = {
//     maintainAspectRatio : false,
//     responsive : true,
//     legend: {
//       display: false,
//     },
//     scales: {
//       xAxes: [{
//         ticks : {
//           fontColor: '#efefef',
//         },
//         gridLines : {
//           display : false,
//           color: '#efefef',
//           drawBorder: false,
//         }
//       }],
//       yAxes: [{
//         ticks : {
//           stepSize: 5000,
//           fontColor: '#efefef',
//         },
//         gridLines : {
//           display : true,
//           color: '#efefef',
//           drawBorder: false,
//         }
//       }]
//     }
//   }
//   var salesGraphChart = new Chart.Line(salesGraphChartCanvas, { 
//       type: 'line', 
//       data: salesGraphChartData, 
//       options: salesGraphChartOptions
//     }
//   )

 
 


    
})