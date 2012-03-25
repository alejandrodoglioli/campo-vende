<?
/*
	 Atomic Photo Album
	 Copyright (C) 2001 Constantin Charissis

	 This program is free software; you can redistribute it and/or
	 modify it under the terms of the GNU General Public License
	 as published by the Free Software Foundation; either version 2
	 of the License, or (at your option) any later version.

	 This program is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 GNU General Public License for more details.

	 You should have received a copy of the GNU General Public License
	 along with this program; if not, write to the Free Software
	 Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

 */

if(isset($header_login_submit))
{
  if(isset($header_login) && isset($header_password))
	{
	  if(strlen($header_login)<=2 || strlen($header_password)<=2)
		{
		}
		else
		{
			$result=mysql_query("select ID from ".$tof_users." where nickname='$header_login' and password='$header_password' and is_admin=1");
			if(mysql_num_rows($result)==1)
			{
			  $row=mysql_fetch_array($result);
				$global_user_ID=$row[ID];
				$global_user_login=$header_login;
				$global_user_password=$header_password;
				if(isset($cookie_admin_login))
				{
				  setcookie("cookie_admin_login");
					setcookie("cookie_admin_login",$header_login,time()+977616000);
				}
				else
					setcookie("cookie_admin_login",$header_login,time()+977616000);
				if(isset($cookie_admin_password))
				{
				  setcookie("cookie_admin_password");
					setcookie("cookie_admin_password",$header_password,time()+977616000);
				}
				else
					setcookie("cookie_admin_password",$header_password,time()+977616000);
			}
		}
	}
}
else
{
  if(isset($cookie_admin_login))
	  $global_user_login=$cookie_admin_login;
	if(isset($cookie_admin_password))
	  $global_user_password=$cookie_admin_password;
}

?>
