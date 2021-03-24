<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Withdrawals</b>
					<button class="btn btn-primary btn-sm btn-block col-md-2 float-right" type="button" id="funds_withdrawal"><i class="fa fa-plus"></i> Funds Withdrawal</button>
				</large>
				
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="withdrawal-pool">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Phone Number</th>
							<th class="text-center">Reference</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Issued by</th>
							<th class="text-center">Action</th>
							<th class="text-center">Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
							
							$i=1;
							$qry = $conn->query("SELECT l.*,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address from ledger l inner join members b on b.id = l.payee where l.payment_narration = 'WITHDRAWAl' order by id asc");

							while($row = $qry->fetch_assoc()):

						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td>
						 		<p><small><?php echo $row['name'] ?></small></p>
						 	</td>
							 <td>
						 		<p><small><?php echo $row['contact_no'] ?></small></p>
						 	</td>
						 	<td>
							 <p> <small><?php echo $row["trans_reference"] ?></small> </p>
						 	</td>

							 <td>
								<p><small><?php echo $row['currency']." ".number_format($row['amount'],2) ?></small></p>
							</td>
							 
							 <td>
						 		<p><small><?php echo $row['inputter'] ?></small></p>
						 	</td>

							<td class="text-center">
								<p class="badge badge-success"><?php if($row['status']==1)echo "Successful"?></p>
								<p class="badge badge-danger"><?php if($row['status']==2)echo "Declined"?></p>

								<?php if($row['status']==0):?>
									<p><small>


									<?php if($_SESSION['login_type'] == 1): ?>
										<!-- Only admins -->
										<select name="withdrawal_approve" id="" class="custom-select browser-default">
											<option value="" <?php echo $status == "" ? "selected" : '' ?>></option>
											<option value=<?php echo "1,".$row["trans_reference"] ?> <?php echo $status == 1 ? "selected" : '' ?>>Approve</option>
											<option value=<?php echo "2,".$row["trans_reference"] ?> <?php echo $status == 2 ? "selected" : '' ?>>Decline</option>
										</select>
									<?php endif?>

									</small></p>
								<?php endif ?>
							</td>
							<td>
								<p><small><?php echo date("M d, Y",strtotime($row['date_of_payment'])) ?></small></p>
							</td>


						 </tr>

						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
		
	$('[name="withdrawal_approve"]').change(function(){
		update_status()
	})

	function update_status(){
		start_load()
	
		$.ajax({
			url:'ajax.php?action=authorize_withdrawal',
			method:"POST",
			data:{withdrawal_approve:$('[name="withdrawal_approve"]').val(), },
			success:function(resp){
				if(resp==1){
					alert_toast("Withdrawal Approved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				
				}else{
					alert_toast(resp,'success')
				}
			}
		})
	}

	$('#withdrawal-pool').dataTable()
	$('#funds_withdrawal').click(function(){
		uni_modal("Funds Withdrawal","manage_withdrawal.php",'mid-large')
	})
</script>