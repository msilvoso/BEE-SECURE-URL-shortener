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

class dbFlags extends db
{
	public function getFlag($flag)
	{
		$sql=('SELECT value FROM flags WHERE flag=:flag');
		$params=array('flag'=>$flag);
		return $this->getFirst($sql,$params,0);
	}

	public function setFlag($flag,$value='1')
	{
		if ($this->getFlag($flag))
		{
			$sql='UPDATE flags SET value=:value WHERE flag=:flag';
		}
		else
		{
			$sql='INSERT INTO flags VALUES (:flag,:value)';
		}
		$params=array('value'=>$value,'flag'=>$flag);
		return $this->execute($sql,$params);
	}

	public function incFlag($flag)
	{
		$value=$this->getFlag($flag);
		if ($value!==false) 
		{ 
			$value=(int) $value;
			$value++;
			$sql='UPDATE flags SET value=:value WHERE flag=:flag';
			$params=array('value'=>$value.'','flag'=>$flag);
			$this->execute($sql,$params);
			return $value;
		}
		$this->setFlag($flag);
		return '1';
	}
}
