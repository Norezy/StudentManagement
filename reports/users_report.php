<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: ../auth/login.php");
    exit();
}
if($_SESSION['role'] === 'instructor'){
    header("Location: ../");
}

require_once '../plugins/FPDF/fpdf.php';
require_once '../models/User.php';
require_once '../database/Database.php';

$database = new Database();

$db = $database->getConnection();

User::setConnection($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['role']) && $_POST['role'] == 'admin'){
        $users = User::findByRole($_POST['role']);
    }elseif(isset($_POST['role']) && $_POST['role'] == 'instructor'){
        $users = User::findByRole($_POST['role']);
    }else{    
        $users = User::all();
    }   

    //FPDF class gumagawa tayo ng object na pangalan $pdf
    $pdf = new FPDF('L', 'mm', 'Legal');

    //Add a new page to the PDF document
    $pdf->AddPage();

    //Add header
    
    $pdf->headerPDF();

    //Set Font
    $pdf->SetFont('Arial', 'B', 30);

    //Set Title
    $pdf->Cell(0, 10, 'USERS REPORT', 0, 0, 'C');
    $pdf->Ln(15);
    $pdf->SetLeftMargin(30);
    $pdf->SetRightMargin(30);

    //Set Table Content
    if($users){

        //Set Font for Header Table
        $pdf->SetFont('Arial', 'B', 14);

        //Set fill color of Header Table into blue
        $pdf->SetFillcolor(6, 31, 92);

        //Set border color of Header Table into blue
        $pdf->SetDrawColor(6, 31, 92);

        //Set font color into White
        $pdf->SetTextColor(255, 255, 255);

        //Set Header Table
        $pdf->Cell(25, 11, 'NO.', 1, 0,'C', true);
        $pdf->Cell(70, 11, 'NAME', 1, 0,'C', true);
        $pdf->Cell(70, 11, 'E-MAIL', 1, 0,'C', true);
        $pdf->Cell(60, 11, 'ROLE', 1, 0,'C', true);
        $pdf->Cell(0, 11, 'STATUS', 1, 0,'C', true);
        $pdf->Ln(10);

        //Set Font for Table Content
        $pdf->SetFont('Arial', '', 12);

        //Set font color into black
        $pdf->SetTextColor(0, 0, 0);

        $i = 1;
        
        foreach($users as $user){
            $pdf->cell(25, 10, $i++,'LB', 0,'C');
            $pdf->cell(70, 10, $user->name, 'B', 0,'L');
            $pdf->cell(70, 10, $user->email, 'B', 0,'C');
            $pdf->cell(60, 10, $user->role, 'B', 0,'C');
            if($user->status == 'active'){
                $pdf->SetTextColor(0, 125, 0);
            $pdf->cell(0, 10, $user->status, 'RB', 0,'C');
            }else{
                $pdf->SetTextColor(255, 0, 0);
                $pdf->cell(0, 10, $user->status, 'RB', 0,'C');
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(10);
        }

    }else{
        //Set Font for No Data
        $pdf->ln(5);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetFont('Arial', 'B', 48);
        $pdf->SetRightMargin(45);
        //for No Data
        $pdf->Cell(0, 10, 'No users found', 0, 1, 'C');
    }

    //Output
    $pdf->Output('I', 'users_report.pdf');

}else{
    header("Location: ../");
}
?>