<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>StatHat Dashboard</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="style.css">
  <script>
    $(function() {
      switchDashboard();
      //$(".draggable").draggable();
    });

    var dashId = <?php echo $_GET['id'];?>;
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
      $(".draggable").each(function(index, element){
        var statName = element.id;
        //alert("save " + statName);
        var stat = dashboardContent.stats[statName];
        var offset = $("#" + statName).offset();
        stat.y = offset.top;
        stat.x = offset.left;
        //dashboardContent.stats[statName] = stat;
      });
      var jsonText = JSON.stringify(dashboardContent, null, 2);
      //alert(jsonText);
      $.ajax({
          url:"dao.php?id=" + dashId,
          type:"POST",
          data:jsonText,
          contentType:"application/json; charset=utf-8",
          dataType:"json",
          success: function(data){
            alert("OK!");
          }
      });
    }

    function switchDashboard() {
      $.get("dao.php?id="+dashId, function(data) {
        //alert(data);
        dashboardContent = JSON.parse(data);
        //alert(dashboardContent);
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
  function done() {
    window.location = "index.html";
  }

  </script>
</head>
<body>
 <script src="//www.stathat.com/javascripts/embed.js"></script>
 <input id="title" type="text" name="title" value="Title"/>
 <input id="statName" type="text" name="statName" value="StatHat stat code"/>
 <select id="chartStyle" name="chartStyle" required="true">
  <option value="spark" default="true">Spark</option>
  <option value="mini">Mini</option>
  <option value="fill">Fill</option>
  <option value="fill_bar">Fill Bar</option>
 </select>
 <select id="chartSize" name="chartSize" required="true">
  <option value="micro">Micro</option>
  <option value="small" default="true">Small</option>
  <option value="medium">Medium</option>
  <option value="large">Large</option>
  <option value="xlarge">Extra Large</option>
 </select>
 <button onClick="add()">Add</button>
 <button onClick="save()">Save</button>
 <button onClick="done()">Done</button>
 <div id="dashboard"></div>
</body>
</html>
