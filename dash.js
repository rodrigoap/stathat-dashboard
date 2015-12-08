var StatDash = function(){
  this.dashboardContent = {};
  this.dashboardContent.stats = {};
  this.backgroundColor = "";
};

var Stat = function(){
  this.name = "";
  this.title = "";
  this.chartStyle = "";
  this.chartSize = "";
  this.x = 0;
  this.y = 0;
};


StatDash.prototype.add = function() {
  //ANklJ KeRcj EAnL 6UVc
  var statName = $("#statName").val();
  if (this.dashboardContent.stats[statName]) {
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

  var stat = new Stat();
  stat.name = statName;
  stat.title = title;
  stat.chartStyle = chartStyle;
  stat.chartSize = chartSize;
  this.dashboardContent.stats[statName] = stat;
}

StatDash.prototype.save = function() {
  if (dashId==='') {
    var theDash = this;
    $( ".draggable" ).each(function(index, element){
      var statName = element.id;
      var stat = theDash.dashboardContent.stats[statName];
      var offset = $("#" + statName).offset();
      stat.y = offset.top;
      stat.x = offset.left;
    });
    this.dashboardContent.backgroundColor = $("#evt_color").val();
    var jsonText = JSON.stringify(this.dashboardContent, null, 2);
    $.ajax({
        url:"dao.php",
        type:"PUT",
        data:jsonText,
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(data){
          dashId = data.id;
          vex.dialog.alert("OK! Your dashboard id is: " + data.id);
        }
    });
  } else {
    this.update();
  }
}

StatDash.prototype.update = function() {
  var theDash = this;
  $(".draggable").each(function(index, element){
    var statName = element.id;
    var stat = theDash.dashboardContent.stats[statName];
    var offset = $("#" + statName).offset();
    stat.y = offset.top;
    stat.x = offset.left;
  });
  this.dashboardContent.backgroundColor = $("#evt_color").val();
  var jsonText = JSON.stringify(this.dashboardContent, null, 2);
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

StatDash.prototype.switchDashboard = function(dashId) {
  var theDash = this;
  $.get("dao.php?id="+dashId, function(data) {
    theDash.dashboardContent = JSON.parse(data);
    $("#evt_color").val(theDash.dashboardContent.backgroundColor).change();
    $.each(theDash.dashboardContent.stats, function(key, stat){
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

StatDash.prototype.switchDashboardOld = function() {
      var dashId = $("#dashboardId").val();
      $("#editCurrent").prop("disabled", false);
      $.get( "dao.php?id="+dashId, function(data) {
        $("#dashboard").empty();
        this.dashboardContent = JSON.parse(data);
        $("body").css("background-color", this.dashboardContent.backgroundColor);
        $.each(this.dashboardContent.stats, function(key, stat){
          var statName = stat.name;
          var chartSize = stat.chartSize;
          var title = stat.title;
          var chartStyle = stat.chartStyle;
          var chartFooter = "";
          if (chartStyle === 'mini' ||chartStyle === 'spark') {
            chartFooter = "<div class='chartFooter'>" + title + "</div>";
          }
          $("#dashboard").append("<div id='"+statName+
              "' style='position:absolute;left:"+stat.x+"px;top:"+stat.y+
              "px'><script>StatHatEmbed.render({s1: '"+statName+
              "', w: "+chartSize.w+
              ", h: "+chartSize.h+
              ", title: '"+title+
              "', tf:'half_compare', style:'"+chartStyle+
              "'});<\/script>"+chartFooter+"</div>");
        });
    });
  }


StatDash.prototype.done = function(dashId) {
  window.location = "index.php?id=" + dashId;
}

StatDash.prototype.create = function() {
  window.location = "dash.html";
}

StatDash.prototype.editCurrent = function() {
  var dashboardId = $("#dashboardId").val();
  window.location = "dashboard.php?id=" + dashboardId;
}
