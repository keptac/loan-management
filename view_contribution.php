<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name  FROM contribution_list cl inner join ledger l on l.paychain_id = cl.ref_no inner join members m on m.id = cl.contributor_id  inner join projects p on p.id = cl.project_id where cl.id = ".$_GET['id']);
foreach($qry->fetch_array() as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
	<form action="POST" id="add-contribution">
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Member</label>
				<input type="text" name="amount" class="form-control text-left" step="any" id="" value="<?php echo isset($name) ? $name: '' ?>" disabled>
			</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<input type="text" name="amount" class="form-control text-left" step="any" id="" value="<?php echo isset($address) ? $address: '' ?>" disabled>
				</div>
				<div class="col-md-3">
					<input type="text" name="amount" class="form-control text-left" step="any" id="" value="<?php echo isset($contact_no) ? $contact_no: '' ?>" disabled>
				</div>
			</div>
<br/>
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Contribution Details</label>
				<input type="text" name="amount" class="form-control text-left" step="any" id="" value="<?php echo isset($project_name) ? "Project Name: ".$project_name: '' ?>" disabled>
			</div>
		
		</div>

		<br/>
		<div class="row">
			<div class="form-group col-md-8">
				<input type="text" name="amount" class="form-control text-left" step="any" id="" value="<?php echo isset($amount) ? "Paid ".$currency." ".number_format($amount,2)." with payment reference ".$trans_reference : '' ?>" disabled>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
			<label class="control-label">Comment</label>
			<textarea name="narration" id="" cols="30" rows="2" class="form-control" disabled><?php echo isset($narration) ? $narration : '' ?></textarea>
		</div>
		</div>


		<div id="row-field">
			<div class="row ">
				<div class="col-md-12 text-center">

					<button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
		
	</form>
	</div>
</div>

<style>
	#uni_modal .modal-footer{
		display: none
	}
</style>