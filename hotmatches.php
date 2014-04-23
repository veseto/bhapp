<?php
  include("includes/header.php");
  include("connection.php");
  ini_set('display_errors', 'on');

  if(!isset($_SESSION['uid'])) {
    header("Location: index.php");
  }
  $q0 = "SELECT * FROM hotMatches where userId=".$_SESSION['uid'];
  $res = $mysqli->query($q0);
  // echo $q0;
?>
      <table class="table table-bordered table-condensed text-center noPaddingMargin" id="hot">
       <thead>
          <tr>
            <th><input type="hidden"></th>
            <th><input type="text" name="search_engine" class="search_init shortInput" placeholder="date"></th>
            <th><input type="text" name="search_engine" class="search_init shortInput" placeholder="time"></th>
            <th><input type="text" name="search_engine" class="search_init shortInput" placeholder="league"></th>
            <th><input type="text" name="search_engine" class="search_init" placeholder="home team"></th>
            <th><input type="hidden"></th>
            <th><input type="text" name="search_engine" class="search_init" placeholder="away team"></th>
            <th><input type="text" name="search_engine" class="search_init" placeholder="type"></th>
            <th><input type="hidden"></th>
            <th><input type="text" name="search_engine" class="search_init shortInput" placeholder="bet"></th>
            <th><input type="text" name="search_engine" class="search_init shortInput" placeholder="odds"></th>
            <th><input type="hidden"></th>
            <th><input type="hidden"></th>
            <th><input type="text" name="search_engine" class="search_init shortInput" placeholder="result"></th>
          </tr>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Time</th>
            <th>League</th>
            <th>Home Team</th>
            <th>-</th>
            <th>Away Team</th>
            <th>Type</th>
            <th>BSF</th>
            <th>Bet</th>
            <th>Odds</th>
            <th>Income</th>
            <th>Profit</th>
            <th>Result</th>
          </tr>
        </thead>
        <tbody>
        <?
          while ($row = $res->fetch_assoc()) {
            // print_r($row);
            ?>
          <tr id="<?php echo $row['matchId'];?>">
             <td><?php echo $row['matchId'];?></td>
             <td class='editable'><?php if ($row['matchId'] != -1) echo $row['matchDate'];?></td>
             <td class='editable'><?php if ($row['matchId'] != -1) echo substr($row['matchTime'], 0, -3);?></td>
             <td class='editable'><?php echo "<img src='img/".$row['country'].".png' title='".$row['country']."'/> ".$row['country']?></td>
             <td class='editable'><?php if ($row['matchId'] != -1) echo $row['homeTeam'];?></td>
             <td>-</td>
             <td class='editable'><?php if ($row['matchId'] != -1) echo $row['awayTeam'];?></td>
              <td class='editable'><?php echo $row['type'];?></td>
             <td class='editable'><?php echo $row['betSoFar'];?></td>
             <td class='editable'><?php echo $row['bet'];?></td>
             <td class='editable'><?php echo $row['odds'];?></td>
             <td><?php echo $row['income'];?></td>
             <td><?php echo $row['profit'];?></td>
             <td><?php if ($row['matchId'] != -1) echo $row['result'];?></td>
          </tr>
            <?php
          } 
        ?>
        </tbody>
      </table>
            <script>
            $(document).ready(function() {  
      /* Init DataTables */
        var oTable = $('#hot').dataTable({
              "iDisplayLength": 10,
              "bJQueryUI": true,
              "sPaginationType": "full_numbers",
              "sDom": '<"top" lf><"toolbar">irpti<"bottom"pT><"clear">',
              "oTableTools": {
                "sSwfPath": "dt/media/swf/copy_csv_xls_pdf.swf"
              }
      });
        $("div.toolbar").html("<a href='savehotmatches.php?new=true' class='btn btn-xs btn-primary'>add</a>");
        $("div.toolbar").addClass("text-center");
      
        /* Apply the jEditable handlers to the table */
        oTable.$('td.editable').editable( 'savehotmatches.php', {
            "callback": function( sValue, y ) {
               // alert(y[0]);
                var aPos = oTable.fnGetPosition( this );
                //var arr = sValue.split("#");
               // alert(sValue+ " " + aPos[0]+ " "+ aPos[1]);
                // oTable.fnUpdate( sValue, aPos[0], aPos[1]);
                var arr = sValue.split("#");  

                oTable.fnUpdate( arr[0], aPos[0], 0 );
                oTable.fnUpdate( arr[1], aPos[0], 1 );
                oTable.fnUpdate( arr[2], aPos[0], 2 );
                oTable.fnUpdate( arr[3], aPos[0], 3 );
                oTable.fnUpdate( arr[4], aPos[0], 4 );
                oTable.fnUpdate( arr[5], aPos[0], 6 );
                oTable.fnUpdate( arr[6], aPos[0], 7 );
                oTable.fnUpdate( arr[7], aPos[0], 8 );
                oTable.fnUpdate( arr[8], aPos[0], 9 );
                oTable.fnUpdate( arr[9], aPos[0], 10 );
                oTable.fnUpdate( arr[10], aPos[0], 11 );
                oTable.fnUpdate( arr[11], aPos[0], 12 );

                //oTable.fnClearTable();
                //oTable.fnReloadAjax() ;
            },
            "submitdata": function ( value, settings ) {
                return {
                    "row_id": this.parentNode.getAttribute('id'),
                    "column": oTable.fnGetPosition( this )[2]
                };
            },
            "height": "90%",
            "width": "90%"
        } );
    } );

  </script>

  <?php
  include("includes/footer.php");
  ?>