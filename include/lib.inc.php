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

function timestamp2smalldate($time)
{
	global $l_at;
  $year=substr($time,0,4);
	$month=substr($time,4,2);
	$day=substr($time,6,2);
	$hour=substr($time,8,2);
	$minute=substr($time,10,2);
	$second=substr($time,12,2);

	$date="$day-$month-$year $l_at $hour:$minute:$second";
	return $date;
}

function printlogin($type)
{
	global $l_register;
  global $global_user_login,$global_user_password,$album_ID,$photo_ID;
	print("<table align=center cellspacing=0 border=0 cellpadding=2>\n");
	print("<form method=post action=$type.php>\n");
	print("<tr><td align=center valign=middle>\n");
	print("Login : <input type=text name=header_login value=\"$global_user_login\" size=10 maxlength=20>\n");
	print("&nbsp;Password : <input type=password name=header_password value=\"$global_user_password\" size=10 maxlength=20>\n");
	print("&nbsp;<input type=submit name=header_login_submit value=Go!>\n");
	print("&nbsp;<a href=register.php target=_blank><font size=2>$l_register</font></a>\n");
	print("<input type=hidden name=album_ID value=$album_ID>\n");
	print("<input type=hidden name=photo_ID value=$photo_ID>\n");
	print("</td></tr>\n");
	print("</form>\n");
	print("</table>\n");
}

function CreateThumb($filename,$album_path)
{
	$image = ImageCreateFromJPEG("albums/".$album_path."/".$filename);
	$width  = imagesx($image);
	$height = imagesy($image);
	$new_width  = 100;
	$new_height = ($new_width * $height) / $width ;
	$thumb = imagecreate($new_width,$new_height);
	imagecopyresampled($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
	imagejpeg($thumb,"albums/".$album_path."/thumb_".$filename);
	imagedestroy($image);
} 


function parse_string($str)
{
	$str=str_replace("<","&lt;",$str);
	$str=str_replace(">","&gt;",$str);
	$str=str_replace(":-)","<img src=gfx/smile.gif>",$str);
	$str=str_replace(":)","<img src=gfx/smile.gif>",$str);
	$str=str_replace(";)","<img src=gfx/oeil.gif>",$str);
	$str=str_replace(";-)","<img src=gfx/oeil.gif>",$str);
	$str=str_replace(":(","<img src=gfx/ouin.gif>",$str);
	$str=str_replace(":-(","<img src=gfx/ouin.gif>",$str);
	$str=str_replace(":D","<img src=gfx/dent.gif>",$str);
	$str=str_replace(":-D","<img src=gfx/dent.gif>",$str);
	$str=str_replace(":p","<img src=gfx/tongue.gif>",$str);
	$str=str_replace(":-p","<img src=gfx/tongue.gif>",$str);
	$str=str_replace(":P","<img src=gfx/tongue.gif>",$str);
	$str=str_replace(":-P","<img src=gfx/tongue.gif>",$str);
	$str=nl2br($str);
	return $str;
}

function check_user($login,$password,$user_ID)
{
	global $tof_users;
	$result=mysql_query("select ID from ".$tof_users." where nickname='$login' and password='$password'");
	if(mysql_num_rows($result))
	{
		$row=mysql_fetch_array($result);
		if($row[ID]==$user_ID)
		  return 1;
	}
  return 0;
}

function is_admin($login,$password)
{
	global $tof_users;
	$result=mysql_query("select ID from ".$tof_users." where nickname='$login' and password='$password' and is_admin=1");
	if(mysql_num_rows($result))
	{
		$row=mysql_fetch_array($result);
		return $row[ID];
	}
	return 0;
}


?>
