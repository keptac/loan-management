<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}

if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_loan_type"){
	$save = $crud->save_loan_type();
	if($save)
		echo $save;
}
if($action == "delete_loan_type"){
	$save = $crud->delete_loan_type();
	if($save)
		echo $save;
}
if($action == "save_plan"){
	$save = $crud->save_plan();
	if($save)
		echo $save;
}
if($action == "delete_plan"){
	$save = $crud->delete_plan();
	if($save)
		echo $save;
}
if($action == "save_member"){
	$save = $crud->save_member();
	if($save)
		echo $save;
}
if($action == "delete_member"){
	$save = $crud->delete_member();
	if($save)
		echo $save;
}
if($action == "save_loan"){
	$save = $crud->save_loan();
	if($save)
		echo $save;
}

if($action == "delete_loan"){
	$save = $crud->delete_loan();
	if($save)
		echo $save;
}

if($action == "save_payment"){
	$save = $crud->save_payment();
	if($save)
		echo $save;
}
if($action == "delete_payment"){
	$save = $crud->delete_payment();
	if($save)
		echo $save;
}

//Contributions CRUD
if($action == "save_contribution"){
	$save = $crud->save_contribution();
	if($save)
		echo $save;
}

if($action == "delete_contribution"){
	$save = $crud->delete_contribution();
	if($save)
		echo $save;
}

//Project 
if($action == "save_project"){
	$save = $crud->save_project();
	if($save)
		echo $save;
}
if($action == "delete_project"){
	$save = $crud->delete_project();
	if($save)
		echo $save;
}

// Withdrawal
if($action == "make_withdrawal"){
	$save = $crud->make_withdrawal();
	if($save)
		echo $save;
}

// Withdrawal
if($action == "authorize_withdrawal"){
	$save = $crud->authorize_withdrawal();
	if($save)
		echo $save;
}

