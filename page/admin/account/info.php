<?php 
$level='../../../';
//1 database config
include $level.'config.php';
//2 neccessary library
include $level.'htinmotion/orm/adodb5/adodb.inc.php';
include $level.'htinmotion/orm/general/general.php';
include $level.'template/admin/tablepager.php';//pager html
include $level.'template/admin/tablerender.php';//pager html
//3 lay out
include $level.'template/admin/admin_head.php';
include $level.'template/admin/admin_header.php';
?>
     <script>
     </script>
     <div id="feedControl" style="width:100%">Welcome</div>
<?php 
//lay out
include $level.'template/admin/admin_sidebar.php';
include $level.'template/admin/admin_footer.php';
?>