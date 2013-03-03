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

require '../config.php';

if(isset($_GET['url']) && !empty($_GET['url']))
{
	$urls=dbUrls::getInstance();
	if ($long_url=$urls->getLong($_GET['url']))
	{
		$urls->incReferrals($_GET['url']);
		header(REDIRECT_HEADER);
		header('Location: ' .  $long_url);
	}	
}
$flags=dbFlags::getInstance();
$flags->incFlag('default_site');
header(REDIRECT_HEADER);
header('Location: ' . DEFAULT_SITE );
