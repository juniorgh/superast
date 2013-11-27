// javascript source for action index from default module
$(document).ready(function(){
    var data, options, line1, plots;

    plots = {};

    plots.chart1 = $.jqplot('chart1', [[['Verwerkende industrie', 9],
        ['Retail', 0],
        ['Primaire producent', 0], 
        ['Out of home', 0],
        ['Groothandel', 0],
        ['Grondstof', 0],
        ['Consument', 3],
        ['Bewerkende industrie', 2]]], {
        animate: true,
        animateReplot: true,
        seriesDefaults: {
            shadow: false, 
            renderer: $.jqplot.PieRenderer, 
            rendererOptions: { 
                startAngle: 180, 
                sliceMargin: 4, 
                showDataLabels: true
            } 
        }, 
        legend: {
            show: true,
            location: 'w'
        }
    });

    plots.chart2 = $.jqplot('chart2', [[14, 32, 41, 44, 40, 47, 53, 67]], {
        seriesDefaults: { 
            showMarker: false,
            pointLabels: {
                show: true
            } 
        }
    });

    plots.chart3 = $.jqplot('chart3', [[3,7,9,1,4,6,8,2,5]], {
      animate: true,
      animateReplot: true,
      axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer
      },
      axes: {
        xaxis: {
          label: "X Axis",
          pad: 0
        },
        yaxis: {
          label: "Y Axis"
        }
      }
    });

});