$("#releases-per-year").on("click", function(e) {
    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
    e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    var modalBox = $(this).attr('data-modal-id');
    $('#'+modalBox).fadeIn($(this).data());
});

$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
});

$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});

$(window).resize();


var oReq = new XMLHttpRequest();  // New request object.
oReq.onload = function() {
    data = $.parseJSON(this.responseText);

  // define the x scale (horizontal)
  var margin = {top: 10, right: 10, bottom: 100, left: 40},
  margin2 = {top: 430, right: 10, bottom: 20, left: 40},
  width = 960 - margin.left - margin.right,
  height = 500 - margin.top - margin.bottom,
  height2 = 500 - margin2.top - margin2.bottom;

  var parseDate = d3.time.format("%Y-%m").parse;

  var x = d3.time.scale().range([0, width]),
  x2 = d3.time.scale().range([0, width]),
  y = d3.scale.linear().range([height, 0]),
  y2 = d3.scale.linear().range([height2, 0]);

  var xAxis = d3.svg.axis().scale(x).orient("bottom"),
  xAxis2 = d3.svg.axis().scale(x2).orient("bottom"),
  yAxis = d3.svg.axis().scale(y).orient("left");

  var brush = d3.svg.brush()
  .x(x2)
  .on("brush", brushed);

  var area = d3.svg.area()
  .interpolate("monotone")
  .x(function(d) { return x(d.date); })
  .y0(height)
  .y1(function(d) { return y(d.records); });

  var area2 = d3.svg.area()
  .interpolate("monotone")
  .x(function(d) { return x2(d.date); })
  .y0(height2)
  .y1(function(d) { return y2(d.records); });

  var svg = d3.select(".visualization").append("svg")
  .attr("width", width + margin.left + margin.right)
  .attr("height", height + margin.top + margin.bottom);

  svg.append("defs").append("clipPath")
  .attr("id", "clip")
  .append("rect")
  .attr("width", width)
  .attr("height", height);

  var focus = svg.append("g")
  .attr("class", "focus")
  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  var context = svg.append("g")
  .attr("class", "context")
  .attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

data.forEach(function(d) {
    if (!d.date) {
      return;
    }
    type(d);
  })

  /*x.domain([minDate, maxDate]);*/
  x.domain(d3.extent(data.map(function(d) { return d.date; })));
  y.domain([0, d3.max(data.map(function(d) { return d.records; }))]);
  x2.domain(x.domain());
  y2.domain(y.domain());

  focus.append("path")
  .datum(data)
  .attr("class", "area")
  .attr("d", area);

  focus.append("g")
  .attr("class", "x axis")
  .attr("transform", "translate(0," + height + ")")
  .call(xAxis);

  focus.append("g")
  .attr("class", "y axis")
  .call(yAxis);

  context.append("path")
  .datum(data)
  .attr("class", "area")
  .attr("d", area2);

  context.append("g")
  .attr("class", "x axis")
  .attr("transform", "translate(0," + height2 + ")")
  .call(xAxis2);

  context.append("g")
  .attr("class", "x brush")
  .call(brush)
  .selectAll("rect")
  .attr("y", -6)
  .attr("height", height2 + 7);


  function brushed() {
    x.domain(brush.empty() ? x2.domain() : brush.extent());
    focus.select(".area").attr("d", area);
    focus.select(".x.axis").call(xAxis);
  }

  function type(d) {
    d.date = parseDate(d.date);
    d.records = +d.records;
    return d;
  }
}

oReq.open("get", "releases-per-year.php", true);
oReq.send();