
<?php 
include('db_connect.php');
session_start();

?>

<div class="container-fluid">
	<div class="col-lg-12">
				<table class="table table-bordered" id="ammortization-list">
					<thead>
						<tr>
							<th class="text-center"><small><b>#</b></small></th>
							<th class="text-center"><small><b>Payment Date</b></small></th>
							<th class="text-center"><small><b>Opening Balance #</b></small></th>
							<th class="text-center"><small><b>Payment</b></small></th>
							<th class="text-center"><small><b>Principal</b></small></th>
							<th class="text-center"><small><b>Interest</b></small></th>
							<th class="text-center"><small><b>Closing Balance</b></small></th>
						</tr>
					</thead>
					<tbody>
						<?php
							
							$i=1;
                            $previousClosingBalance = 0;

                            //Get All Lon Information and Schedule
                            $qry = $conn->query("SELECT * FROM `loan_schedules` ls inner join loan_list ll where ls.loan_id = ".$_GET['id']."  and ls.loan_id = ll.id");
                            
                            while($row = $qry->fetch_assoc()):
                                if($i==1){
                                    $monthlyPayable = ($row['amount'] + ($row['amount'] * $row['rate']/100))/$row['duration'];

                                    $interest = ($row['amount'] * ($row['rate']/100) * ($row['duration']/12))/$row['duration'];
                                    $principle = $monthlyPayable - $interest;
                                    $closingBalance = $row['amount'] - $principle;
                                    $previousClosingBalance = $row['amount'];
                                }else{
                                    $monthlyPayable = ($row['amount'] + ($row['amount']*$row['rate']/100))/$row['duration'];
                                    $interest = ($previousClosingBalance * ($row['rate']/100) * ($row['duration']/12))/$row['duration'];
                                    $principle = $monthlyPayable - $interest;
                                    $closingBalance = $previousClosingBalance - $principle;
                                }
                                
						?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td>
								<p><small> <?php echo $row['date_due'] ?></small></p>
							</td>
							<td>
								<p><small><?php echo number_format($previousClosingBalance,2)  ?></small></p>
							</td>
							<td>
								<p><small><?php echo number_format($monthlyPayable,2)  ?></small></p>
							</td>
							<td>
								<p><small> <?php echo number_format($principle,2)  ?></small></p>
							</td>
							<td>
								<p><small> <?php echo number_format($interest,2) ?></small></p>
							</td>
							<td>
								<p> <small><?php echo number_format($closingBalance,2) ?></small></p>
							</td>

						</tr>
						<?php 
                            $previousClosingBalance = $closingBalance;

                    endwhile; ?>
					</tbody>
				</table>
                </div>
            </div>
			<!-- <div class="row ">
				<div class="col-md-12 text-center">
                    <button class="btn btn-primary btn-sm" type="button" >Export Schedule</button>
				</div>
			</div> -->

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
	$('#ammortization-list').dataTable()

</script>