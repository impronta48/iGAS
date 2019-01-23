
//Morris Live Updating Chart
var nReloads = 0;
function dataM(offset) {
  var ret = [];
  for (var x = 0; x <= 360; x += 10) {
    var v = (offset + x) % 360;
    ret.push({
      x: x,
      y: Math.sin(Math.PI * v / 180).toFixed(4),
      z: Math.cos(Math.PI * v / 180).toFixed(4)
    });
  }
  return ret;
}
var graph = Morris.Line({
    element: 'liveGraph',
    dataM: dataM(0),
    xkey: 'x',
    ykeys: ['y', 'z'],
    labels: ['sin()', 'cos()'],
    parseTime: false,
    ymin: -1.0,
    ymax: 1.0,
    hideHover: true
});
function update() {
  nReloads++;
  graph.setData(dataM(5 * nReloads));
  $('#reloadStatus').text(nReloads + ' Reloads');
}
setInterval(update, 1000);

//NVD3 Live Updating Chart

var chart;
var data = [{
  key: "Stream 1",
  color: "orange",
  values: [
    {x: 1, y: 1}
  ]
}];
nv.addGraph(function() {
  
  chart = nv.models.historicalBarChart();

  chart
      .x(function(d,i) { return d.x });

  chart.xAxis // chart sub-models (ie. xAxis, yAxis, etc) when accessed directly, return themselves, not the parent chart, so need to chain separately
      .tickFormat(d3.format(',.1f'))
      .axisLabel("Time")
      ;

  chart.yAxis
      .axisLabel('Random Number')
      .tickFormat(d3.format(',.4f'));

  chart.showXAxis(true).showYAxis(true).rightAlignYAxis(true).margin({right: 90});

  d3.select('#nvdLive svg')
      .datum(data)
      .transition().duration(500)
      .call(chart);

  nv.utils.windowResize(chart.update);

  return chart;
});

var x = 2;
var run = true;
setInterval(function(){
  if (!run) return;
  
  var spike = (Math.random() > 0.95) ? 10: 1;
  data[0].values.push({
    x: x,
    y: Math.random() * spike
  });

  if (data[0].values.length > 70) {
    data[0].values.shift();
  }
  x++;

  chart.update();
}, 500);

d3.select("#start-stop-button").on("click",function() {
  if($(this).hasClass('btn-danger')){
    $(this).removeClass('btn-danger').addClass('btn-success').html('Start Live Stream');
  }
  else
  {
    $(this).removeClass('btn-success').addClass('btn-danger').html('Stop Live Stream');
    
  }
  run = !run;
});



//Flot real time chart


$(function() {
    //Real time chart on main page
    var data = [],
      totalPoints = 300;

    function getRandomData() {

      if (data.length > 0)
        data = data.slice(1);

      // Do a random walk

      while (data.length < totalPoints) {

        var prev = data.length > 0 ? data[data.length - 1] : 50,
          y = prev + Math.random() * 10 - 5;

        if (y < 0) {
          y = 0;
        } else if (y > 100) {
          y = 100;
        }

        data.push(y);
      }

      // Zip the generated y values with the x values

      var res = [];
      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]]);
      }

      return res;
    }

    // Set up the control widget

    var updateInterval = 30;
    $("#updateInterval").val(updateInterval).change(function () {
      var v = $(this).val();
      if (v && !isNaN(+v)) {
        updateInterval = +v;
        if (updateInterval < 1) {
          updateInterval = 1;
        } else if (updateInterval > 2000) {
          updateInterval = 2000;
        }
        $(this).val("" + updateInterval);
      }
    });

    var plot = $.plot("#placeholder", [ getRandomData() ], {
      series: {
        shadowSize: 0 // Drawing is faster without shadows
      },
      yaxis: {
        min: 0,
        max: 100
      },
      xaxis: {
        show: false
      }
    });

    function update() {

      plot.setData([getRandomData()]);

      // Since the axes don't change, we don't need to call plot.setupGrid()

      plot.draw();
      setTimeout(update, updateInterval);
    }

    update();
    // Randomly Generated Data

        
  });