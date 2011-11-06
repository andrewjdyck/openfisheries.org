<?php

include "common.php";

///////////////////////////////////
// 
//      MySQL functions
//
///////////////////////////////////
//-------------------------ConnectToDatabase BEGINS---------------------------
//This function makes the connection and returns the link id
function ConnectToDatabase(){
	global $DBHost,$DBName,$DBUser,$DBPass,$link;
	#connect to the server	 
	if (!($link=mysql_pconnect("$DBHost","$DBUser","$DBPass"))){
	   $ErrMsg=" database connection error: " .mysql_errno() . " " 
	   . mysql_error();
	   DisplayErrMsg($ErrMsg);
	   return 0;
	 }#end of if
	   
	#select the database
	if(!(mysql_select_db($DBName,$link))){
	   $ErrMsg="Error in selecting $DBName database: " 
	   . mysql_errno() . " " 
	   . mysql_error();
	   DisplayErrMsg($ErrMsg);
	   exit();
	}#end of database select if*/
}//end of ConnectToDatabase
//------------------------------ConnectToDatabase ENDS------------------------

#-----------------------------------DisplayErrMsg BEGINS-----------------------------------
function DisplayErrMsg($ErrMsg){
	print("<blockquote>
		      <blockquote>
			<blockquote>
			 <H3><font color=\"#cc0000\">$ErrMsg</font></H3>
			</blockquote>
		     </blockquote>
		 </blockquote>"
		 );
}#end of DisplayErrMsg
#-----------------------------------DisplayErrMsg ENDS-------------------------------------

#--------------------------------Query BEGINS-----------------
function Query($query){
	global $link;
	if(!($result=mysql_query($query,$link))){
	  $ErrMsg="Bad query to 
	  database $DBName: Error Number "
	  . mysql_errno() . "<br>" 
	   . mysql_error();
	   DisplayErrMsg($ErrMsg);
	   exit;
	}//end of query test
	return $result;
}//end query function
#--------------------------------Query ENDS------------------


# CloseDatabase() closes the connection to the current database
function CloseDatabase() {
  global $link;

  if (!(mysql_close($link))){
    $ErrMsg=" database close error: " 
      .mysql_errno() . " " 
      . mysql_error();
    DisplayErrMsg($ErrMsg);
    return 0;
  }
}






////////////////////////////////////////////
// The following are functions for the API
////////////////////////////////////////////
function getTimeSeries($query) {
    ConnectToDatabase();
	$result = Query($query);
	CloseDatabase();
	$arResult = array();
    while(list($year,$catch) = mysql_fetch_row($result))
	{
		$arResult["$year"] = floatval($catch);
    }
    return $arResult;
}


// checks an api key
function check_api($key, $api_keys) {
	if (!empty($key) && in_array($key, $api_keys)) {
		$result = TRUE;
	} else {
		$result = FALSE;
	}
	return $result;
}

// checks if the format param is set and
// if so, whether it's in the list of allowable formats
// finally, the $format variable is set to json default if necessary
function checkOutputFormat($format) {
	//$formats = Array('json', 'tsv', 'csv', 'd3json');
	$formats = Array('json', 'd3json');
	if (!empty($format) && in_array($format, $formats)) {
		$result['error'] = FALSE;
		$result['format'] = $format;
	} else if (empty($format)) {
		$result['error'] = FALSE;
		$result['format'] = 'd3json';
	} else {
		$result['error'] = TRUE;
	}
	return $result;
}

function create_query($apiParams) {
	$query = 
		"SELECT year, Sum(catch) as catch
		FROM capture";
	if (!empty($apiParams)) {
		$whereParams = array('iso3c', 'a3_code', 'inland');
		foreach($_GET as $key => $value) {
			if (in_array($key, $whereParams))  {
				$arWhere[] = "($key = '$value')";
			}
		}
		if (isset($arWhere)) {
			$query .= " WHERE " . implode(' AND ', $arWhere);
		}
	}
	$query .= " GROUP BY year ORDER BY year";
	return $query;
}

function output_data($format, $_GET) {
	$apiParams = $_GET;
	unset($apiParams['api_key']);
	unset($apiParams['format']);
	if ($format == 'json') {
		print protovisJSON(getTimeSeries(create_query($apiParams)));
	} elseif ($format == 'tsv') {
		getTSV();
	} elseif ($format == 'd3json') {
		print d3JSON(getTimeSeries(create_query($apiParams)));
	}
}

/////////////////////////
// DATA OUTPUT FORMATS //
/////////////////////////

// a function to prepare JSON for protovis line graph
function protovisJSON($timeseries) {
	$arJson = array();
	$strReturn = "[";
	foreach ($timeseries as $key => $value) {
		$strReturn .= "{x: $key, y: $value},";
	}
	$strReturn .= "]";
	return $strReturn;
} 

// a function to prepare JSON for d3 line graphs
function d3JSON($timeseries) {
	$years = Array();
	$data = Array();
	foreach($timeseries as $key => $value) {
		$years[] = $key;
		$data[] = $value;
	}
	return json_encode(Array('years'=>$years, 'data'=>$data));
}

// outputs tab separated values
function getTSV() {
	$query = 
	"SELECT year, Sum(catch) as catch
    FROM capture
	GROUP BY year
    ORDER BY year";
    $result = Query($query);
	$strResult = "";
    
	$fields = mysql_num_fields($result);
	for ( $i = 0; $i < $fields; $i++ ) {
		$strResult .= mysql_field_name($result, $i) . "\t";
	}
	header("Content-type:text/octect-stream");
    header("Content-Disposition:attachment;filename=data.tsv");
	
	$strResult .= "\n";
	while($row = mysql_fetch_row($result)) {
		$strResult .= implode("\t", $row) . "\n";
	}
    // return $strResult;
	print $strResult;
	exit;
}

?>
