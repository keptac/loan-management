<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>All payments</b>
					<!-- <button class="btn btn-primary btn-sm btn-block col-md-2 float-right" type="button" id="funds_withdrawal"><i class="fa fa-plus"></i> Funds Withdrawal</button> -->
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
							<th class="text-center">Inputter</th>
                            <th class="text-center">Narration</th>
							<th class="text-center">Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
							
							$i=1;
							$qry = $conn->query("SELECT l.*,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address from ledger l inner join members b on b.id = l.payee where l.status != 2 order by id asc");

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

                             <td>
						 		<p><small><?php echo $row['payment_narration'] ?></small></p>
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
	$('#withdrawal-pool').dataTable()
	$('#funds_withdrawal').click(function(){
		uni_modal("Funds Withdrawal","manage_withdrawal.php",'mid-large')
	})
</script>