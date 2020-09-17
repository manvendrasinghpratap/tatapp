function formatAllData(flag=true){
    data = [];
    var i,j;
    if(flag == true){
        for(i = 0; i < defaultNames.length; i++){
            var tmp = [1];
            for(j = 0; j < 9; j++){
                tmp.push(0);
            }
            data.push({
                draggableX: false,
                draggableY: false,
                name: defaultNames[i],
                data: [],
                rankCnt: tmp
            });
            for(j = 0; j < defaultData[i].length; j++){
                data[i].data.push({
                    x: defaultData[i][j][0],
                    y: defaultData[i][j][1],
                    Title: 'title'+(i+1),
                    Description: 'description'+(i+1),
                    Source: 'source'+(i+1),
                    OccurenceDate: new Date().getDate(),
                    color: getRandomColor(),
                    Rank: 10-i,
                    Sector: defaultNames[i],
                    Show_on_Target_Chart: true,
                    Show_on_timeline: true
                });
            }
        }
    }
    allData.push(data);
}
function formatSector(){
    $('#Sector_type').html('');
    $('#Sector_type_factor').html('');
    var i;
    var data = allData[userIndex];
    for(i = 0; i < data.length; i++){
        var html = '<option';
        if(i == 0){
            html += ' selected';
        }
        html += ' value="'+i+'">'+data[i].name+'</option>';
        $('#Sector_type').append(html);
        $('#Sector_type_factor').append(html);
    }
}
function makeAll(){
    formatSector();
    drawChart();
}
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }
// Make a copy of the defaults, call this line before any other setOptions call
var HCDefaults = $.extend(true, {}, Highcharts.getOptions(), {});

function defaultTheme() {
    // Fortunately, Highcharts returns the reference to defaultOptions itself
    // We can manipulate this and delete all the properties
    var defaultOptions = Highcharts.getOptions();
    for (var prop in defaultOptions) {
        if (typeof defaultOptions[prop] !== 'function') delete defaultOptions[prop];
    }
    // Fall back to the defaults that we captured initially, this resets the theme
    Highcharts.setOptions(HCDefaults);
}

function darkUnica(){
    Highcharts.theme = {
        colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
           '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
        chart: {
           backgroundColor: {
              linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
              stops: [
                 [0, '#2a2a2b'],
                 [1, '#3e3e40']
              ]
           },
           style: {
              fontFamily: '\'Unica One\', sans-serif'
           },
           plotBorderColor: '#606063'
        },
        title: {
           style: {
              color: '#E0E0E3',
              textTransform: 'uppercase',
              fontSize: '20px'
           }
        },
        subtitle: {
           style: {
              color: '#E0E0E3',
              textTransform: 'uppercase'
           }
        },
        xAxis: {
           gridLineColor: '#707073',
           labels: {
              style: {
                 color: '#E0E0E3'
              }
           },
           lineColor: '#707073',
           minorGridLineColor: '#505053',
           tickColor: '#707073',
           title: {
              style: {
                 color: '#A0A0A3'
     
              }
           }
        },
        yAxis: {
           gridLineColor: '#707073',
           labels: {
              style: {
                 color: '#E0E0E3'
              }
           },
           lineColor: '#707073',
           minorGridLineColor: '#505053',
           tickColor: '#707073',
           tickWidth: 1,
           title: {
              style: {
                 color: '#A0A0A3'
              }
           }
        },
        tooltip: {
           backgroundColor: 'rgba(0, 0, 0, 0.85)',
           style: {
              color: '#F0F0F0'
           }
        },
        plotOptions: {
           series: {
              dataLabels: {
                 color: '#B0B0B3'
              },
              marker: {
                 lineColor: '#333'
              }
           },
           boxplot: {
              fillColor: '#505053'
           },
           candlestick: {
              lineColor: 'white'
           },
           errorbar: {
              color: 'white'
           }
        },
        legend: {
           itemStyle: {
              color: '#E0E0E3'
           },
           itemHoverStyle: {
              color: '#FFF'
           },
           itemHiddenStyle: {
              color: '#606063'
           }
        },
        credits: {
           style: {
              color: '#666'
           }
        },
        labels: {
           style: {
              color: '#707073'
           }
        },
     
        drilldown: {
           activeAxisLabelStyle: {
              color: '#F0F0F3'
           },
           activeDataLabelStyle: {
              color: '#F0F0F3'
           }
        },
     
        navigation: {
           buttonOptions: {
              symbolStroke: '#DDDDDD',
              theme: {
                 fill: '#505053'
              }
           }
        },
     
        // scroll charts
        rangeSelector: {
           buttonTheme: {
              fill: '#505053',
              stroke: '#000000',
              style: {
                 color: '#CCC'
              },
              states: {
                 hover: {
                    fill: '#707073',
                    stroke: '#000000',
                    style: {
                       color: 'white'
                    }
                 },
                 select: {
                    fill: '#000003',
                    stroke: '#000000',
                    style: {
                       color: 'white'
                    }
                 }
              }
           },
           inputBoxBorderColor: '#505053',
           inputStyle: {
              backgroundColor: '#333',
              color: 'silver'
           },
           labelStyle: {
              color: 'silver'
           }
        },
     
        navigator: {
           handles: {
              backgroundColor: '#666',
              borderColor: '#AAA'
           },
           outlineColor: '#CCC',
           maskFill: 'rgba(255,255,255,0.1)',
           series: {
              color: '#7798BF',
              lineColor: '#A6C7ED'
           },
           xAxis: {
              gridLineColor: '#505053'
           }
        },
     
        scrollbar: {
           barBackgroundColor: '#808083',
           barBorderColor: '#808083',
           buttonArrowColor: '#CCC',
           buttonBackgroundColor: '#606063',
           buttonBorderColor: '#606063',
           rifleColor: '#FFF',
           trackBackgroundColor: '#404043',
           trackBorderColor: '#404043'
        },
     
        // special colors for some of the
        legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
        background2: '#505053',
        dataLabelsColor: '#B0B0B3',
        textColor: '#C0C0C0',
        contrastTextColor: '#F0F0F3',
        maskColor: 'rgba(255,255,255,0.3)'
     };
     // Apply the theme
     Highcharts.setOptions(Highcharts.theme);
}

function sandSignika(){
    // Add the background image to the container
    Highcharts.wrap(Highcharts.Chart.prototype, 'getContainer', function (proceed) {
        proceed.call(this);
        this.container.style.background =
        'url(http://www.highcharts.com/samples/graphics/sand.png)';
    });
 
 
 Highcharts.theme = {
    colors: ['#f45b5b', '#8085e9', '#8d4654', '#7798BF', '#aaeeee',
       '#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
    chart: {
       backgroundColor: null,
       style: {
          fontFamily: 'Signika, serif'
       }
    },
    title: {
       style: {
          color: 'black',
          fontSize: '16px',
          fontWeight: 'bold'
       }
    },
    subtitle: {
       style: {
          color: 'black'
       }
    },
    tooltip: {
       borderWidth: 0
    },
    legend: {
       itemStyle: {
          fontWeight: 'bold',
          fontSize: '13px'
       }
    },
    xAxis: {
       labels: {
          style: {
             color: '#6e6e70'
          }
       }
    },
    yAxis: {
       labels: {
          style: {
             color: '#6e6e70'
          }
       }
    },
    plotOptions: {
       series: {
          shadow: true
       },
       candlestick: {
          lineColor: '#404048'
       },
       map: {
          shadow: false
       }
    },
 
    // Highstock specific
    navigator: {
       xAxis: {
          gridLineColor: '#D0D0D8'
       }
    },
    rangeSelector: {
       buttonTheme: {
          fill: 'white',
          stroke: '#C0C0C8',
          'stroke-width': 1,
          states: {
             select: {
                fill: '#D0D0D8'
             }
          }
       }
    },
    scrollbar: {
       trackBorderColor: '#C0C0C8'
    },
 
    // General
    background2: '#E0E0E8'
 
 };
 
 // Apply the theme
 Highcharts.setOptions(Highcharts.theme);
}

function gridLight(){
    Highcharts.createElement('link', {
        href: 'https://fonts.googleapis.com/css?family=Dosis:400,600',
        rel: 'stylesheet',
        type: 'text/css'
     }, null, document.getElementsByTagName('head')[0]);
     
     Highcharts.theme = {
        colors: ['#7cb5ec', '#f7a35c', '#90ee7e', '#7798BF', '#aaeeee', '#ff0066',
           '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
        chart: {
           backgroundColor: null,
           style: {
              fontFamily: 'Dosis, sans-serif'
           }
        },
        title: {
           style: {
              fontSize: '16px',
              fontWeight: 'bold',
              textTransform: 'uppercase'
           }
        },
        tooltip: {
           borderWidth: 0,
           backgroundColor: 'rgba(219,219,216,0.8)',
           shadow: false
        },
        legend: {
           itemStyle: {
              fontWeight: 'bold',
              fontSize: '13px'
           }
        },
        xAxis: {
           gridLineWidth: 1,
           labels: {
              style: {
                 fontSize: '12px'
              }
           }
        },
        yAxis: {
           minorTickInterval: 'auto',
           title: {
              style: {
                 textTransform: 'uppercase'
              }
           },
           labels: {
              style: {
                 fontSize: '12px'
              }
           }
        },
        plotOptions: {
           candlestick: {
              lineColor: '#404048'
           }
        },
     
     
        // General
        background2: '#F0F0EA'
     
     };
     
     // Apply the theme
     Highcharts.setOptions(Highcharts.theme);
}

function formatModal(){
    $('#modalBt').trigger('click');
    $('#Title').val("");
    $('#Description').val("");
    $('#Source').val("");
    $('#OccurenceDate').val("");
    $('#Rank').val("");
    $('#Sector').val("");
    $('#Show_on_Target_Chart').prop( "checked", false);
    $('#Show_on_timeline').prop( "checked", false);
}
 
function drawChart(){
    $('#container').html('');
    var i;
    var series = allData[userIndex];
    var doubleClicker = {
        clickedOnce : false,
        timer : null,
        timeBetweenClicks : 400
    };
    // call to reset double click timer
    var resetDoubleClick = function() {
        clearTimeout(doubleClicker.timer);
        doubleClicker.timer = null;
        doubleClicker.clickedOnce = false;
      };

      // the actual callback for a double-click event
    var ondbclick = function(e, point) {
        if (point && point.x) {
            var userOptions = point;
            formatModal();
            $('#Title').val(userOptions.Title);
            $('#Description').val(userOptions.Description);
            $('#Source').val(userOptions.Source);
            $('#OccurenceDate').val(userOptions.OccurenceDate);
            prevRank = userOptions.Rank;
            $('#Rank').val(userOptions.Rank);
            // $('#Rank').val(10);
            var i, userData = allData[userIndex];
            $('#Sector').html('');
            for(i = 0; i < userData.length; i++){
                var name = userData[i].name;
                var html = '<option';
                if(userOptions.Sector == name){
                    html += ' selected';
                }
                html += ' value="'+i+'">'+name+'</option>';
                $('#Sector').append(html);
            }
            if(userOptions.Show_on_Target_Chart){
                $('#Show_on_Target_Chart').prop( "checked", true);
            }else{
                $('#Show_on_Target_Chart').prop( "checked", false);
            }
            if(userOptions.Show_on_timeline){
                $('#Show_on_timeline').prop( "checked", true);
            }else{
                $('#Show_on_timeline').prop( "checked", false);
            }
            seriesIndex = point.series.index;
            valIndex = point.index;
            AddDbclk = 2;
            $('#SectorDiv').show();
			$('#deleteFactor').show();
        }
    };
    var chart = Highcharts.chart('container', {
        chart: chart_type,
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            tickInterval: 3,
            title: {
                enabled: true,
                text: ''
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: false
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
              formatter: function () {
                if(this.value == 0) return "";
                return 11-this.value;
              }
            },
            tickInterval:1,
            min:0,
            max:11
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 100,
            y: 70,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
            borderWidth: 1
        },
        plotOptions: {
            scatter: {
                marker: {
                    radius: 5,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                point: {
                    events: {
                        click: function(e) {
                            if (doubleClicker.clickedOnce === true && doubleClicker.timer) {
                                resetDoubleClick();
                                ondbclick(e, this);
                            } else {
                                doubleClicker.clickedOnce = true;
                                doubleClicker.timer = setTimeout(function(){
                                resetDoubleClick();
                                }, doubleClicker.timeBetweenClicks);
                            }
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.Title +'</b>';
            }
        },
        series: series
    });
}

function drawTimeline(){
    $.getJSON('data/data.json', function (data) {
        // Create the chart
        Highcharts.chart('timeline', {

            chart:{
                zoomType: 'x'
            },
            rangeSelector: {
                selected: 2
            },
            xAxis: {
                type: 'datetime'
            },

            title: {
                text: 'Time Line'
            },

            series: [{
                name: 'TimeLine',
                data: data,
                lineWidth: 0,
                marker: {
                    enabled: true,
                    radius: 2
                },
                tooltip: {
                    valueDecimals: 2
                },
                states: {
                    hover: {
                        lineWidthPlus: 0
                    }
                }
            }]
        });
    });
}



