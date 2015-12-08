<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>StatHat Dashboard</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="vex.css">
  <link rel="stylesheet" href="vex-theme-default.css">
  <link rel="stylesheet" href="tip-twitter.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="jquery.poshytip.min.js"></script>
  <script src="vex.js"></script>
  <script src="vex.dialog.js"></script>
  <script src="dash.js"></script>
  <script>
    var aDash = new StatDash();
    vex.defaultOptions.className = 'vex-theme-default';
    $(function() {
      $('#createNewDashboard').poshytip({
        className:'tip-twitter',
      	alignTo: 'target',
      	alignX: 'center',
      	offsetY: 5,
      	allowTipHover: false,
      	fade: true,
      	slide: false
      });
      $('#createNewDashboard').poshytip('show');
      $('#createNewDashboard').poshytip('hideDelayed', 5000);
      <?php
          if (isset($_GET['id'])) {
            $id = preg_replace("/[^a-zA-Z0-9]+/", "", substr($_GET["id"], 0, 5));
            echo "$('#dashboardId').val('" . $id . "');";
            echo "aDash.switchDashboard('" . $id . "');";
            echo "$('#editCurrent').removeAttr('disabled');";
          }
       ?>
    });
  </script>
</head>
<body>
  <?php include_once("analyticstracking.php") ?>
 <script src="//www.stathat.com/javascripts/embed.js"></script>
 <div id="menu">
  <img src="statdash.png" style="vertical-align:bottom"/>&nbsp;&nbsp;|&nbsp;&nbsp;
  <input id="dashboardId" name="dashboardId" type="text" value="Dashboard id"/>
  <button onClick="aDash.switchDashboardOld()">Load</button>&nbsp;
  <button id="editCurrent" onClick="aDash.editCurrent()" disabled="true">Edit current</button>
  <button id="createNewDashboard" onClick="aDash.create()" title="Start here...">Create dashboard</button>
  </div>
 <div id="dashboard"></div>
</body>
</html>
