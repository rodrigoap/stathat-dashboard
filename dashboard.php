<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>StatHat Dashboard</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="style.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="dash.js"></script>
  <script>
    var dashId = '<?php echo $_GET['id'];?>';

    $(function() {
      switchDashboard(dashId);
      $("#evt_color").change(function() {
              $("body").css("background-color", $(this).val());
      });
    });

  </script>
</head>
<body>
 <script src="//www.stathat.com/javascripts/embed.js"></script>
 <div id="menu">
   <img src="statdash.png" style="vertical-align:bottom"/>&nbsp;&nbsp;|&nbsp;&nbsp;
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
   <select id="evt_color">
     <option value="#FFFFFF">White</option>
     <option value="#000000">Black</option>
     <option value="#3366CC">Blue</option>
     <option value="#E070D6">Fuchsia</option>
     <option value="#808080">Gray</option>
     <option value="#4bb64f">Green</option>
     <option value="#ed9d2b">Orange</option>
     <option value="#FF9CB3">Pink</option>
     <option value="#EA4A4A">Red</option>
   </select>
   <button onClick="add()">Add</button>
   <button onClick="update()">Save</button>
   <button onClick="done(dashId)">Done</button>
 </div>
 <div id="dashboard"></div>
</body>
</html>
