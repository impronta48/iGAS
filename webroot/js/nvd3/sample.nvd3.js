//Discrete Bar chart

historicalBarChart = [ 
  {
    key: "Cumulative Return",
    values: [
      { 
        "label" : "A" ,
        "value" : 29.765957771107
      } , 
      { 
        "label" : "B" , 
        "value" : 0
      } , 
      { 
        "label" : "C" , 
        "value" : 32.807804682612
      } , 
      { 
        "label" : "D" , 
        "value" : 196.45946739256
      } , 
      { 
        "label" : "E" ,
        "value" : 0.19434030906893
      } , 
      { 
        "label" : "F" , 
        "value" : 98.079782601442
      } , 
      { 
        "label" : "G" , 
        "value" : 13.925743130903
      } , 
      { 
        "label" : "H" , 
        "value" : 5.1387322875705
      }
    ]
  }
];




nv.addGraph(function() {  
  var chart = nv.models.discreteBarChart()
      .x(function(d) { return d.label })
      .y(function(d) { return d.value })
      .staggerLabels(true)
      //.staggerLabels(historicalBarChart[0].values.length > 8)
      .tooltips(false)
      .showValues(true)
      .transitionDuration(250)
      ;

  d3.select('#chart1 svg')
      .datum(historicalBarChart)
      .call(chart);

  nv.utils.windowResize(chart.update);

  return chart;
});


//Pie chart

  var testdata = [
    {
      key: "One",
      y: 5
    },
    {
      key: "Two",
      y: 2
    },
    {
      key: "Three",
      y: 9
    },
    {
      key: "Four",
      y: 7
    },
    {
      key: "Five",
      y: 4
    },
    {
      key: "Six",
      y: 3
    },
    {
      key: "Seven",
      y: .5
    }
  ];


nv.addGraph(function() {
    var width = 500,
        height = 350;

    var chart = nv.models.pieChart()
        .x(function(d) { return d.key })
        .y(function(d) { return d.y })
        .color(d3.scale.category10().range())
        .width(width)
        .height(height);

      d3.select("#test1")
          .datum(testdata)
        .transition().duration(1200)
          .attr('width', width)
          .attr('height', height)
          .call(chart);

    chart.dispatch.on('stateChange', function(e) { nv.log('New State:', JSON.stringify(e)); });

    return chart;
});
