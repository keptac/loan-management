<?php 
include('db_connect.php');
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM ledger where id = ".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
	<form action="POST" id="add-withdrawal">
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Customer</label>
				<?php
				$contributor = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM members order by concat(lastname,', ',firstname,' ',middlename) asc ");
				?>
				<select name="customer_id" id="customer_id" class="custom-select browser-default">
					<option value=""></option>
						<?php while($row = $contributor->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($contributor_id) && $contributor_id == $row['id'] ? "selected" : '' ?>><?php echo $row['name'] . ' |ID No:'.$row['tax_id'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Project Name</label>
				<?php
				$type = $conn->query("SELECT * FROM projects where `status` = 1 order by `project_name` desc "); //only active projects to appear
				?>
				<select name="project_id" id="project_id" class="custom-select browser-default">
					<option value=""></option>
						<?php while($row = $type->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($project_id) && $project_id == $row['id'] ? "selected" : '' ?>><?php echo $row['project_name'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
		</div>
	
		<br/>

		<div id="balance_fields">

		</div>

		<!-- <hr/>
		<div class="row">
			<div class="form-group col-md-6">
				<label class="control-label">Amount</label>
				<input type="number" name="amount" class="form-control text-right" step="any" id="" value="<?php //echo isset($amount) ? $amount : '' ?>">
			</div>
		</div>

		<div id="row-field">
			<div class="row ">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary btn-sm " >Save</button>
					<button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div> -->
		
	</form>
	</div>
</div>
<script>
	$('[name="project_id"]').change(function(){
		load_fields()
	})

	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})

	function load_fields(){
		start_load()
		
		$.ajax({
			url:'load_balance.php',
			method:"POST",
			data:{customer_id:$('[name="customer_id"]').val(), project_id:$('[name="project_id"]').val()},
			success:function(resp){
				if(resp){
					$('#balance_fields').html(resp)
					end_load()
				}
			}
		})
	}

	$('#add-withdrawal').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=make_withdrawal',
			method:"POST",
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1 ){
					$('.modal').modal('hide')
					alert_toast("Withdrawal Successful","success")
					setTimeout(function(){
						location.reload();
					},1500)
				}else{
					alert_toast(resp,"success")
				}
			}
		})
	})

</script>
<style>
	#uni_modal .modal-footer{
		display: none
	}
</style>