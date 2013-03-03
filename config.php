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

// db
define('DB_ENGINE', 'mysql');
define('DB_NAME', 'urlshortener');
define('DB_USER', 'urlshortener');
define('DB_PASSWORD', 'urlshortener');
define('DB_HOST', 'localhost');

// webroot
define('WEBROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/');

// approot
define('APPROOT', dirname(__FILE__) . '/');

// check if URL exists first
define('CHECK_URL', FALSE);

// allowed chars for the short url
define('ALLOWED_CHARS','0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

// redirect header
define('REDIRECT_HEADER', 'HTTP/1.1 301 Moved Permanently');
//define('REDIRECT_HEADER', 'HTTP/1.1 302 Moved Temporarily');

// default web page to redirect to (if no valid code has been given)
define('DEFAULT_SITE','https://www.bee-secure.lu/');

// autoload
function __autoload($class_name) 
{
       require	APPROOT . 'lib/' .  $class_name . '.php';
}
