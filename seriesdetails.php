<?php
	include("includes/header.php");
	include("connection.php");
	if(!isset($_SESSION['uid'])) {
	  	header("Location: index.php");
	  }
	if(isset($_GET['series'])) {
    $s = $_GET['series'];
		$q = "select * from playedMatches 
          left join (matches, series, leagueDetails) 
          on (playedMatches.matchId=matches.matchId and series.seriesId=playedMatches.seriesId and leagueDetails.leagueId=matches.leagueId) 
          where userId=".$_SESSION['uid']." and playedMatches.seriesId=$s 
          order by currentLength desc";
		$res = $mysqli->query($q);
		?>
    <table id="seriesDetails" class="table table-hover table-bordered table-condensed span12 text-center">
		<thead>
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Time</th>
          <th>League</th>
          <th>Home Team</th>
          <th>-</th>
          <th>Away Team</th>
          <th>Bet so far</th>
          <th>Bet</th>
          <th>Odds</th>
          <th>Income</th>
          <th>Profit</th>
          <th>Result</th>
          <th>Result</th>
        </tr>
      </thead>
      <tbody>


<?php
    $t = '';
    $btn = "add";
    $i = 1;
		while($row = $res->fetch_array()) {
      $t = $row['team'];
?>
<tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $row['matchDate']; ?></td>
          <td><?php echo substr($row['matchTime'], 0, -3); ?></td>
          <td><img src="img/<?=$row['country'] ?>.png"/> <?php echo $row['displayName']; ?></td>
          <td><?php 
              if ($row['team'] === $row['homeTeam']) {
                echo "<strong>".$row['homeTeam']." (".$row['currentLength'].")</strong>";
              } else {
                echo $row['homeTeam'];
              } 
          ?></td>
          <td>-</td>
          <td><?php 
            if ($row['team'] === $row['awayTeam']) {
                echo "<strong>".$row['awayTeam']." (".$row['currentLength'].")</strong>";
              } else {
                echo $row['awayTeam'];
              }
          ?></td>
          <td><?php
            $betSoFar = $row['betSoFar'];
            //$betSoFar = $mysqli->query("SELECT SUM(bet) FROM playedMatches left join matches on matches.matchId=playedMatches.matchId where userId=".$_SESSION['uid']." and seriesId=".$row['seriesId']." and matchDate<'".$row['matchDate']."'")->fetch_array()[0];
            if($betSoFar) {
              echo $betSoFar;
            } else {
              echo "0";
            }
          ?></td>
          <td><?php echo $row['bet']; ?></td>
          <td><?php echo $row['odds']; ?></td>
          <td><?php echo $row['income']; ?></td>
          <td><?php echo $row['profit']; ?></td>
          <td><?php echo $row['result']; ?></td>
          <td><?php echo $row['resultShort']; ?></td>
</tr>
<?php
    $i ++;
		}
    $c = $mysqli->query("SELECT COUNT(*) FROM hotTeams where team='$t' and userId=".$_SESSION['uid'])->fetch_array()[0];
    if ($c > 0) {
      $btn = 'remove';
    }
?>
      </tbody>
    </table>
<script type="text/javascript">
    $(document).ready(function() {
    /* Init DataTables */
    var oTable = $('#seriesDetails').dataTable({
          "iDisplayLength": 25,
          "bJQueryUI": true,
          "sPaginationType": "full_numbers",
          "sDom": '<"top" lf><"toolbar">Tirpti<"bottom"p><"clear">',
          "oTableTools": {
            "sSwfPath": "dt/media/swf/copy_csv_xls_pdf.swf"
          }
    });
        $("div.toolbar").html("<a href='toggleHotTeam.php?team=<?=$t?>&series=<?=$s?>' class='btn btn-xs btn-primary'><?=$btn?></a>");
        $("div.toolbar").addClass("text-center");

});
</script>
<?php
		}

?>