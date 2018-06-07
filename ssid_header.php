
    <a href = "../wifi_hotspot.php">
  
      <h3><img src="../images/logo_tilted_wite_100.png" height="20" width="20">
	  <?php if (isset($_SESSION['ssid'])) {echo ($_SESSION['ssid']);}
	        else{echo("no wifi network");}
	  ?>
	  </h3> 
    
    <a>
