<?php
//8473 seriesId 
	session_start();
	include("connection.php");
	  ini_set('display_errors', 'on');

	if (isset($_GET['new'])) {
		$mysqli->query("insert into hotMatches (userId, odds, bet, betSoFar, income, profit) values (".$_SESSION['uid'].", 3, 0, 0, 0, 0)");
		echo $mysqli->error;
		header("Location: hotmatches.php");
	} else {
		$i = $_POST['column'];
		$val = $_POST['value'];
		$id = $_POST['row_id']; 
		if ($id == '') {
			$id = -1;
		}
		switch ($i) {
		    case 1:
		        $mysqli->query("UPDATE hotMatches set matchDate='$val' where userId=".$_SESSION['uid']." and matchId=$id");
		        break;
		    case 2:
		        $mysqli->query("UPDATE hotMatches set matchTime='$val' where userId=".$_SESSION['uid']." and matchId=$id");
		        break;
		    case 3:
		        $mysqli->query("UPDATE hotMatches set country='$val' where userId=".$_SESSION['uid']." and matchId=$id");
		        break;
		    case 4:
		        $mysqli->query("UPDATE hotMatches set homeTeam='$val' where userId=".$_SESSION['uid']." and matchId=$id");
		        break;
		    case 6:
		        $mysqli->query("UPDATE hotMatches set awayTeam='$val' where userId=".$_SESSION['uid']." and matchId=$id");
		        break;		    
		    case 7:
		        $mysqli->query("UPDATE hotMatches set type='$val' where userId=".$_SESSION['uid']." and matchId=$id");
		        break;
		    case 8:
		        $mysqli->query("UPDATE hotMatches set betSoFar='$val' where userId=".$_SESSION['uid']." and matchId=$id");
		        break;
		    case 9:
		    	$q1 = "update hotMatches set bet=$val, income=hotMatches.odds*$val, profit=hotMatches.odds*$val-(hotMatches.betSoFar+$val) where matchId=$id and userId=".$_SESSION['uid'];

		        $mysqli->query($q1);
		        break;
		    case 10:
				$mysqli->query("update hotMatches set odds=$val, income=hotMatches.bet*$val, profit=hotMatches.bet*$val-(hotMatches.betSoFar+hotMatches.bet) where matchId=$id and userId=".$_SESSION['uid']);
		        break;
		}
		$q3 = "SELECT * from hotMatches where userId=".$_SESSION['uid']." and matchId=$id";
		 // echo "$q3";
		$match = $mysqli->query($q3)->fetch_assoc();
		
		$return = $match['matchId']."#".$match['matchDate']."#".substr($match['matchTime'], 0, -3)."#<img src='img/".$match['country'].".png' title='".$match['country']."'/> ".$match['country']."#".$match['homeTeam']."#".$match['awayTeam']."#".$match['type']."#".$match['betSoFar']."#".$match['bet']."#".$match['odds']."#".$match['income']."#".$match['profit'];
		echo $return;
	}


?>