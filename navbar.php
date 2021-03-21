
<style>

</style>
<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=members" class="nav-item nav-members"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Members</a>
				<a href="index.php?page=payments" class="nav-item nav-payments"><span class='icon-field'><i class="fa fa-dollar-sign"></i></span> All Payments</a>

				<a class="list-header" style="color: white;">Loans</a>
				<a href="index.php?page=loans" class="nav-item nav-loans"><span class='icon-field'><i class="fa fa-hand-holding-usd"></i></span> View Loans</a>
				<a href="index.php?page=repayments" class="nav-item nav-repayments"><span class='icon-field'><i class="fa fa-money-bill"></i></span> Repayments</a>
				<a href="index.php?page=plan" class="nav-item nav-plan"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Loan Plans</a>	
				<a href="index.php?page=loan_type" class="nav-item nav-loan_type"><span class='icon-field'><i class="fa fa-th-list"></i></span> Loan Types</a>	

			
				<a class="list-header" style="color: white;">Projects</a>
				<a href="index.php?page=contributions" class="nav-item nav-contributions"><span class='icon-field'><i class="fa fa-wallet"></i></span> View Contributions</a>
				<a href="index.php?page=projects" class="nav-item nav-projects"><span class='icon-field'><i class="fa fa-briefcase"></i></span> Projects</a>
				<a href="index.php?page=withdrawal" class="nav-item nav-withdrawal"><span class='icon-field'><i class="fa fa-briefcase"></i></span> Withdrawal</a>

				<?php if($_SESSION['login_type'] == 1): ?>
				<a class="list-header" style="color: white;">Administrator</a>
			
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=reports" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Reports</a>
				
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
