<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_fare.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$type = 'Rented';
$floor_no = '';
$unit_no = '';
$month_id = '';
$xyear = date('Y');
$rent = '0.00';
$water_bill = '0.00';
$electric_bill = '0.00';
$gas_bill = '0.00';
$security_bill = '0.00';
$utility_bill = '0.00';
$other_bill = '0.00';
$total_rent = '0.00';
$issue_date = '';
$branch_id = '';
$title = $_data['add_new_rent'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_rent_successfully'];
$form_url = WEB_URL . "fair/addfair.php";
$id="";
$hdnid="0";

//new
$reneted_name = '';
$rid = 0;

if(isset($_POST['txtRent'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	$trent = $_POST['txtRent'] + $_POST['txtWaterBill'] + $_POST['txtElectricBill'] + $_POST['txtGasBill'] + $_POST['txtSecurityBill'] + $_POST['txtUtilityBill'] + $_POST['txtOtherBill'];
	$sql = "INSERT INTO tbl_add_fair(type,floor_no,unit_no,rid,month_id,xyear,rent,water_bill,electric_bill,gas_bill,security_bill,utility_bill,other_bill,total_rent,issue_date,branch_id) values('$type','$_POST[ddlFloorNo]','$_POST[ddlUnitNo]','$_POST[hdnRentedId]','$_POST[ddlMonth]','$xyear','$_POST[txtRent]','$_POST[txtWaterBill]','$_POST[txtElectricBill]','$_POST[txtGasBill]','$_POST[txtSecurityBill]','$_POST[txtUtilityBill]','$_POST[txtOtherBill]','$trent','$_POST[txtIssueDate]','" . $_SESSION['objLogin']['branch_id'] . "')";
	mysql_query($sql,$link);
	mysql_close($link);
	$url = WEB_URL . 'fair/fairlist.php?m=add';
	header("Location: $url");
}
else{
	$trent = $_POST['txtRent'] + $_POST['txtWaterBill'] + $_POST['txtElectricBill'] + $_POST['txtGasBill'] + $_POST['txtSecurityBill'] + $_POST['txtUtilityBill'] + $_POST['txtOtherBill'];
	$sql = "UPDATE `tbl_add_fair` SET `floor_no`='".$_POST['ddlFloorNo']."',`unit_no`='".$_POST['ddlUnitNo']."',`rid`='".$_POST['hdnRentedId']."',`month_id`='".$_POST['ddlMonth']."',`xyear`='".$xyear."',`rent`='".$_POST['txtRent']."',`water_bill`='".$_POST['txtWaterBill']."',`electric_bill`='".$_POST['txtElectricBill']."',`gas_bill`='".$_POST['txtGasBill']."',`security_bill`='".$_POST['txtSecurityBill']."',`utility_bill`='".$_POST['txtUtilityBill']."',`other_bill`='".$_POST['txtOtherBill']."',`total_rent`='".$trent."',`issue_date`='".$_POST['txtIssueDate']."' WHERE f_id='".$_GET['id']."'";
	mysql_query($sql,$link);
	$url = WEB_URL . 'fair/fairlist.php?m=up';
	header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysql_query("SELECT *,r.r_name,r.rid FROM tbl_add_fair af inner join tbl_add_rent r on r.rid = af.rid where af.f_id = '" . $_GET['id'] . "' and af.type='Rented'",$link);
	while($row = mysql_fetch_array($result)){
		
		$floor_no = $row['floor_no'];
		$unit_no = $row['unit_no'];
		$month_id = $row['month_id'];
		$rent = $row['rent'];
		$water_bill = $row['water_bill'];
		$electric_bill = $row['electric_bill'];
		$gas_bill = $row['gas_bill'];
		$security_bill = $row['security_bill'];
		$utility_bill = $row['utility_bill'];
		$other_bill = $row['other_bill'];
		$total_rent = $row['total_rent'];
		$issue_date = $row['issue_date'];
		$hdnid = $_GET['id'];
		$reneted_name = $row['r_name'];
		$rid = $row['rid'];
		$title = $_data['update_rent'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_rent_successfully'];
		$form_url = WEB_URL . "fair/addfair.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);
}
else{
	//
	$total_rent = (float)$gas_bill + (float)$security_bill;
	$total_rent = number_format($total_rent, 2, '.', ' ');
}
//	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $title; ?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_rent_information_breadcam'];?></li>
    <li class="active"><?php echo $_data['add_new_rent_breadcam'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>fair/fairlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_rent_entry_form'];?></h3>
      </div>
	  <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
			<div class="form-group">
					<label for="ddlFloorNo"><?php echo $_data['add_new_form_field_text_2'];?> :</label>
					<select name="ddlFloorNo" id="ddlFloorNo" class="form-control" style="width:180px !important">
					<option value="">--<?php echo  $_data['add_new_form_field_text_2'];?>--</option>
					<?php 
							$result = mysql_query("SELECT * FROM tbl_add_floor Where branch_id=".$_SESSION['objLogin']['branch_id'],$link);
							while($row = mysql_fetch_array($result)){?>
					<option <?php if($floor_no == $row['fid']){echo 'selected';}?> value="<?php echo $row['fid'];?>"><?php echo $row['floor_no'];?></option>
					<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="ddlUnitNo"><?php echo $_data['add_new_form_field_text_4'];?> :</label>
					<select name="ddlUnitNo" id="ddlUnitNo" class="form-control" style="width:180px !important">
					<option value="">--<?php echo  $_data['add_new_form_field_text_4'];?>--</option>
					<?php 
							$result = mysql_query("SELECT * FROM tbl_add_unit where status = 1 AND branch_id=".$_SESSION['objLogin']['branch_id'],$link);
							while($row = mysql_fetch_array($result)){?>
					<option <?php if($unit_no == $row['uid']){echo 'selected';}?> value="<?php echo $row['uid'];?>"><?php echo $row['unit_no'];?></option>
					<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="hdnRentedId"><?php echo $_data['add_new_form_field_text_6'];?> :</label>
					<select name="hdnRentedId" id="hdnRentedId" class="form-control" style="width:180px !important">
					<option value="">--<?php echo  $_data['add_new_form_field_text_6'];?>--</option>
					<?php 
							$result = mysql_query("SELECT * FROM tbl_add_rent where r_status = 1 AND branch_id=".$_SESSION['objLogin']['branch_id'],$link);
							while($row = mysql_fetch_array($result)){?>
						<option <?php if($rid == $row['rid']){echo 'selected';}?> value="<?php echo $row['rid'];?>"><?php echo $row['r_name'];?></option>
					<?php } ?>
					</select>
				</div>
				<div class="form-group">
            <label for="ddlMonth"><?php echo "Month" ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="ddlMonth" value="<?php echo $month_id;?>" id="ddlMonth" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="ddlYear"><?php echo $_data['add_new_form_field_text_7'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtRent" value="<?php echo $rent;?>" id="txtRent" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="txtWaterBill"><?php echo $_data['add_new_form_field_text_8'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtWaterBill" value="<?php echo $water_bill;?>" id="txtWaterBill" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="txtElectricBill"><?php echo $_data['add_new_form_field_text_9'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtElectricBill" value="<?php echo $electric_bill;?>" id="txtElectricBill" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="txtGasBill"><?php echo $_data['add_new_form_field_text_10'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtGasBill" value="<?php echo $gas_bill;?>" id="txtGasBill" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="txtSecurityBill"><?php echo $_data['add_new_form_field_text_11'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtSecurityBill" value="<?php echo $security_bill;?>" id="txtSecurityBill" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="txtUtilityBill"><?php echo $_data['add_new_form_field_text_12'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtUtilityBill" value="<?php echo $utility_bill;?>" id="txtUtilityBill" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="txtOtherBill"><?php echo $_data['add_new_form_field_text_13'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtOtherBill" value="<?php echo $other_bill;?>" id="txtOtherBill" class="form-control"  />
            </div>
          </div>
		  <div class="form-group">
            <label for="txtIssueDate"><?php echo $_data['add_new_form_field_text_15'] ;?> :</label>
            <div class="input-group" style="width:180px !important">
              <input type="text" name="txtIssueDate" value="<?php echo $issue_date;?>" id="txtIssueDate" class="form-control datepicker"  />
            </div>
          </div>
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
	if($("#ddlFloorNo").val() == ''){
		alert("Floor Required !!!");
		$("#ddlFloorNo").focus();
		return false;
	}
	else if($("#ddlUnitNo").val() == ''){
		alert("Unit Required !!!");
		$("#ddlUnitNo").focus();
		return false;
	}
	else if($("#ddlMonth").val() == ''){
		alert("Month Required !!!");
		$("#ddlMonth").focus();
		return false;
	}
	else if($("#txtWaterBill").val() == ''){
		alert("Water Bill Required !!!");
		$("#txtWaterBill").focus();
		return false;
	}
	else if($("#txtElectricBill").val() == ''){
		alert("Electric Bill Required !!!");
		$("#txtElectricBill").focus();
		return false;
	}
	else if($("#txtGasBill").val() == ''){
		alert("Gas Bill Required !!!");
		$("#txtGasBill").focus();
		return false;
	}
	else if($("#txtSecurityBill").val() == ''){
		alert("Security Bill Required !!!");
		$("#txtSecurityBill").focus();
		return false;
	}
	else if($("#txtUtilityBill").val() == ''){
		alert("Utility Bill Required !!!");
		$("#txtUtilityBill").focus();
		return false;
	}
	else if($("#txtIssueDate").val() == ''){
		alert("Issue Date Required !!!");
		$("#txtIssueDate").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
