<?php include 'db_connect.php' ?>
<?php 
	extract($_POST);
	if(isset($project_id) and isset($customer_id)){
		$balances = $conn->query("SELECT sum(amount) FROM contribution_list where project_id = ".$project_id." AND contributor_id = ".$customer_id);
        $withdrawals = $conn->query("SELECT sum(amount) FROM ledger where payment_narration = 'LOAN DISBURMENT' AND payee = ".$customer_id);

        while($b = $balances->fetch_assoc()){
            $sum_deposited = $b['sum(amount)'];
        }

        while($w = $withdrawals->fetch_assoc()){
            $sum_withdrawn = $w['sum(amount)'];
        }

        $total_sum = $sum_deposited + $sum_withdrawn;
	}

?>
<div class="col-lg-12">


    <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label">Withdrawal Account Balance</label>
            <input disabled type="number" name="balance" class="form-control text-right" value="<?php echo isset($total_sum) ? $total_sum : '' ?>">
        </div>
    </div>

    <?php if($total_sum>0): ?>
        <hr/>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label">Amount</label>
                <input type="number" name="amount" class="form-control text-right" step="any" id="" value="<?php echo isset($amount) ? $amount : '' ?>">
            </div>
        </div>
        
        <div id="row-field">
            <div class="row ">
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary btn-sm " >Save</button>
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if($total_sum <= 0): ?>
        <div class="row ">
            <div class="col-md-12 text-center">
                <h5>Sorry you cannot withdraw from this account under this project. Amount below minimum threshold.</h5>
            </div>
        </div>
    <?php endif ?>

</div>