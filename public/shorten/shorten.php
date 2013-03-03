<?php
/*
 * Copyright 2013 Manuel Silvoso
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

require('../../config.php');

// input as get or post variables
if (isset($_REQUEST['longurl']))
{
	$long_url = trim($_REQUEST['longurl']);
}
else
{
	$long_url = '';
}
if (isset($_REQUEST['shorturl']))
{
	$short_url = trim($_REQUEST['shorturl']);
}
else
{
	$short_url = '';
}

if(empty($long_url)) 
{
	die('ERROR: No URL entered');
}

// protocol
if (!preg_match('|^https?://|', $long_url))
{
	$long_url='http://'.$long_url;
}

// check if the URL is valid
if(CHECK_URL)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $long_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if(!$response || substr($code,0,2) != '20')
	{
		die("ERROR: Not a valid URL - code $code");
	}
}

// check if the short url already exists
$urls=dbUrls::getInstance();
// a short URL has been entered
if (!empty($short_url))
{
	if (!preg_match('/^['.ALLOWED_CHARS.']+$/',$short_url))
	{
		die('ERROR: Please use only following characters: '.ALLOWED_CHARS);
	}
	$dblong=$urls->getLong($short_url);
	if (false===$dblong)
	{
		// the short url does not exist
		$urls->insertUrl($short_url,$long_url);
		die(WEBROOT . $short_url);
	}
	if ($long_url!=$dblong)
	{
		die('ERROR: Short URL already exists');
	}
	else
	{
		// this short url already exists and points to the same long url
		die(WEBROOT . $short_url);
	}
}
//check if the long url already exists
$short_url=$urls->getShort($long_url);
//create a new short url
if (!$short_url)
{
	$flags=dbFlags::getInstance();
	// create a new shorturl
	$id = $flags->incFlag('id');
	while($urls->getLong($urls->getShortenedURLFromID($id)))
	{
		$id=(int) $flags->incFlag('id');
	}
	$short_url=$urls->getShortenedURLFromID($id);
	$urls->insertUrl($short_url,$long_url);
}	
echo WEBROOT . $short_url;
