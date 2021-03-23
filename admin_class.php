<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}else{
			return $data;
		}
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_loan_type(){
		extract($_POST);
		$data = " type_name = '$type_name' ";
		$data .= " , description = '$description' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO loan_types set ".$data);
		}else{
			$save = $this->db->query("UPDATE loan_types set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_loan_type(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_types where id = ".$id);
		if($delete)
			return 1;
	}
	function save_plan(){
		extract($_POST);
		$data = " months = '$months' ";
		$data .= ", interest_percentage = '$interest_percentage' ";
		$data .= ", penalty_rate = '$penalty_rate' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO loan_plan set ".$data);
		}else{
			$save = $this->db->query("UPDATE loan_plan set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_plan(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_plan where id = ".$id);
		if($delete)
			return 1;
	}

	function save_member(){
		extract($_POST);
		$data = " lastname = '$lastname' ";
		$data .= ", firstname = '$firstname' ";
		$data .= ", middlename = '$middlename' ";
		$data .= ", address = '$address' ";
		$data .= ", contact_no = '$contact_no' ";
		$data .= ", email = '$email' ";
		$data .= ", tax_id = '$tax_id' ";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO members set ".$data);
		}else{
			$save = $this->db->query("UPDATE members set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_member(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM members where id = ".$id);
		if($delete)
			return 1;
	}


	function save_loan(){
		$inputter = $_SESSION['login_name'];

		extract($_POST);
		$data = " borrower_id = $borrower_id ";
		$data .= " , loan_type_id = $loan_type_id ";
		$data .= " , plan_id = $plan_id ";
		$data .= " , amount = $amount ";
		$data .= " , purpose = '$purpose' ";

		$loans = $this->db->query("SELECT * FROM loan_plan where id = $plan_id ");

		while($l = $loans->fetch_assoc()){
			$rate = $l['interest_percentage'];
			$interest = $amount * ($l['interest_percentage']/100) * ($l['months']/12);
			$duration = $l['months'];

			$data .= " , rate = $rate ";
			$data .= " , interest = $interest ";
			$data .= " , duration = $duration ";
		}

		
			if(isset($status)){
				$data .= " , status = '$status' ";
				if($status == 2){
					$plan = $this->db->query("SELECT * FROM loan_plan where id = $plan_id ")->fetch_array();
					for($i= 1; $i <= $plan['months'];$i++){
						$date = date("Y-m-d",strtotime(date("Y-m-d")." +".$i." months"));
					$chk = $this->db->query("SELECT * FROM loan_schedules where loan_id = $id and date(date_due) ='$date'  ");
					if($chk->num_rows > 0){
						$ls_id = $chk->fetch_array()['id'];
						$this->db->query("UPDATE loan_schedules set loan_id = $id, date_due ='$date' where id = $ls_id ");
					}else{
						$this->db->query("INSERT INTO loan_schedules set loan_id = $id, date_due ='$date' ");
						$ls_id = $this->db->insert_id;
					}
					$sid[] = $ls_id;
					}
					$sid = implode(",",$sid);
					$this->db->query("DELETE FROM loan_schedules where loan_id = $id and id not in ($sid) ");
				$data .= " , date_released = '".date("Y-m-d H:i")."' ";

				}else{
					$chk = $this->db->query("SELECT * FROM loan_schedules where loan_id = $id")->num_rows;
					if($chk > 0){
						$this->db->query("DELETE FROM loan_schedules where loan_id = $id ");
					}

				}
			}

			if(empty($id)){
				$ref_no = "L".mt_rand(1,999999);
				$i= 1;

				while($i== 1){
					$check = $this->db->query("SELECT * FROM loan_list where ref_no = '$ref_no' ")->num_rows;
					if($check > 0){
						$ref_no = "L".mt_rand(1,999999);
					}else{
						$i = 0;
					}
				}

				$data .= " , ref_no = '$ref_no' ";
			}

			if(empty($id)){
				$save = $this->db->query("INSERT INTO loan_list set ".$data);
				if($save){
					return 1;
				}else{
					return $data;
				}
				
			}else{
				$save = $this->db->query("UPDATE loan_list set ".$data." where id=".$id);

				if($save){
					if($status==2){
						$ledgerRecord = " trans_reference = 'LDM".mt_rand(1,999999)."'";
						$ledgerRecord .= " , paychain_id = '$ref_no' ";
						$ledgerRecord .= " , amount = ($amount * -1) ";
						$ledgerRecord .= " , inputter = '$inputter' "; 
						$ledgerRecord .= " , payee = '$borrower_id' ";
						$ledgerRecord .= " , currency = 'USD' "; 
						$ledgerRecord .= " , payment_narration = 'LOAN DISBURMENT'";
						$ledgerRecord .= " , mode_of_payment = 'CASH' ";
						$ledgerRecord .= " , status = 1 ";
		
							if($this->updateLedger($ledgerRecord)){
								return 1;
							}
					}else{
						return 1;
					}
					
				}else{
					return $data;
				}
			}
	}

	function delete_loan(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_list where id = ".$id);
		if($delete)
			return 1;
	}

	// Loan repayment
	function save_payment(){

		extract($_POST);

		// Pass Currency
		// Pass MODE of payment

		$inputter = $_SESSION['login_name'];
		$data = " loan_id = $loan_id ";
		$data .= " , payee = '$payee' ";
		$data .= " , amount = $amount ";
		$data .= " , penalty_amount = $penalty_amount ";
		$data .= " , overdue = '$overdue' ";
		$data .= " , inputter = '$inputter' ";
		$data .= " , currency_code = 'USD' ";

		$ledgerRecord = " trans_reference = 'LMS".mt_rand(1,999999)."'";
		$ledgerRecord .= " , paychain_id = '$loan_id' ";
		$ledgerRecord .= " , amount = $amount ";
		$ledgerRecord .= " , inputter = '$inputter' "; //Revisit this break point
		$ledgerRecord .= " , payee = '$payee_id' ";
		$ledgerRecord .= " , currency = 'USD' "; 
		$ledgerRecord .= " , payment_narration = 'LOAN REPAYMENT'"; //LOAN REPAYMENT, LOAN PENALTY, CONTRIBUTION, WITHDRAWAl
		$ledgerRecord .= " , mode_of_payment = 'CASH' ";
		$ledgerRecord .= " , status = 1 ";
		

		$save = $this->db->query("INSERT INTO loan_repayments set ".$data);

		if($save){
			$save2 = $this->db->query("INSERT INTO ledger set ".$ledgerRecord);
			if($save2){
				if($overdue==1){
					$ledgerRecordPenalty = " trans_reference = 'LMSP".mt_rand(1,999999)."'";
					$ledgerRecordPenalty .= " , paychain_id = '$loan_id'";
					$ledgerRecordPenalty .= " , amount = $penalty_amount ";
					$ledgerRecordPenalty .= " , inputter = '$inputter' "; 
					$ledgerRecordPenalty .= " , payee = $payee_id ";
					$ledgerRecordPenalty .= " , currency = 'USD' "; 
					$ledgerRecordPenalty .= " , payment_narration = 'LOAN PENALTY'";
					$ledgerRecordPenalty .= " , mode_of_payment = 'CASH' ";
					$ledgerRecord .= " , status = 1 ";
					$this->db->query("INSERT INTO ledger set ".$ledgerRecordPenalty);
				}
			}
		}

		if($save2){
			return 1;
		}
	}

	function updateLedger($data){
		$save = $this->db->query("INSERT INTO ledger set ".$data);
		if($save){
			return 1;
		}
	}

	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_repayments where id = ".$id);
		if($delete)
			return 1;
	}

//Contributions
	function save_contribution(){
		//Pass Currency

		$inputter = $_SESSION['login_name'];

		extract($_POST);
			$data = " contributor_id = $contributor_id ";
			$data .= " , project_id = $project_id ";
			$data .= " , amount = $amount ";
			$data .= " , narration = '$narration' ";
			$data .= " , inputter = '$inputter' ";
			$data .= " , currency_code = 'USD' ";

			if(empty($id)){
				$ref_no = "C".mt_rand(1,999999);
				$i= 1;

				while($i== 1){
					$check = $this->db->query("SELECT * FROM contribution_list where ref_no ='$ref_no' ")->num_rows;
					if($check > 0){
						$ref_no = "C".mt_rand(1,999999);
					}else{
						$i = 0;
					}
				}

				$data .= " , ref_no = '$ref_no' ";

				$save = $this->db->query("INSERT INTO contribution_list set ".$data);

				$ledgerRecord = " trans_reference = 'CMS".mt_rand(1,999999)."'";
				$ledgerRecord .= " , paychain_id = '$ref_no' ";
				$ledgerRecord .= " , amount = $amount ";
				$ledgerRecord .= " , inputter = '$inputter' "; 
				$ledgerRecord .= " , payee = '$contributor_id' ";
				$ledgerRecord .= " , currency = 'USD' "; 
				$ledgerRecord .= " , payment_narration = 'CONTRIBUTION'";
				$ledgerRecord .= " , mode_of_payment = 'CASH' ";
				$ledgerRecord .= " , status = 1 ";

				if($save){
					if($this->updateLedger($ledgerRecord)){
						$success = true;
					}else{
						$delete = $this->db->query("DELETE FROM contribution_list where ref_no = ".$ref_no);
						$success = false;
					}
				}

			}else{
				$save = $this->db->query("UPDATE contribution_list set ".$data." where id=".$id);
			}
					
			if($success)
				return 1;
			else{
				return $ledgerRecord;
			}	

	}

	function delete_contribution(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM contribution_list where id = ".$id);
		if($delete)
			return 1;
	}

	//Project
	function save_project(){
		extract($_POST);
		$data = " project_name = '$project_name' ";
		$data .= " , description = '$description' ";
		$data .= " , start_date = '$start_date' ";
		$data .= " , end_date = '$end_date' ";
		$data .= " , status = 1";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO projects set ".$data);
		}else{
			$save = $this->db->query("UPDATE projects set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_project(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM projects where id = ".$id);
		if($delete)
			return 1;
	}

	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}

	//Withdrawals
	function make_withdrawal(){
		$inputter = $_SESSION['login_name'];
		extract($_POST);

		$ledgerRecord = " trans_reference = 'CWP".mt_rand(1,999999)."'";
		$ledgerRecord .= " , paychain_id = '$project_id' ";
		$ledgerRecord .= " , amount = ($amount * -1) ";
		$ledgerRecord .= " , payee = $customer_id ";
		$ledgerRecord .= " , inputter = '$inputter' "; 
		$ledgerRecord .= " , currency = 'USD' "; 
		$ledgerRecord .= " , payment_narration = 'WITHDRAWAL'";
		$ledgerRecord .= " , mode_of_payment = 'CASH' ";
		$ledgerRecord .= " , status = 0 ";

		$save = $this->db->query("INSERT INTO ledger set ".$ledgerRecord);
		if($save){
			return 1;
		}else{
			return $ledgerRecord;
		}
	}

	function authorize_withdrawal(){
		$inputter = $_SESSION['login_name'];
		extract($_POST);

		$dataArr = str_split("\,", $withdrawal_approve); 

		$data .= " , status =  $dataArr[0]";
		$data .= " , inputter = '$inputter' "; 

		$save = $this->db->query("UPDATE `ledger` SET ".$data." WHERE trans_reference = ".$dataArr[1]);
		if($save){
			return 1;
		}else{
			return $data;
		}
	}
}

