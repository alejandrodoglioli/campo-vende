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
 
include("../../include/config.php");
include("../../include/lib.inc.php");

print("<html>\n");
print("<head>\n");
print("<title>$l_registertitle</title>\n");
print("</head>\n");
print("<body bgcolor=black text=silver link=#6666FF vlink=#FF00FF leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>\n");

if(isset($register_submit))
{
  if(strlen($register_login)>=2 && strlen($register_password)>2)
	{
	  mysql_query("insert into ".$tof_users." values('$register_login','$register_password',0,0,NULL)");
		print("$l_theuser <strong>$register_login</strong> $l_isregister\n");
	}
	else
		print("<strong>$l_fillfields</strong>\n");
}
else
{
  print("<form method=post action=register.php>\n");
  print("<strong>$l_register2</strong><br>\n");
  print("$l_adminlogin <input type=text name=register_login size=20 maxlength=20><br>\n");
  print("$l_adminpass <input type=password name=register_password size=20 maxlength=20><br>\n");
  print("<input type=submit name=register_submit value=\"$l_registersubmit\">&nbsp;\n");
  print("<input type=reset value=\"$l_registerclear\">\n");
  print("</form>\n");
}

include("../../album-fotos/footer.php");
?>
