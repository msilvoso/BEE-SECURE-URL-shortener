<?php
require('../../config.php');

$separator = ';';

$urls=dbUrls::getInstance();

$columns = $urls->getColumnHeaders();

$output='"'.implode('"'.$separator.'"',$columns)."\"\n";

$list = $urls->getUrls();
foreach ($list as $record)
{       
	$line=array();
	foreach($columns as $column)
	{       
		$line[]=str_replace('"','""',utf8_decode($record[$column]));
	}
	$output.='"'.implode('"'.$separator.'"',$line)."\"\n";
}

header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Type: application/CSV");
header("Content-Disposition: attachment; filename=\"fulllist.csv\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".strlen($output));

echo $output;
exit(0);
