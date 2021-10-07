// First Donut chart on Dashboard
Morris.Donut({
    element: "donut",
    data: [ {
        value: 70,
        label: "foo"
    }, {
        value: 15,
        label: "bar"
    }, {
        value: 10,
        label: "baz"
    }, {
        value: 5,
        label: "A really really long label"
    } ],
    formatter: function(e) {
        return e + "%";
    }
}).on("click", function(e, t) {
    console.log(e, t);
});

Morris.Donut({
    element: "coloredDonut",
    data: [ {
        value: 15,
        label: "Success"
    }, {
        value: 60,
        label: "Primary"
    }, {
        value: 10,
        label: "Info"
    }, {
        value: 10,
        label: "Warning"
    }, {
        value: 5,
        label: "A really really long Danger"
    } ],
    labelColor: "#54728c",
    colors: [ "#90c657", "#54728c", "#54b5df", "#f9a94a", "#e45857" ],
    formatter: function(e) {
        return e + "%";
    }
});

//Nvd3 pie charts

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
    }
  ];


nv.addGraph(function() {
    var width = nv.utils.windowSize().width - 40,
        height = nv.utils.windowSize().height / 2 - 40;

    var chart = nv.models.pie()
        .values(function(d) { return d });

    d3.select("#pieOne")
        .datum([testdata])
      .transition().duration(1200)
        .attr('width', width)
        .attr('height', height)
        .call(chart);

    return chart;
});

nv.addGraph(function() {
    var width = nv.utils.windowSize().width - 40,
        height = nv.utils.windowSize().height / 2 - 40;

    var chart = nv.models.pie()
        .values(function(d) { return d })
        .donut(true);

    d3.select("#pieTwo")
        .datum([testdata])
      .transition().duration(1200)
        .attr('width', width)
        .attr('height', height)
        .call(chart);

    return chart;
});



$(function() {

//Easy Pie charts

  $('.easyChart').easyPieChart({
      easing: 'easeOutBounce',
      size:'230',
      lineWidth:'10',
      barColor:'#54728c',
      scaleColor:'#54728c',
      trackColor:'#EEEEEE',
      onStep: function(from, to, percent) {
        $(this.el).find('.percent').text(Math.round(percent));
      }
    });

  var chart = window.chart = $('.easyChart').data('easyPieChart');
    $('.js_update').on('click', function() {
      chart.update(Math.random()*100);
    });

  $('.easyChartLive').easyPieChart({
      animate: 5000,
      size:'230',
      lineWidth:'10',
      barColor:'#54728c',
      scaleColor:'#54728c',
      trackColor:'#EEEEEE',
      onStep: function(from, to, percent) {
        $(this.el).find('.percent').text(Math.round(percent));
      }
    });

  setTimeout(function() {
        $('.easyChartLive').data('easyPieChart').update(40);
    }, 5000);

  $('.easyChartCustom').easyPieChart({
       animate: 10000,
      size:'230',
      lineWidth:'5',
      barColor:'#f9a94a',
      scaleColor:'#e45857',
      trackColor:'#EEEEEE',
      onStep: function(from, to, percent) {
        $(this.el).find('.percent').text(Math.round(percent));
      }
    });


// All types of pie charts

// Example Data

     // Randomly Generated Data

    var data = [],
      series = Math.floor(Math.random() * 6) + 3;

    for (var i = 0; i < series; i++) {
      data[i] = {
        label: "Series" + (i + 1),
        data: Math.floor(Math.random() * 100) + 1
      }
    }

    var placeholder = $("#placeholder");

    $("#example-1").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Default pie chart");
      $("#description").text("The default pie chart with no options set.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true
          }
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true",
        "        }",
        "    }",
        "});"
      ]);
    });

    $("#example-2").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Default without legend");
      $("#description").text("The default pie chart when the legend is disabled. Since the labels would normally be outside the container, the chart is resized to fit.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-3").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');
      placeholder.unbind();

      $("#title").text("Custom Label Formatter");
      $("#description").text("Added a semi-transparent background to the labels and a custom labelFormatter function.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 1,
            label: {
              show: true,
              radius: 1,
              formatter: labelFormatter,
              background: {
                opacity: 0.8
              }
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true,",
        "            radius: 1,",
        "            label: {",
        "                show: true,",
        "                radius: 1,",
        "                formatter: labelFormatter,",
        "                background: {",
        "                    opacity: 0.8",
        "                }",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-4").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Label Radius");
      $("#description").text("Slightly more transparent label backgrounds and adjusted the radius values to place them within the pie.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 1,
            label: {
              show: true,
              radius: 3/4,
              formatter: labelFormatter,
              background: {
                opacity: 0.5
              }
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true,",
        "            radius: 1,",
        "            label: {",
        "                show: true,",
        "                radius: 3/4,",
        "                formatter: labelFormatter,",
        "                background: {",
        "                    opacity: 0.5",
        "                }",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-5").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Label Styles #1");
      $("#description").text("Semi-transparent, black-colored label background.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 1,
            label: {
              show: true,
              radius: 3/4,
              formatter: labelFormatter,
              background: { 
                opacity: 0.5,
                color: "#000"
              }
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: { ",
        "            show: true,",
        "            radius: 1,",
        "            label: {",
        "                show: true,",
        "                radius: 3/4,",
        "                formatter: labelFormatter,",
        "                background: { ",
        "                    opacity: 0.5,",
        "                    color: '#000'",
        "                }",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-6").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Label Styles #2");
      $("#description").text("Semi-transparent, black-colored label background placed at pie edge.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 3/4,
            label: {
              show: true,
              radius: 3/4,
              formatter: labelFormatter,
              background: { 
                opacity: 0.5,
                color: "#000"
              }
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true,",
        "            radius: 3/4,",
        "            label: {",
        "                show: true,",
        "                radius: 3/4,",
        "                formatter: labelFormatter,",
        "                background: {",
        "                    opacity: 0.5,",
        "                    color: '#000'",
        "                }",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-7").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Hidden Labels");
      $("#description").text("Labels can be hidden if the slice is less than a given percentage of the pie (10% in this case).");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 1,
            label: {
              show: true,
              radius: 2/3,
              formatter: labelFormatter,
              threshold: 0.1
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true,",
        "            radius: 1,",
        "            label: {",
        "                show: true,",
        "                radius: 2/3,",
        "                formatter: labelFormatter,",
        "                threshold: 0.1",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-8").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Combined Slice");
      $("#description").text("Multiple slices less than a given percentage (5% in this case) of the pie can be combined into a single, larger slice.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            combine: {
              color: "#999",
              threshold: 0.05
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true,",
        "            combine: {",
        "                color: '#999',",
        "                threshold: 0.1",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-9").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Rectangular Pie");
      $("#description").text("The radius can also be set to a specific size (even larger than the container itself).");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 500,
            label: {
              show: true,
              formatter: labelFormatter,
              threshold: 0.1
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true,",
        "            radius: 500,",
        "            label: {",
        "                show: true,",
        "                formatter: labelFormatter,",
        "                threshold: 0.1",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});"
      ]);
    });

    $("#example-10").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Tilted Pie");
      $("#description").text("The pie can be tilted at an angle.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 1,
            tilt: 0.5,
            label: {
              show: true,
              radius: 1,
              formatter: labelFormatter,
              background: {
                opacity: 0.8
              }
            },
            combine: {
              color: "#999",
              threshold: 0.1
            }
          }
        },
        legend: {
          show: false
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true,",
        "            radius: 1,",
        "            tilt: 0.5,",
        "            label: {",
        "                show: true,",
        "                radius: 1,",
        "                formatter: labelFormatter,",
        "                background: {",
        "                    opacity: 0.8",
        "                }",
        "            },",
        "            combine: {",
        "                color: '#999',",
        "                threshold: 0.1",
        "            }",
        "        }",
        "    },",
        "    legend: {",
        "        show: false",
        "    }",
        "});",
      ]);
    });

    $("#example-11").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Donut Hole");
      $("#description").text("A donut hole can be added.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            innerRadius: 0.5,
            show: true
          }
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            innerRadius: 0.5,",
        "            show: true",
        "        }",
        "    }",
        "});"
      ]);
    });

    $("#example-12").click(function(e) {
      e.preventDefault();
      $('.flot-pie-charts a').removeClass('active');
      $(this).addClass('active');

      placeholder.unbind();

      $("#title").text("Interactivity");
      $("#description").text("The pie can be made interactive with hover and click events.");

      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true
          }
        },
        grid: {
          hoverable: true,
          clickable: true
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true",
        "        }",
        "    },",
        "    grid: {",
        "        hoverable: true,",
        "        clickable: true",
        "    }",
        "});"
      ]);

      placeholder.bind("plothover", function(event, pos, obj) {

        if (!obj) {
          return;
        }

        var percent = parseFloat(obj.series.percent).toFixed(2);
        $("#hover").html("<span style='font-weight:bold; color:" + obj.series.color + "'>" + obj.series.label + " (" + percent + "%)</span>");
      });

      placeholder.bind("plotclick", function(event, pos, obj) {

        if (!obj) {
          return;
        }

        percent = parseFloat(obj.series.percent).toFixed(2);
        alert(""  + obj.series.label + ": " + percent + "%");
      });
    });

    // Show the initial default chart

    $("#example-1").click();


});


function labelFormatter(label, series) {
  return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
}

//

function setCode(lines) {
  $("#code").text(lines.join("\n"));
}

