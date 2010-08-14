<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Collect | Alpha</title>
<style type="text/css">
    body {
	margin:0;
	padding:0;
	font: bold 11px/1.5em Verdana;
}

h2 {
	font: bold 14px Verdana, Arial, Helvetica, sans-serif;
	color: #000;
	margin: 0px;
	padding: 0px 0px 0px 15px;
}
 
/*- Menu Tabs--------------------------- */ 


    #tabs {
      float:left;
      width:100%;
      background:#BBD9EE;
      font-size:93%;
      line-height:normal;
      }
    #tabs ul {
	margin:0;
	padding:10px 10px 0 50px;
	list-style:none;
      }
    #tabs li {
      display:inline;
      margin:0;
      padding:0;
      }
    #tabs a {
      float:left;
      background:url("tableft.gif") no-repeat left top;
      margin:0;
      padding:0 0 0 4px;
      text-decoration:none;
      }
    #tabs a span {
      float:left;
      display:block;
      background:url("tabright.gif") no-repeat right top;
      padding:5px 15px 4px 6px;
      color:#666;
      }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabs a span {float:none;}
    /* End IE5-Mac hack */
    #tabs a:hover span {
      color:#FF9834;
      }
    #tabs a:hover {
      background-position:0% -42px;
      }
    #tabs a:hover span {
      background-position:100% -42px;
      }
 {float:none;}
    /* End IE5-Mac hack */
    #tabsI a:hover span {
      color:#FFF;
      }
    #tabsI a:hover {
      background-position:0% -42px;
      }
    #tabsI a:hover span {
      background-position:100% -42px;
      }


/*- Menu Tabs J--------------------------- */

    #tabsJ {
      float:left;
      width:100%;
      background:#F4F4F4;
      font-size:93%;
      line-height:normal;
	  border-bottom:1px solid #24618E;
      }
    #tabsJ ul {
	margin:0;
	padding:10px 10px 0 50px;
	list-style:none;
      }
    #tabsJ li {
      display:inline;
      margin:0;
      padding:0;
      }
    #tabsJ a {
      float:left;
      background:url("tableftJ.gif") no-repeat left top;
      margin:0;
      padding:0 0 0 5px;
      text-decoration:none;
      }
    #tabsJ a span {
      float:left;
      display:block;
      background:url("tabrightJ.gif") no-repeat right top;
      padding:5px 15px 4px 6px;
      color:#24618E;
      }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabsJ a span {float:none;}
    /* End IE5-Mac hack */
    #tabsJ a:hover span, #tabsJ a.selected span {
      color:#FFF;
      }
    #tabsJ a:hover, #tabsJ a.selected {
      background-position:0% -42px;
      }
    #tabsJ a:hover span, #tabsJ a.selected span{
      background-position:100% -42px;
      }
    

</style>
</head>
<body>

<br>
<table>
  <form action="menus.php" method="get" target="_parent" >
  <tr>
  <td>
  
<img src="res/logo.jpg" width=60 height=49 />
	</td>
	   <td>
	   <input  name="q" type="text" size=50 />
	   </td>
	   <td>
	   <input style="width:100px" type="submit"  value="Collect" width="5px" />
	   </td>
	   </tr>
	   </table>
	   </table>

<div id="tabsJ">
  <?php 
$q=$_GET["q"];
echo '
<ul>
    <li><a href="content.php?q='.$q.'" target="1" class="selected" title="Overview"><span>Overture</span></a></li>   
    <li><a href="scollect.php?q='.$q.'" target="1" title="Social Collect"><span>Social Collect</span></a></li>
    <li><a href="wcollect.php?q='.$q.'" target="1" title="Web Collect"><span>Web Collect</span></a></li>
    <li><a href="ysearch-placemark.php?q='.$q.'" target="1" title="News Hotspot"><span>News Hotspot</span></a></li>   
  </ul>
  </div>
<br /><br />
<iframe src ="content.php?q='.$q.'" name="1" id="1" width="1325" height="600"></iframe>

';

?>

</div>

</body>
</html>