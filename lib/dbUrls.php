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

class dbUrls extends db
{
	public function getLong($short)
	{
		$sql='SELECT long_url FROM urls WHERE short_url=:short';
		$params=array('short'=>$short);
		return $this->getFirst($sql,$params,0);
	}

	public function getShort($long)
	{
		$sql='SELECT short_url FROM urls WHERE long_url=:long';
		$params=array('long'=>$long);
		return $this->getFirst($sql,$params,0);
	}
	
	public function insertUrl($short,$long)
	{
		$sql='INSERT INTO urls (short_url,long_url) VALUES (:short,:long)';
		$params=array('short'=>$short,'long'=>$long);
                return $this->execute($sql,$params);
	}
	
	public function incReferrals($short)
	{
		$sql='UPDATE urls SET referrals=referrals+1 WHERE short_url=:short';
		$params=array('short'=>$short);
                return $this->execute($sql,$params);
	}

	public function getShortenedURLFromID($integer, $base = ALLOWED_CHARS)
	{
		$integer=(int) $integer;
		$out='';
		$length = strlen($base);
		while($integer > $length - 1)
		{
			$out = substr($base,fmod($integer, $length),1) . $out;
			$integer = floor( $integer / $length );
		}
		return substr($base,$integer,1) . $out;
	}

	public function getIDFromShortenedURL($string, $base = ALLOWED_CHARS)
	{
		$length = strlen($base);
		$size = strlen($string) - 1;
		$string = str_split($string);
		$out = strpos($base, array_pop($string));
		foreach($string as $i => $char)
		{
			$out += strpos($base, $char) * pow($length, $size - $i);
		}
		return $out;
	}

	public function getColumnHeaders()
	{
		$sql = 'DESC urls';
		return $this->getAll($sql, array(), 0);
	}

	public function getUrls()
	{
		$sql = 'SELECT * FROM urls';
		return $this->getAll($sql, array());
	}
}
