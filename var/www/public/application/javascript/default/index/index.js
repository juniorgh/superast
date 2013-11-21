// javascript source for action index from default module
$(document).ready(function(){
    var data, options, line1, plot1, plot2;

    data = [[['Verwerkende industrie', 9],
        ['Retail', 0],
        ['Primaire producent', 0], 
        ['Out of home', 0],
        ['Groothandel', 0],
        ['Grondstof', 0],
        ['Consument', 3],
        ['Bewerkende industrie', 2]]];

    options = {
        title: ' ', 
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
    };

    plot1 = $.jqplot('chart1', data, options);

    line1 = [[14, 32, 41, 44, 40, 47, 53, 67]];
    options = {
        title: 'Chart with Point Labels', 
        seriesDefaults: { 
            showMarker: false,
            pointLabels: {
                show: true
            } 
        }
    };

    plot2 = $.jqplot('chart2', line1, options);

});