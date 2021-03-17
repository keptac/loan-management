<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM contribution_list where id = ".$_GET['id']);
foreach($qry->fetch_array() as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
	<form action="" id="add-contribution">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Member</label>
				<?php
				$contributor = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM members order by concat(lastname,', ',firstname,' ',middlename) asc ");
				?>
				<select name="contributor_id" id="contributor_id" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $contributor->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($contributor_id) && $contributor_id == $row['id'] ? "selected" : '' ?>><?php echo $row['name'] . ' | Tax ID:'.$row['tax_id'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Project Name</label>
				<?php
				$type = $conn->query("SELECT * FROM projects where `status` = 1 order by `project_name` desc "); //only active projects to appear
				?>
				<select name="project_id" id="project_id" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $type->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($project_id) && $project_id == $row['id'] ? "selected" : '' ?>><?php echo $row['project_name'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			
		</div>

		<div class="row">

		<div class="form-group col-md-6">
			<label class="control-label">Amount</label>
			<input type="number" name="amount" class="form-control text-right" step="any" id="" value="<?php echo isset($amount) ? $amount : '' ?>">
		</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
			<label class="control-label">Comment</label>
			<textarea name="description" id="" cols="30" rows="2" class="form-control"><?php echo isset($narration) ? $narration : '' ?></textarea>
		</div>

		</div>

		<?php if(isset($status)): ?>
		<div class="row">
			<div class="form-group col-md-6">
				<label class="control-label">&nbsp;</label>
				<select class="custom-select browser-default" name="status">
					<option value="0" <?php echo $status == 0 ? "selected" : '' ?>>For Approval</option>
					<option value="1" <?php echo $status == 1 ? "selected" : '' ?>>Approved</option>
					<?php if($status !='4' ): ?>
					<option value="2" <?php echo $status == 2 ? "selected" : '' ?>>Released</option>
					<?php endif ?>
					<?php if($status =='2' ): ?>
					<option value="3" <?php echo $status == 3 ? "selected" : '' ?>>Complete</option>
					<?php endif ?>
					<?php if($status !='2' ): ?>
					<option value="4" <?php echo $status == 4 ? "selected" : '' ?>>Denied</option>
					<?php endif ?>
				</select>
			</div>
		</div>
		<hr>
	<?php endif ?>
		<div id="row-field">
			<div class="row ">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary btn-sm " >Save</button>
					<button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
		
	</form>
	</div>
</div>
<script>
	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})
	$('#calculate').click(function(){
		calculate()
	})
	

	$('#add-contribution').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_contribution',
			method:"POST",
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1 ){
					$('.modal').modal('hide')
					alert_toast("Contribution successfully added to contributions pool","success")
					setTimeout(function(){
						location.reload();
					},1500)
				}
			}
		})
	})
	$(document).ready(function(){
		if('<?php echo isset($_GET['id']) ?>' == 1)
			calculate()
	})
</script>
<style>
	#uni_modal .modal-footer{
		display: none
	}
</style>