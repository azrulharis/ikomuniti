// First Chart Example - Area Line Chart
 
$.ajax({
url: 'http://localhost/ishare/isharephal/gghadmin/index/jsongrid',
        success: function(data) {
            var $graph = data;
            var obj = $.parseJSON($graph);
Morris.Area({
  // ID of the element in which to draw the chart.
  element: 'morris-chart-area',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: 
	obj,
  // The name of the data record attribute that contains x-visitss.
  xkey: 'd',
  // A list of names of data record attributes that contain y-visitss.
  ykeys: ['visits'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['iKomuniti'],
  // Disables line smoothing
  smooth: false,
});
}
}); 

$.ajax({
url: 'http://localhost/ishare/isharephal/gghadmin/index/jsongridmonth',
        success: function(data) {
            var $graph = data;
            var obj = $.parseJSON($graph);
Morris.Area({
  // ID of the element in which to draw the chart.
  element: 'month-chart-area',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: 
	obj,
  // The name of the data record attribute that contains x-visitss.
  xkey: 'd',
  // A list of names of data record attributes that contain y-visitss.
  ykeys: ['visits'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['iKomuniti'],
  // Disables line smoothing
  smooth: false,
});
}
}); 

