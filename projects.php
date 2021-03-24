<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-project">
				<div class="card">
					<div class="card-header">
						New Project Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Project Name</label>
								<textarea name="project_name" id="" cols="30" rows="2" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="description" id="" cols="30" rows="2" class="form-control"></textarea>
							</div>
							
							<div class="row">
							<div class="form-group col-md-6">
								<label class="control-label">Start Date</label>
								<input name="start_date" id="" type="date" class="form-control">
							
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">End Date</label>
								<input name="end_date" id="" type="date" class="form-control">
							</div>
								
							</div>

							
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Project Name</th>
									<th class="text-center">Description</th>
									<th class="text-center">Start Date</th>
									<th class="text-center">End Date</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$types = $conn->query("SELECT * FROM projects order by id asc");
								while($row=$types->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><small><?php echo $row['project_name'] ?></small></p>
									</td>
									<td class="">
										<p><small> <?php echo $row['description'] ?></small></p>
									</td>
									<td class="">
										<p><small><?php echo date("M d, Y",strtotime($row['start_date'])) ?></small></p>
									</td>
									<td class="">
										<p><small><?php echo date("M d, Y",strtotime($row['end_date'])) ?></small></p>
									</td>

									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_prjct" type="button" data-id="<?php echo $row['id'] ?>" data-project_name="<?php echo $row['project_name'] ?>" data-description="<?php echo $row['description'] ?>" data-end_date="<?php echo $row['end_date'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_prjct" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: 150px;
	}
</style>
<script>
	function _reset(){
		$('[name="id"]').val('');
		$('#manage-project').get(0).reset();
	}
	
	$('#manage-project').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_project',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_prjct').click(function(){
		start_load()
		var cat = $('#manage-project')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='project_name']").val($(this).attr('data-project_name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='end_date']").val($(this).attr('data-end_date'))
		end_load()
	})
	$('.delete_prjct').click(function(){
		_conf("Are you sure to delete this Project?","delete_prjct",[$(this).attr('data-id')])
	})
	function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
	function delete_prjct($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Project successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>