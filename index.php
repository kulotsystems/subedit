<!DOCTYPE html>
<html>
<head>
	<title>Subtitle Time (+/-)</title>
	<style>
		body, input
		{
			font-family:'Segoe UI',Arial,sans-serif;
		}
		
		.toggleMinus
		{
			margin:0px;
			border:1px solid #008900;
			border-top-left-radius:3px;
			border-bottom-left-radius:3px;
			background-color:#008900;
			color:white;
			cursor:pointer;
			width:48px;
			text-align:center;
		}
		.togglePlus
		{
			margin:0px;
			border:1px solid #008900;
			border-left:0px;
			border-top-right-radius:3px;
			border-bottom-right-radius:3px;
			background-color:white;
			color:#008900;
			cursor:pointer;
			width:48px;
			text-align:center;
		}
		
		.value
		{
			border:0px;
			border-bottom:1px solid #008900;
			margin:1px;
			width:54px;
			text-align:center;
			font-weight:bold;
		}
		
		span
		{
			background-color:yellow;
		}
	</style>
	
	<script>
		function toggle(e)
		{
			// "forward" or "delay"
			var operand=e.value;
			
			// determine the unit based from the name of e
			var unit=e.name.substr(6, 3);
			
			// oposite button
			var opbtn_name = (operand=="forward") ? "Min" : "Plus";
			opbtn=document.getElementById("toggle" + unit + opbtn_name);

			// color
			e.style.backgroundColor="green";
			e.style.color="white";
			opbtn.style.backgroundColor="white";
			opbtn.style.color="green";
			
			// write operation to be submitted (+/-)
			document.getElementById("operation_" + unit).value=operand;
			
			// select corresponding text box
			document.getElementById("txt" + unit + "_inc").select();
		}
		
		setInterval(function(){
			var allow = document.getElementById("allow_timer").value;
			if(allow)
			{

				var op_mil = document.getElementById("operation_Mil").value;
				var op_sec = document.getElementById("operation_Sec").value;
				var op_min = document.getElementById("operation_Min").value;

				var inc_mil = document.getElementById("txtMil_inc").value.trim();
				if(inc_mil=="") inc_mil="0";
				var inc_sec = document.getElementById("txtSec_inc").value.trim();
				if(inc_sec=="") inc_sec="0";
				var inc_min = document.getElementById("txtMin_inc").value.trim();
				if(inc_min=="") inc_min="0";
				
				var inc_mil = parseInt(inc_mil);
				var inc_sec = parseInt(inc_sec);
				var inc_min = parseInt(inc_min);
				
				var ctr_=document.getElementById("ctr").value;
				for(var i=1; i<=3; i++)
				{
					for(var j=1; j<=parseInt(ctr_); j++)
					{
						var span_mil = document.getElementById("mil" + i + "_" + j);
						var span_sec = document.getElementById("sec" + i + "_" + j);
						var span_min = document.getElementById("min" + i + "_" + j);
						var span_hr = document.getElementById("hr" + i + "_" + j);
						
						val_mil = parseInt(document.getElementById("txt_mil" + i + "_" + j).value);
						val_sec = parseInt(document.getElementById("txt_sec" + i + "_" + j).value);
						val_min = parseInt(document.getElementById("txt_min" + i + "_" + j).value);
						val_hr = parseInt(document.getElementById("txt_hr" + i + "_" + j).value);

						// start with milliseconds------------------------------------------------------------------------------------------------------------
						if(op_mil=="forward")
						{
							// plus mil
							val_mil += inc_mil;
							if(val_mil>999)
							{
								val_sec += parseInt(val_mil/1000);
								val_mil %= 1000;
								if(val_sec>59)
								{
									val_min += parseInt(val_sec/60);
									val_sec %= 60;
									if(val_min>59)
									{
										val_hr += parseInt(val_min/60)
										val_min %= 60;
									}
								}
							}
						}
						else
						{
							// minus mil
							val_mil -= inc_mil;
							
							if(val_mil<0)
							{
								var max = round((val_mil*-1), 1000);
								val_sec -= (max/1000);
								val_mil += max;
								if(val_sec<0)
								{
									max = round((val_sec*-1), 60);
									val_min -= (max/60);
									val_sec += max;
									if(val_min<0 && val_hr>0)
									{
										max = round((val_min*-1), 60);
										val_hr -= (max/60);
										val_min += max;
									}
								}
							}
						}
						
						// next is seconds---------------------------------------------------------------------------------------------------------------------
						if(op_sec=="forward")
						{
							// add seconds
							val_sec += inc_sec;
							if(val_sec>59)
							{
								val_min += parseInt(val_sec/60);
								val_sec %= 60;
								if(val_min>59)
								{
									val_hr += parseInt(val_min/60)
									val_min %= 60;
								}
							}
						}
						else
						{
							// minus seconds
							val_sec -= inc_sec;
							if(val_sec<0)
							{
								max = round((val_sec*-1), 60);
								val_min -= (max/60);
								val_sec += max;
								if(val_min<0 && val_hr>0)
								{
									max = round((val_min*-1), 60);
									val_hr -= (max/60);
									val_min += max;
								}
							}
						}
						
						// minutes now ------------------------------------------------------------------------------------------------------------------------
						if(op_min=="forward")
						{
							// add minutes
							val_min += inc_min;
							if(val_min>59)
							{
								val_hr += parseInt(val_min/60)
								val_min %= 60;
							}
						}
						else
						{
							// minus minutes
							val_min -= inc_min;
							if(val_min<0 && val_hr>0)
							{
								max = round((val_min*-1), 60);
								val_hr -= (max/60);
								val_min += max;
							}
						}
						// print values
						if(val_min<0)
						{
							val_min=0;
							val_sec=0;
							val_mil=0;
						}
						if(val_sec<0)
						{
							val_mil=0;
							val_sec=0;
						}
						span_mil.innerHTML = (val_mil<10) ? "0" + val_mil : val_mil;
						span_sec.innerHTML = (val_sec<10) ? "0" + val_sec : val_sec;
						span_min.innerHTML = (val_min<10) ? "0" + val_min: val_min;
						span_hr.innerHTML = (val_hr<10) ? "0" + val_hr : val_hr;
					}	
				}
			}
		
		}, 150);
		
		function round(n, mod)
		{
			while(true)
			{
				n++;
				if(n%mod==0)
					break;
			}
			return n;
		}

	</script>
</head>

<body>
    <center>
	<input type="hidden" id="allow_timer" value="false">
	<p>
		<small>
		Downloaded a subtitle but the timing is inconsistent?<br>
		This page could help you out..<br></br>
		
		Normally, subtitle <b>times</b> are written this way:<br>
		<big style="background-color:#ffffcc"><font face='Courier New'>00:01:02,123 --> 00:01:03,456</big><br>
		(hr:min:sec,mil)</font> - that is what we're going to edit here.
		</small>
	</p>

    <form name="frmSubtitle" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	<p>
        Now, where's the subtitle file?
        <input type="file" name="fSubTitle">
        <input type="submit" name="btnUpload" value="OK">
	</p>
	
	<?php
	$fname="last_script.txt";
	if(isset($_POST['btnUpload']))
	{
		$sub_file=$_FILES["fSubTitle"];
		if($sub_file["error"]>0)
			echo "Please select a subtitle file";
		else
		{
			// determine file datails
			$filename=$sub_file["name"];
			$filetype=$sub_file["type"];
			$filetemp=$sub_file["tmp_name"];
			$filesize=$sub_file["size"];
			
			// determine the file extension with the dot
			$ext="";
			for($i=strlen($filename)-1; $i>0; $i--)
			{
				$c=substr($filename, $i, 1);
				$ext = $c . $ext;
				if($c==".")
				{
					break;
				}
			}
			
			if(strtolower($ext)==".srt" || $filetype=="text/plain")
			{
				echo "<table>";
				echo "<tr><td>Preview</td></tr>";
				echo "<tr><td style='background-color:#ffffcc; font:12px Courier New, sans-serif'>";
			
				// get and display 3 sample conversations
				$fr=fopen($filetemp, "r");
				$ctr=0;
				while(!feof($fr))
				{
					$l=fgets($fr);
					if(istime($l))
					{
						$ctr++;
						// split the line into 2
						$t=explode("-->", $l);
						$t1=trim($t[0]);
						$t2=trim($t[1]);
					
						// get individual times on t1
						$t1_times = explode(":", $t1);
						$t1_hr = $t1_times[0];
						$t1_min = $t1_times[1];
						$t1_sec_mil = explode(",", $t1_times[2]);
						$t1_sec = $t1_sec_mil[0];
						$t1_mil = $t1_sec_mil[1];
					
						// print t1 times
						echo "<span id='hr1_$ctr'>$t1_hr</span>:";
						echo "<span id='min1_$ctr'>$t1_min</span>:";
						echo "<span id='sec1_$ctr'>$t1_sec</span>,";
						echo "<span id='mil1_$ctr'>$t1_mil</span>";
					
						echo "<input type='hidden' id='txt_hr1_$ctr' value='$t1_hr'>";
						echo "<input type='hidden' id='txt_min1_$ctr' value='$t1_min'>";
						echo "<input type='hidden' id='txt_sec1_$ctr' value='$t1_sec'>";
						echo "<input type='hidden' id='txt_mil1_$ctr' value='$t1_mil'>";
					
						echo " --> ";
					
						// get individual times on t2
						$t2_times = explode(":", $t2);
						$t2_hr = $t2_times[0];
						$t2_min = $t2_times[1];
						$t2_sec_mil = explode(",", $t2_times[2]);
						$t2_sec = $t2_sec_mil[0];
						$t2_mil = $t2_sec_mil[1];
					
						// print t2 times
						echo "<span id='hr2_$ctr'>$t2_hr</span>:";
						echo "<span id='min2_$ctr'>$t2_min</span>:";
						echo "<span id='sec2_$ctr'>$t2_sec</span>,";
						echo "<span id='mil2_$ctr'>$t2_mil</span>";
					
						echo "<input type='hidden' id='txt_hr2_$ctr' value='$t2_hr'>";
						echo "<input type='hidden' id='txt_min2_$ctr' value='$t2_min'>";
						echo "<input type='hidden' id='txt_sec2_$ctr' value='$t2_sec'>";
						echo "<input type='hidden' id='txt_mil2_$ctr' value='$t2_mil'>";
					}
					else
					{
						echo $l;
					}
					if($ctr==3 && trim($l)=="")
					{
						break;
					}
					echo "<br>";
				}
				echo ".<br>.<br>.";
				echo "<input type='hidden' id='ctr' value='$ctr'>";
				echo "</td></tr>";
				fclose($fr);
			
				echo "<script>document.getElementById('allow_timer').value='true';</script>";
				// read the lines to an array..
				$lines=file($filetemp);
					
				echo "<tr>";
				echo "<td>";
				echo "<input type='hidden' name='operation_Mil' id='operation_Mil' value='delay'>";
				echo "<input name='toggleMilMin' id='toggleMilMin' value='delay' class='toggleMinus' onclick='toggle(this)' readonly>";
				echo "<input name='toggleMilPlus' id='toggleMilPlus' value='forward' class='togglePlus' onclick='toggle(this)' readonly>";
				echo "<input type='number' name='txtMil_inc' id='txtMil_inc' min='0' max='999' class='value' value='0'>";
				echo "milliseconds";
				echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>";
				echo "<input type='hidden' name='operation_Sec' id='operation_Sec' value='delay'>";
				echo "<input name='toggleSecMin' id='toggleSecMin' value='delay' class='toggleMinus' onclick='toggle(this)' readonly>";
				echo "<input name='toggleSecPlus' id='toggleSecPlus' value='forward' class='togglePlus' onclick='toggle(this)' readonly>";
				echo "<input type='number' name='txtSec_inc' id='txtSec_inc' min='0' max='59' class='value' value='0'>";
				echo "seconds";
				echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>";
				echo "<input type='hidden' name='operation_Min' id='operation_Min' value='delay'>";
				echo "<input name='toggleMinMin' id='toggleMinMin' value='delay' class='toggleMinus' onclick='toggle(this)' readonly>";
				echo "<input name='toggleMinPlus' id='toggleMinPlus' value='forward' class='togglePlus' onclick='toggle(this)' readonly>";
				echo "<input type='number' name='txtMin_inc' id='txtMin_inc' min='0' max='59' class='value' value='0'>";
				echo "minutes";
				echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align='center' colspan='2'>";
				echo "<input type='submit' name='btnConfirm' value='Confirm' style='width:100%; height:100%'>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				
				// move file
				if(file_exists($fname))
				{
					unlink($fname);
				}
				move_uploaded_file($filetemp, $fname);
			}
			else
			{
				echo "($ext) file not accepted! Please select (.srt) or (.txt)<br><small style='color:red'>This script won't help you out if you select a non-subtitle file!</small>";
			}	
		}
	}
	if(isset($_POST['btnConfirm']))
	{
		$inc_mil = intval(trim($_POST['txtMil_inc']));
		$inc_sec = intval(trim($_POST['txtSec_inc']));
		$inc_min = intval(trim($_POST['txtMin_inc']));
		
		$op_mil = $_POST['operation_Mil'];
		$op_sec = $_POST['operation_Sec'];
		$op_min = $_POST['operation_Min'];
		
		if(file_exists($fname))
		{
			$newContent="";
			$fsub=fopen($fname, "r");
			while(!feof($fsub))
			{
				$l=fgets($fsub);
				if(istime($l))
				{
					$t=explode("-->", $l);
					for($i=0; $i<2; $i++)
					{
						// get individual times
						$times = explode(":", $t[$i]);
						$val_hr = intval($times[0]);
						$val_min = intval($times[1]);
						$sec_mil = explode(",", $times[2]);
						$val_sec = intval($sec_mil[0]);
						$val_mil = intval($sec_mil[1]);
						
						// increment milliseconds--------------------------------------------------------------------------------------------------------------
						if($op_mil=="forward")
						{
							// plus mil
							$val_mil += $inc_mil;
							if($val_mil>999)
							{
								$val_sec += intval($val_mil/1000);
								$val_mil %= 1000;
								if($val_sec>59)
								{
									$val_min += intval($val_sec/60);
									$val_sec %= 60;
									if($val_min>59)
									{
										$val_hr += intval($val_min/60);
										$val_min %= 60;
									}
								}
							}
						}
						else
						{
							// minus
							$val_mil -= $inc_mil;
							
							if($val_mil<0)
							{
								$max = iround(($val_mil*-1), 1000);
								$val_sec -= ($max/1000);
								$val_mil += $max;
								if($val_sec<0)
								{
									$max = iround(($val_sec*-1), 60);
									$val_min -= ($max/60);
									$val_sec += $max;
									if($val_min<0 && $val_hr>0)
									{
										$max = iround(($val_min*-1), 60);
										$val_hr -= ($max/60);
										$val_min += $max;
									}
								}
							}
						}
						
						// increment seconds-------------------------------------------------------------------------------------------------------------------
						if($op_sec=="forward")
						{
							// add seconds
							$val_sec += $inc_sec;
							if($val_sec>59)
							{
								$val_min += intval($val_sec/60);
								$val_sec %= 60;
								if($val_min>59)
								{
									$val_hr += intval($val_min/60);
									$val_min %= 60;
								}
							}
						}
						else
						{
							// minus seconds
							$val_sec -= $inc_sec;
							if($val_sec<0)
							{
								$max = iround(($val_sec*-1), 60);
								$val_min -= ($max/60);
								$val_sec += $max;
								if($val_min<0 && $val_hr>0)
								{
									$max = iround(($val_min*-1), 60);
									$val_hr -= ($max/60);
									$val_min += $max;
								}
							}
						}
						
						// increment minutes-------------------------------------------------------------------------------------------------------------------
						if($op_min=="forward")
						{
							// add minutes
							$val_min += $inc_min;
							if($val_min>59)
							{
								$val_hr += intval($val_min/60);
								$val_min %= 60;
							}
						}
						else
						{
							// minus minutes
							$val_min -= $inc_min;
							if($val_min<0 && $val_hr>0)
							{
								$max = iround(($val_min*-1), 60);
								$val_hr -= ($max/60);
								$val_min += $max;
							}
						}
						// print values
						if($val_min<0)
						{
							$val_min=0;
							$val_sec=0;
							$val_mil=0;
						}
						if($val_sec<0)
						{
							$val_mil=0;
							$val_sec=0;
						}
						
						if ($val_hr<10) $val_hr = "0".$val_hr;
						if ($val_min<10) $val_min = "0".$val_min;
						if ($val_sec<10) $val_sec = "0".$val_sec;
						if ($val_mil<10) $val_mil = "0".$val_mil;
						
						// put time back together
							$t[$i] = $val_hr . ":" . $val_min . ":" . $val_sec  . "," . $val_mil;	
					}
					// combine 2 times again back to line
					$l = $t[0] . " --> " . $t[1] . "\n";
				}
				$newContent = $newContent . $l;
			}
			fclose($fsub);
			echo "<span style='color:green; background-color:white;'>Okay, whether you edited it or not, here it is:</span><br>";
			echo "<textarea style='width:50%; background-color:#ffffcc; border:0px' rows='15'>$newContent</textarea><br>";
			echo "<div style='width:50%; text-align:right'><small><a href='http://www.facebook.com/asbabol' target='_blank'>~arv</a></small></div>";
		}
		else
		{
			echo "Oops.. error! Please try again!";
		}
	}
	
	function iround($n, $mod)
	{
		while(true)
		{
			$n++;
			if($n%$mod==0)
			{
				break;
			}
		}
		return $n;
	}
	
	function istime($l)
	{
		$r=false;
		for($i=0; $i<strlen($l); $i++)
		{
			$w=substr($l, $i, 3);
			if($w=="-->")
			{
				$r=true;
				break;
			}
		}
		return $r;
	}
?>
	</form>
	</center>
</body>
</html>
