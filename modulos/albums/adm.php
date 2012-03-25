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
include("authadm.php");

print("<html>\n");
print("<head>\n");
print("<title>$l_admintitle</title>\n");
print("</head>\n");
print("<body bgcolor=black text=silver link=#6666FF vlink=#FF00FF leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>\n");
printlogin("adm");
print("<table align=center cellspacing=0 cellpadding=0 border=0>\n");
print("<tr><td align=center>\n");
print("[ <a href=adm.php?rub=addalbum>$l_addalbum</a> | <a href=adm.php?rub=addadmin>$l_addadmin</a> | <a href=adm.php?rub=listadmins>$l_listadmins</a> | <a href=adm.php?rub=listusers>$l_listusers</a> | <a href=adm.php?rub=status>$l_status</a> ]\n");
print("</td></tr>\n");
switch($rub)
{
  case "listadmins":
  {
    print("<tr><td align=center><br>\n");

    $result=mysql_query("select * from ".$tof_users." where is_admin=1");
    print("<table align=center cellspacing=0 cellpadding=2 border=1 bordercolor=#CCCCCC>\n");
    print("<tr><td colspan=3 align=center>\n");
    print("<strong>$l_adminlist</strong>\n");
    print("</td></tr>\n");
    print("<tr>\n");
    print("<td align=center>$l_adminlogin</td>\n");
    print("<td align=center>$l_nbcomments</td>\n");
    print("<td align=center>$l_action</td>\n");
    print("</tr>\n");
    while($row=mysql_fetch_array($result))
    {
      print("<tr>\n");
      print("<td align=center>$row[nickname]</td>\n");
      print("<td align=center>$row[nb_comments]</td>\n");
      print("<td align=center>[ <a href=adm.php?rub=admindelete&user_ID=$row[ID]>$l_deleteaction</a> | <a href=adm.php?rub=admin2user&user_ID=$row[ID]>$l_setasuser</a> ]</td>\n");
      print("</tr>\n");
    }
    print("</table>\n");

    print("</td></tr>\n");
    break;
  }
  case "admindelete":
  {
    if(isset($user_ID))
    {
      $result=mysql_query("select nickname from ".$tof_users." where ID='$user_ID'");
      if(mysql_num_rows($result))
      {
        $row=mysql_fetch_array($result);
        print("<form method=post action=adm.php>\n");
        print("<tr><td><br>\n");
        print("<center><strong>$l_confirmadmindelete <big>$row[nickname]</big> ?</strong><br>");
        print("<input type=submit value=$l_admindeletesubmit>\n");
        print("<input type=hidden name=user_ID value=$user_ID>\n");
        print("<input type=hidden name=rub value=admindeletesubmit>\n");
        print("</td></tr>\n");
        print("</form>\n");
      }
    }
    break;
  }
  case "admindeletesubmit":
  {
    if(isset($user_ID))
    {
      $result=mysql_query("select nickname from ".$tof_users." where ID='$user_ID'");
      if(mysql_num_rows($result))
      {
        $row=mysql_fetch_array($result);
        mysql_query("delete from ".$tof_users." where ID='$user_ID'");
        print("<tr><td align=center>\n");
        print("<strong>$l_theadmin $row[nickname] $l_isdelete</strong>\n");
        print("</td></tr>\n");
      }
    }
    break;
  }
  case "admin2user":
  {
    if(isset($user_ID))
    {
      $result=mysql_query("select nickname from ".$tof_users." where ID='$user_ID'");
      if(mysql_num_rows($result))
      {
        $row=mysql_fetch_array($result);
        mysql_query("update from ".$tof_users." set is_admin=0 where ID='$user_ID'");
        print("<tr><td align=center>\n");
        print("<strong>$l_theadmin $row[nickname] $l_isuser</strong>\n");
        print("</td></tr>\n");
      }
    }
    break;
  }
  case "listusers":
  {
    print("<tr><td align=center><br>\n");

    $result=mysql_query("select * from ".$tof_users." where is_admin=0");
    print("<table align=center cellspacing=0 cellpadding=2 border=1 bordercolor=#CCCCCC>\n");
    print("<tr><td colspan=3 align=center>\n");
    print("<strong>Liste des utilisateurs</strong>\n");
    print("</td></tr>\n");
    print("<tr>\n");
    print("<td align=center>$l_adminlogin</td>\n");
    print("<td align=center>$l_nbcomments</td>\n");
    print("<td align=center>$l_action</td>\n");
    print("</tr>\n");
    while($row=mysql_fetch_array($result))
    {
      print("<tr>\n");
      print("<td align=center>$row[nickname]</td>\n");
      print("<td align=center>$row[nb_comments]</td>\n");
      print("<td align=center>[ <a href=adm.php?rub=userdelete&user_ID=$row[ID]>$l_deleteaction</a> | <a href=adm.php?rub=user2admin&user_ID=$row[ID]>$l_setasadmin ]");
      print("</tr>\n");
    }
    print("</table>\n");

    print("</td></tr>\n");
    break;
  }
  case "userdelete":
  {
    if(isset($user_ID))
    {
      $result=mysql_query("select nickname from ".$tof_users." where ID='$user_ID'");
      if(mysql_num_rows($result))
      {
        $row=mysql_fetch_array($result);
        print("<form method=post action=adm.php>\n");
        print("<tr><td><br>\n");
        print("<center><strong>$l_confirmuserdelete <big>$row[nickname]</big> ?</strong><br>");
        print("<input type=submit value=$l_admindeletesubmit>\n");
        print("<input type=hidden name=user_ID value=$user_ID>\n");
        print("<input type=hidden name=rub value=userdeletesubmit>\n");
        print("</td></tr>\n");
        print("</form>\n");
      }
    }
    break;
  }
  case "userdeletesubmit":
  {
    if(isset($user_ID))
    {
      $result=mysql_query("select nickname from ".$tof_users." where ID='$user_ID'");
      if(mysql_num_rows($result))
      {
        $row=mysql_fetch_array($result);
        mysql_query("delete from ".$tof_users." where ID='$user_ID'");
        print("<tr><td align=center>\n");
        print("<strong>$l_theuser $row[nickname] $l_isdelete</strong>\n");
        print("</td></tr>\n");
      }
    }
    break;
  }
  case "user2admin":
  {
    if(isset($user_ID))
    {
      $result=mysql_query("select nickname from ".$tof_users." where ID='$user_ID'");
      if(mysql_num_rows($result))
      {
        $row=mysql_fetch_array($result);
        mysql_query("update from ".$tof_users." set is_admin=0 where ID='$user_ID'");
        print("<tr><td align=center>\n");
        print("<strong>$l_theuser $row[nickname] $l_isadmin</strong>\n");
        print("</td></tr>\n");
      }
    }
    break;
  }
  case "addadmin":
  {
    print("<form method=post action=adm.php>\n");
    print("<tr><td><br>\n");
    print("$l_adminlogin <input type=text name=login size=20 maxlength=20><br>\n");
    print("$l_adminpass <input type=password name=password size=20 maxlength=20><br>\n");
    print("<center><input type=submit name=submit value=$l_addsubmit> <input type=reset value=$l_installclear></center>\n");
    print("<input type=hidden name=rub value=addadmin_submit>\n");
    print("</td></tr>\n");
    print("</form>\n");
    break;
  }
  case "addadmin_submit":
  {
    print("<tr><td><br>\n");
    if(isset($global_user_login) && isset($global_user_password))
    {
      if(is_admin($global_user_login,$global_user_password))
      {
        if(strlen($login)>2 && strlen($password)>3)
        {
          mysql_query("insert into ".$tof_users." values('$login','$password',0,1,NULL)");
          print("$l_theadmin <strong>$login</strong> $l_iscreated");
        }
        else
          print("<strong>$l_fillfields</strong>\n");
      }
      else
        print("<strong>$l_loginincorrect</strong>\n");
    }
    else
      print("<strong>$l_fillfields</strong>\n");
    print("</td></tr>\n");
    break;
  }
  case "addalbum":
  {
    print("<form method=post action=adm.php>\n");
    print("<tr><td><br>\n");
    print("$l_firstalbumname <input type=text name=album_name size=30 maxlength=254><br>\n");
    print("$l_firstalbumdir <input type=text name=album_path size=30 maxlength=254><br>\n");
    print("<center><input type=submit name=submit value=$l_createsubmit> <input type=reset value=$l_installclear>\n");
    print("<input type=hidden name=rub value=addalbum_submit></center>\n");
    print("</td></tr>\n");
    print("</form>\n");
    break;
  }
  case "addalbum_submit":
  {
    print("<tr><td><br>\n");
    if(isset($global_user_login) && isset($global_user_password))
    {
      if(is_admin($global_user_login,$global_user_password))
      {
        if(strlen($album_name)>=2 && strlen($album_path)>=2)
        {
          mysql_query("insert into ".$tof_albums." values('$album_name','$album_path',0,0,0,NULL,NULL)");
          print("<strong>$l_thealbum $album_name $l_withdir $album_path $l_iscreated<strong>\n");
        }
        else
          print("<strong>$l_fillalbumfields</strong>\n");
      }
      else
        print("<strong>$l_loginincorrect</strong>\n");				
    }
    else
      print("<strong>$l_fillfields</strong>\n");
    print("</td></tr>\n");
    break;
  }
  case "status":
  {
    $result_albums=mysql_query("select count(*) as num from ".$tof_albums);
    $result_photos=mysql_query("select count(*) as num from ".$tof_index);
    $result_comments=mysql_query("select count(*) as num from ".$tof_comments);
    $result_users=mysql_query("select count(*) as num from ".$tof_users);
    $result_views=mysql_query("select nb_views from ".$tof_albums);
    $row_albums=mysql_fetch_array($result_albums);
    $row_photos=mysql_fetch_array($result_photos);
    $row_comments=mysql_fetch_array($result_comments);
    $row_users=mysql_fetch_array($result_users);

    $nb_views=0;
    while($row_views=mysql_fetch_array($result_views))
      $nb_views+=$row_views[nb_views];

    print("<tr><td align=center>\n");
    print("<br>\n");
    print("<table align=center cellspacing=0 cellpadding=2 border=1 bordercolor=#CCCCCC>\n");
    print("<tr>\n");
    print("<td>$l_albumnb </td>\n");
    print("<td align=center>$row_albums[num]</td>\n");
    print("</tr>\n");
    print("<tr>\n");
    print("<td>$l_photonb </td>\n");
    print("<td align=center>$row_photos[num]</td>\n");
    print("</tr>\n");
    print("<tr>\n");
    print("<td>$l_usernb </td>\n");
    print("<td align=center>$row_users[num]</td>\n");
    print("</tr>\n");
    print("<tr>\n");
    print("<td>$l_commentnb </td>\n");
    print("<td align=center>$row_comments[num]</td>\n");
    print("</tr>\n");
    print("<tr>\n");
    print("<td>$l_viewnb </td>\n");
    print("<td align=center>$nb_views</td>\n");
    print("</tr>\n");
    print("</table>\n");

    print("</td></tr>\n");
    break;
  }
  default:
  break;
}
?>
</table>
<?
include("../../album-fotos/footer.php");
?>
