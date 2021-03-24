<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM loan_list where id = ".$_GET['id']);
foreach($qry->fetch_array() as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
	<form action="" id="loan-application">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

		<?php
			$ref = $conn->query("SELECT * FROM loan_list where id = ".$_GET['id']);
		?>

		<?php while($row = $ref->fetch_assoc()): ?>
			<input type="hidden" name="ref_no" value="<?php echo isset($row['ref_no']) ? $row['ref_no'] : 'nothing' ?>">			
		<?php endwhile; ?>
		
		

		<div class="hide-values">
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Borrower</label>
				<?php
				$borrower = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM members order by concat(lastname,', ',firstname,' ',middlename) asc ");
				?>
				<select name="borrower_id" id="borrower_id" class="custom-select browser-default form-control ">
					<option value=""></option>
						<?php while($row = $borrower->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($borrower_id) && $borrower_id == $row['id'] ? "selected" : '' ?>><?php echo $row['name'] . ' |ID No:'.$row['tax_id'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Loan Type</label>
				<?php
				$type = $conn->query("SELECT * FROM loan_types order by `type_name` desc ");
				?>
				<select name="loan_type_id" id="loan_type_id" class="custom-select browser-default  form-control ">
					<option value=""></option>
						<?php while($row = $type->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($loan_type_id) && $loan_type_id == $row['id'] ? "selected" : '' ?>><?php echo $row['type_name'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
		
		</div>

		<br/>
		
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Loan Plan</label>
				<?php
				$plan = $conn->query("SELECT * FROM loan_plan order by `months` desc ");
				?>
				<select  name="plan_id" id="plan_id" class="custom-select browser-default">
					<option value=""></option>
						<?php while($row = $plan->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($plan_id) && $plan_id == $row['id'] ? "selected" : '' ?> data-months="<?php echo $row['months'] ?>" data-interest_percentage="<?php echo $row['interest_percentage'] ?>" data-penalty_rate="<?php echo $row['penalty_rate'] ?>"><?php echo $row['months'] . ' month(s) to pay at '.$row['interest_percentage'].'% interest.' ?></option>
						<?php endwhile; ?>
				</select>
			
			</div>

		</div>
		<div class="row">
			<div class="form-group col-md-6">
			<label class="control-label">Purpose</label>
			<textarea name="purpose" id="" cols="30" rows="2" class="form-control"><?php echo isset($purpose) ? $purpose : '' ?></textarea>
		</div>

		</div>
</div>

		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Borrower</label>
				<?php
				$borrower = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM members order by concat(lastname,', ',firstname,' ',middlename) asc ");
				?>
				<select disabled name="borrower_id" id="borrower_id" class="custom-select browser-default form-control ">
					<option value=""></option>
						<?php while($row = $borrower->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($borrower_id) && $borrower_id == $row['id'] ? "selected" : '' ?>><?php echo $row['name'] . ' |ID No:'.$row['tax_id'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Loan Type</label>
				<?php
				$type = $conn->query("SELECT * FROM loan_types order by `type_name` desc ");
				?>
				<select disabled name="loan_type_id" id="loan_type_id" class="custom-select browser-default  form-control ">
					<option value=""></option>
						<?php while($row = $type->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($loan_type_id) && $loan_type_id == $row['id'] ? "selected" : '' ?>><?php echo $row['type_name'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			
		</div>

		<br/>
		
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Loan Plan</label>
				<?php
				$plan = $conn->query("SELECT * FROM loan_plan order by `months` desc ");
				?>
				<select disabled name="plan_id" id="plan_id" class="custom-select browser-default">
					<option value=""></option>
						<?php while($row = $plan->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($plan_id) && $plan_id == $row['id'] ? "selected" : '' ?> data-months="<?php echo $row['months'] ?>" data-interest_percentage="<?php echo $row['interest_percentage'] ?>" data-penalty_rate="<?php echo $row['penalty_rate'] ?>"><?php echo $row['months'] . ' month(s) to pay at '.$row['interest_percentage'].'% interest.' ?></option>
						<?php endwhile; ?>
				</select>
			
			</div>
		<div class="form-group col-md-6">
			<label class="control-label">Loan Amount</label>
			<input disabled type="number" name="amount" class="form-control text-right" step="any" id="" value="<?php echo isset($amount) ? $amount : '' ?>">
		</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
			<label class="control-label">Purpose</label>
			<textarea disabled name="purpose" id="" cols="30" rows="2" class="form-control"><?php echo isset($purpose) ? $purpose : '' ?></textarea>
		</div>
<!-- 		
		<div class="form-group col-md-2 offset-md-2 .justify-content-center">
			<label class="control-label">&nbsp;</label>
			<button class="btn btn-primary btn-sm btn-block align-self-end" type="button" id="calculate">Calculate</button>
		</div> -->
		</div>

		<div id="calculation_table">

		</div>

		<div id="row-field">
			<div class="row ">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary btn-sm ammortization" type="button" data-id="<?php echo $_GET['id'] ?>">View Ammortization Schedule</button>
					<button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
		
	</form>
	</div>
</div>
<script>
	
	$('.hide-values').hide();

	$('.ammortization').click(function(){
		uni_modal("Ammortization","ammortization.php?id="+$(this).attr('data-id'),'mid-large')
	})
	

</script>
<style>
	#uni_modal .modal-footer{
		display: none
	}
</style>