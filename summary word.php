
<!DOCTYPE html>
<html>
    <head>
        <title>summary word</title>

<style>
          table td, table th {
            
            vertical-align: top;
          }
          table th {
            text-align:left;
          }

          .t1 {
            border-collapse: collapse;
          }
          .t1font {
            font-size: 14px;
			font-family: 'Times New Roman';
          }
          
        </style>

        
    </head>
	
    <body>
<table class="t1 t1font">
          <thead>
            <tr>
                <th>Ref. No.
				</th><th>code
                </th><th>School Name (EN)
                </th><th>School Name (TC)
                </th><th>ECA (EN
                </th><th>ECA (TC)
                </th><th>IT Equ. 
                </th><th>Opr. Exp.
                </th><th>Total Budget
                </th><th>Submit DateTime
                </th><th>Submit Date
                </th><th>Additional File (Y/N)
                </th>
            </tr>
		</thead>
		<tbody>
<?php
//define('_PATH', dirname(__FILE__));
$path_root = 'C:\laragon\www/';
$path_src = $path_root . 'eform/';
//echo $path_src . '<br>';

foreach (new DirectoryIterator($path_src) as $file) {
  if($file->isDot()) continue;
  //print _PATH . '<br>';
  $fullfilename = $file->getPathname();
  $filename = $file->getFilename();
  //echo $filename . '<br>';
  $fileinfo = explode("_", $filename);
  $trnid = $fileinfo[0];
  $timeInfo = explode("-", $fileinfo[1]);
  $year=$timeInfo[0];
  $month=$timeInfo[1];
  $day=$timeInfo[2];
  $hrs=$timeInfo[3];
  $min=$timeInfo[4];
  
  $prs_path = $path_root . $trnid . '/';
  //echo $prs_path . '<br>';
  //$path_des = $path_root . 'file_des/' . $filename;

  // Get file extension
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  $valid_ext = array('zip');

  // Check extension
  if(in_array(strtolower($ext), $valid_ext)){
    if (!file_exists($prs_path)) {
      $zip = new ZipArchive;
      $res = $zip->open($fullfilename);
      if ($res === TRUE) {
      // Extract file
        $zip->extractTo($prs_path);
        $zip->close();

        $jsonpath = $prs_path . 'data/';;
		//echo $jsonpath;
		//echo $prs_path;
		$additionpath = $prs_path . 'attachment/';
		//echo $additionpath;
		if (file_exists($additionpath)) {
          $additionFile = 'Y';
        } else {
          $additionFile = 'N';
        }
		$string = file_get_contents($jsonpath.'data.json');
		$json_a = json_decode($string, true);
		//echo $json_a->schoolCode;
		
		
		echo '<tr>
                <th>'.$trnid.'
				</th><th>'.$json_a['schoolCode'].'               
                </th><th>'.$json_a['schoolNameChi'].'<br>'.$json_a['schoolNameEng'].'
				</th><th>/2022<br><br>Last Submission/ Clarification:<br>/2022
                </th><th>';
				$count=0;
				foreach ($json_a['listOfECA'] as $k ){
				/*echo '<ol>' ;*/
				$count=$count+1;
				echo $k['ecaNameEng'].'<br>'.$k['ecaNameChi'].'<br>(Short courses/training for '.$k['ecaNoofStudent'].'&nbsp;'.$k['ecaStudentDetails'].' students ( classes x  students in each  hours courses) from '.$k['ecaDateFromMonth'].$k['ecaDateFromYear'].'  to '.$k['ecaDateToMonth'].$k['ecaDateToYear'].')<br>';
				}
					echo '<br>The School will re-run the activity in order to make good use of the equipment.' ;
				echo 
				'</th>';
				
				
				$equ=0;
				foreach ($json_a['listOfItem']as $k ){
					$equ=$k['itemBudget']+$k['itemServFee']+$equ;
				}
				$op=0;
				foreach ($json_a['listOfOps']as $k ){
					$op=$k['opsBudget']+$op;
				}
				$total=$equ+$op;
        echo   '<th>$'.number_format($equ).' <br><br>Breakdown<br>All Activities

                </th><th>$'.number_format($op).'<br><br>Breakdown<br>';

			for ($x = 1; $x <= $count; $x++) {
			echo 'Professional Service ( class x  students x  hrs) (1hr@$1,500)<br>(activity '.$x.')<br>$<br><br>';
			}

                echo '</th><th>$'.number_format($total).'
                </th><th>$( students)</th><th>';
				
				for ($x = 1; $x <= $count; $x++) {
			echo 'In activity ('.$x.'), students will learn<br><br>';
				}
				echo 'The equipment to be procured are necessary and within our price range according to the provided specifications and past approved cases according to the provided specifications and past approved cases.(i.e. unit cost @~$140 - $160 in the past approved cases) <br><br>The cloud services subscriptions are necessary to the proposed activities and the price is reasonable according to the provided specifications.<br><br>Recommended for support</th><th>The first application (#169) budget as $751,810, (equipment: $417,400 + services: $334,410)<br><br>Acc. Total :$1,000,000<br>Equipment: $493,410; Services: $506,590
</th>';

}
            echo '</tr>';
		

	  
	  }
	}
  }


?>
</tbody>
</table>


    </body>
</html>