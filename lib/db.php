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

abstract class db
{
	private static $db=NULL;
	private static $instance=array();

	public function __construct($engine=DB_ENGINE,$host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$name=DB_NAME)
	{
		if (NULL===db::$db)
		{
			db::$db=new PDO("$engine:host=$host;dbname=$name;","$user","$password");
		}
	}

	public function getDB()
	{
		return db::$db;
	}

	public static function getInstance($engine=DB_ENGINE,$host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$name=DB_NAME)
	{
		$class = get_called_class();
		if (!isset(self::$instance[$class]))
		{
			self::$instance[$class]=new $class($engine,$host,$user,$password,$name);
		}
		return self::$instance[$class];
	}

	public function getFirst($sql,$params,$column=false)
	{
		$stmt=$this->getDB()->prepare($sql);
                if ($stmt->execute($params))
                {
                        if ($result=$stmt->fetch())
                        {
				$stmt->closeCursor();
				if (false===$column)
				{
                                	return $result;
				}
				else
				{
					return $result[(int)$column];
				}
                        }
                }
                $stmt->closeCursor();
                return false;
	}

	public function execute($sql,$params)
	{
		$stmt=$this->getDB()->prepare($sql);
                $res=$stmt->execute($params);
                $stmt->closeCursor();
                return $res;
	}

}
