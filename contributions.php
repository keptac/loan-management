<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Contributions Pool</b>
					<button class="btn btn-primary btn-sm btn-block col-md-2 float-right" type="button" id="add_contribution"><i class="fa fa-plus"></i> Add New Contribution</button>
				</large>
				
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="contribution-pool">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Contributor Name</th>
							<th class="text-center">Phone Number</th>
							<th class="text-center">Project Name</th>
							<th class="text-center">Reference</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Date</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							
							$i=1;
							$qry = $conn->query("SELECT l.*,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address, p.project_name from contribution_list l inner join members b on b.id = l.contributor_id inner join projects p on p.id = l.project_id order by id asc");

							while($row = $qry->fetch_assoc()):

						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td>
						 		<p><small><b><?php echo $row['name'] ?></b></small></p>
						 	</td>
							 <td>
						 		<p><small><b><?php echo $row['contact_no'] ?></b></small></p>
						 	</td>
						 	<td>
							 <p> <small><b><?php echo $row["project_name"] ?></b></small> </p>
						 	</td>
							 
							 <td>
						 		<p><small><b><?php echo $row['ref_no'] ?></small></b></p>
						 	</td>
							 <td>
						 		<p><small><b><?php echo number_format($row['amount'],2) ?></b></small></p>
						 	</td>
<td>
						 		<p><small><b><?php echo date("M d, Y",strtotime($row['date_released'])) ?></small></b></p>
						 	
						 	</td>
						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_contribution" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-eye"></i></button>
						 			<!-- <button class="btn btn-outline-danger btn-sm delete_contribution" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></button> -->
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
	$('#contribution-pool').dataTable()
	$('#add_contribution').click(function(){
		uni_modal("Add New Contribution","manage_contribution.php",'mid-large')
	})
	$('.edit_contribution').click(function(){
		uni_modal("View Contribution Details","view_contribution.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_contribution').click(function(){
		_conf("Are you sure to delete this data?","delete_contribution",[$(this).attr('data-id')])
	})
function delete_contribution($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_contribution',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Contribution successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>