<?php include 'db_connect.php' ?>
<?php 

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM members where id=".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;
	}
}

?>
<div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-member">
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			

				<input type="hidden" name="lastname" class="form-control" required="" value="<?php echo isset($lastname) ? $lastname : '' ?>">
				<input type="hidden" name="firstname" class="form-control" required="" value="<?php echo isset($firstname) ? $firstname : '' ?>">
				<input type="hidden" name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename : '' ?>">
				<input type="hidden" class="form-control" name="tax_id" value="<?php echo isset($tax_id) ? $tax_id : '' ?>">

		
			


			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="" class="control-label">Last Name</label>
						<input disabled name="lastname" class="form-control" required="" value="<?php echo isset($lastname) ? $lastname : '' ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="">First Name</label>
						<input disabled name="firstname" class="form-control" required="" value="<?php echo isset($firstname) ? $firstname : '' ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="">Middle Name</label>
						<input disabled name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename : '' ?>">
					</div>
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-6">
							<label for="">Address</label>
							<textarea name="address" id="" cols="30" rows="2" class="form-control" required=""><?php echo isset($address) ? $address : '' ?></textarea>
				</div>
				<div class="col-md-5">
					<div class="">
						<label for="">Contact #</label>
						<input type="text" class="form-control" name="contact_no" value="<?php echo isset($contact_no) ? $contact_no : '' ?>">
					</div>
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-6">
							<label for="">Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : '' ?>">
				</div>
				<div class="col-md-5">
					<div class="">
						<label for="">ID Number</label>
						<input disabled type="text" class="form-control" name="tax_id" value="<?php echo isset($tax_id) ? $tax_id : '' ?>">
					</div>
				</div>
			</div>



		</form>
	</div>
</div>

<script>
	 $('#manage-member').submit(function(e){
	 	e.preventDefault()
	 	start_load()
	 	$.ajax({
	 		url:'ajax.php?action=save_member',
	 		method:'POST',
	 		data:$(this).serialize(),
	 		success:function(resp){
	 			if(resp == 1){
	 				alert_toast("member data successfully saved.","success");
	 				setTimeout(function(e){
	 					location.reload()
	 				},1500)
	 			}
	 		}
	 	})
	 })
</script>