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
      <?php
          if (isset($_GET['id'])) {
            $id = $_GET['id'];
            echo "$('#dashboardId').val('" . $id . "');";
            echo "switchDashboard('" . $id . "');";
          }
       ?>
    });

    function switchDashboard() {
      var dashId = $("#dashboardId").val();
      $.get( "dao.php?id="+dashId, function(data) {
        //alert(data);
        var dashboardContent = JSON.parse(data);
        $("body").css("background-color", dashboardContent.backgroundColor);
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

  function create() {
    window.location = "dash.html";
  }

  function editCurrent() {
    var dashboardId = $("#dashboardId").val();
    window.location = "dashboard.php?id=" + dashboardId;
  }
  </script>
</head>
<body>
 <script src="//www.stathat.com/javascripts/embed.js"></script>
 <div id="menu">
  <img src="statdash.png" style="vertical-align:bottom"/>&nbsp;&nbsp;|&nbsp;&nbsp;
  <input id="dashboardId" name="dashboardId" type="text"/>
  <button onClick="switchDashboard()">Set</button>&nbsp;
  <button onClick="editCurrent()">Edit current</button>
  <button onClick="create()">Create</button>
  </div>
 <div id="dashboard"></div>
</body>
</html>
