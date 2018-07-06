<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_unit.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$floor_no = '';
$unit_no = '';
$type = '';
$status = '';
$branch_id = '';
$title = $_data['add_new_unit'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['add_unit_successfully'];
$form_url = WEB_URL . "unit/addunit.php";
$id="";
$hdnid="0";

if(isset($_POST['ddlFloor'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
		$sql = "INSERT INTO `tbl_add_unit`(floor_no,unit_no,branch_id,type) values('$_POST[ddlFloor]','$_POST[txtUnit]','" . $_SESSION['objLogin']['branch_id'] . "','$_POST[txtType]')";
		mysql_query($sql,$link);
		mysql_close($link);
		$url = WEB_URL . 'unit/unitlist.php?m=add';
		header("Location: $url");
	}
	else{
		$sql = "UPDATE `tbl_add_unit` SET `floor_no`='".$_POST['ddlFloor']."',`unit_no`='".$_POST['txtUnit']."',`type`='".$_POST['txtType']."' WHERE uid='".$_GET['id']."'";
		mysql_query($sql,$link);
		mysql_close($link);
		$url = WEB_URL . 'unit/unitlist.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysql_query("SELECT * FROM tbl_add_unit where uid = '" . $_GET['id'] . "'",$link);
	while($row = mysql_fetch_array($result)){
		$floor_no = $row['floor_no'];
		$unit_no = $row['unit_no'];
		$type = $row['type'];
		$status = $row['status'];
		$hdnid = $_GET['id'];
		$title = 'Update Floor';
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_unit_successfully'];
		$form_url = WEB_URL . "unit/addunit.php?id=".$_GET['id'];
	}
}
if(isset($_GET['mode']) && $_GET['mode'] == 'view'){
	$title = 'View Unit Details';
}	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo 'Add House';?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo 'House Information';?></li>
    <li class="active"><?php echo 'Add House';?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>unit/unitlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo 'House Entry';?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
				<div class="form-group">
            <label for="ddlFloor"><?php echo $_data['add_new_form_field_text_1'];?> :</label>
            <select name="ddlFloor" id="ddlFloor" class="form-control" style="width:180px !important">
              <option value="">--<?php echo  $_data['add_new_form_field_text_1'];?>--</option>
              <?php 
				  	$result = mysql_query("SELECT * FROM tbl_add_floor Where branch_id=".$_SESSION['objLogin']['branch_id'],$link);
				  	while($row = mysql_fetch_array($result)){?>
              <option <?php if($floor_no == $row['fid']){echo 'selected';}?> value="<?php echo $row['fid'];?>"><?php echo $row['floor_no'];?></option>
              <?php } ?>
            </select>
          </div>
					<div class="form-group">
            <label for="txtUnit"><?php echo $_data['add_new_form_field_text_2'] ;?> :</label>
            <div class="input-group">
              <input type="text" name="txtUnit" value="<?php echo $unit_no;?>" id="txtUnit" class="form-control" />
            </div>
          </div>
					<div class="form-group">
            <label for="txtType"><?php echo "House Type";?> :</label>
            <select name="txtType" id="txtType" class="form-control" style="width:180px !important">
              <option value="">--<?php echo "House Type";?>--</option>
              <option <?php if($type == "Bed Sitter"){echo 'selected';}?> value="Bed Sitter">Bed Sitter</option>
							<option <?php if($type == "One Bedroom"){echo 'selected';}?> value="One Bedroom">One Bedroom</option>
							<option <?php if($type == "Two Bedroom"){echo 'selected';}?> value="Two Bedroom">Two Bedroom</option>
							<option <?php if($type == "Three Bedroom"){echo 'selected';}?> value="Three Bedroom">Two Bedroom</option>
            </select>
          </div>
					<!-- <div class="form-group">
            <label for="txtStatus"><?php echo "Status";?> :</label>
            <select name="txtStatus" id="txtStatus" class="form-control" style="width:180px !important">
						  <option value="">--<?php echo "Status";?>--</option>
              <option <?php if($status == 1){echo 'selected';}?> value="1">Occupied</option>
							<option <?php if($status == 0){echo 'selected';}?> value="0">Unoccupied</option>
            </select>
          </div> -->
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $button_text; ?>"/>
          </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#ddlFloor").val() == ''){
		alert("Select Floor !!!");
		$("#ddlFloor").focus();
		return false;
	}
	else if($("#txtUnit").val() == ''){
		alert("Unit Required !!!");
		$("#txtUnit").focus();
		return false;
	}
	else if($("#txtType").val() == ''){
		alert("House Type Required !!!");
		$("#txtType").focus();
		return false;
	}
	else if($("#txtStatus").val() == ''){
		alert("Status Required !!!");
		$("#txtStatus").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
