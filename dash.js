var dashboardContent = {};
dashboardContent.stats = {};

function add() {
  //ANklJ KeRcj EAnL
  var statName = $("#statName").val();
  if (dashboardContent.stats[statName]) {
    if (confirm("Stat already exists. Replace?")) {
      $("#" + statName).remove();
    } else {
      return;
    }
  }

  var chartSizes = new Array();
  chartSizes['micro'] = {w:150, h:50};
  chartSizes['small'] = {w:300, h:100};
  chartSizes['medium'] = {w:400, h:150};
  chartSizes['large'] = {w:500, h:200};
  chartSizes['xlarge'] = {w:800, h:350};

  var chartStyle = $("#chartStyle").val();
  var chartSize = chartSizes[$("#chartSize").val()];
  var title = $("#title").val();
  var chartFooter = "";
  if (chartStyle === 'mini' ||chartStyle === 'spark') {
    chartFooter = "<div class='chartFooter'>" + title + "</div>";
  }
  $("#dashboard").append("<div id='"+statName+
    "' class='draggable ui-widget-content'><script>StatHatEmbed.render({s1: '"+statName+
      "', w: "+chartSize.w+
      ", h: "+chartSize.h+
      ", title: '"+title+
      "', tf:'half_compare', style:'"+chartStyle+
      "'});<\/script>"+chartFooter+"</div>");
  $("#" + statName).draggable();

  var stat = {};
  stat.name = statName;
  stat.title = title;
  stat.chartStyle = chartStyle;
  stat.chartSize = chartSize;
  dashboardContent.stats[statName] = stat;
  //alert("added " + dashboardContent.stats[statName].name);
}

function save() {
  $( ".draggable" ).each(function(index, element){
    var statName = element.id;
    //alert("save " + statName);
    var stat = dashboardContent.stats[statName];
    var offset = $("#" + statName).offset();
    stat.y = offset.top;
    stat.x = offset.left;
    //dashboardContent.stats[statName] = stat;
  });
  dashboardContent.backgroundColor = $("#evt_color").val();
  var jsonText = JSON.stringify(dashboardContent, null, 2);
  //alert(jsonText);
  $.ajax({
      url:"dao.php",
      type:"PUT",
      data:jsonText,
      contentType:"application/json; charset=utf-8",
      dataType:"json",
      success: function(data){
        dashId = data.id;
        vex.dialog.alert("OK! Your dashboard id:" + data.id);
      }
  });
}

function update() {
  $(".draggable").each(function(index, element){
    var statName = element.id;
    //alert("save " + statName);
    var stat = dashboardContent.stats[statName];
    var offset = $("#" + statName).offset();
    stat.y = offset.top;
    stat.x = offset.left;
    //dashboardContent.stats[statName] = stat;
  });
  dashboardContent.backgroundColor = $("#evt_color").val();
  var jsonText = JSON.stringify(dashboardContent, null, 2);
  //alert(jsonText);
  $.ajax({
      url:"dao.php?id=" + dashId,
      type:"POST",
      data:jsonText,
      contentType:"application/json; charset=utf-8",
      dataType:"json",
      success: function(data){
        vex.dialog.alert("OK! Dashboard saved.");
      }
  });
}

function switchDashboard(dashId) {
  $.get("dao.php?id="+dashId, function(data) {
    dashboardContent = JSON.parse(data);
    $("#evt_color").val(dashboardContent.backgroundColor).change();
    $.each(dashboardContent.stats, function(key, stat){

      var statName = stat.name;
      var chartSize = stat.chartSize;
      var title = stat.title;
      var chartStyle = stat.chartStyle;
      var chartFooter = "";
      if (chartStyle === 'mini' ||chartStyle === 'spark') {
        chartFooter = "<div class='chartFooter'>" + title + "</div>";
      }

      $("#dashboard").append("<div id='"+statName+
          "' class='draggable ui-widget-content' style='position:absolute;left:"+stat.x+"px;top:"+stat.y+
          "px'><script>StatHatEmbed.render({s1: '"+statName+
          "', w: "+chartSize.w+
          ", h: "+chartSize.h+
          ", title: '"+title+
          "', tf:'half_compare', style:'"+chartStyle+
          "'});<\/script>"+chartFooter+"</div>");
      $("#" + statName).draggable();
    });
});
}

function done(dashId) {
  //var dashId = $('#dashboardId').val();
  window.location = "index.php?id=" + dashId;
}
