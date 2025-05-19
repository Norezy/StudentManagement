<?php
require_once '../models/Student.php';
require_once '../plugins/fpdf/fpdf.php';
require_once '../Database/Database.php';

session_start();

$db = new Database();
$conn = $db->getConnection();

student::setConnection($conn);

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role'] === 'instructor') {
    header("Location: ../");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if($_POST['year_level'] == 'all'){
        $students = Student::all();
    }else{
        $students = Student::where('year_level','=', $_POST['year_level']);
    }


$pdf = new FPDF('L', 'mm', 'Legal');
$pdf->AddPage();
$pdf->headerPDF();

// Title
$pdf->SetFont('Arial', 'B', 30);
$pdf->Cell(0, 10, 'LIST OF ALL STUDENTS', 0, 1, 'C');
$pdf->Ln(15);

if ($students) {
    // Header
    $pdf->SetFont('Arial', 'B', 14);

    $pdf->SetFillColor(6, 31, 92);

    //Set border color of Header Table into blue
    $pdf->SetDrawColor(6, 31, 92);

    //Set font color into White
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell(25, 11, 'NO.', 1, 0, 'C', true);
    $pdf->Cell(30, 11, 'STUDENT ID', 1, 0, 'C', true);
    $pdf->Cell(80, 11, 'STUDENT NAME', 1, 0, 'C', true);
    $pdf->Cell(30, 11, 'GENDER', 1, 0, 'C', true);
    $pdf->Cell(40, 11, 'BIRTH DATE', 1, 0, 'C', true);
    $pdf->Cell(50, 11, 'COURSE', 1, 0, 'C', true);
    $pdf->Cell(40, 11, 'YEAR LEVEL', 1, 0, 'C', true);
    $pdf->Cell(0, 11, 'STATUS', 1, 0, 'C', true);
    $pdf->Ln(10);

    // Content
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $i = 1;
    foreach ($students as $student) {
        $pdf->Cell(25, 10, $i++, 'LB', 0, 'C');
        $pdf->Cell(30, 10, $student->student_id, 'B', 0, 'C');
        $pdf->Cell(80, 10, $student->name, 'B', 0, 'C');
        $pdf->Cell(30, 10, ucfirst($student->gender), 'B', 0, 'C');
        $pdf->Cell(40, 10, $student->birthdate, 'B', 0, 'C');
        $pdf->Cell(50, 10, $student->course()->code, 'B', 0, 'C');

        $year_level = null;
        switch ($student->year_level) {
            case 1:
                $year_level = "1st Year";
                break;
            case 2:
                $year_level = "2nd Year";
                break;
            case 3:
                $year_level = "3rd Year";
                break;
            case 4:
                $year_level = "4th Year";
                break;
            default:
                $year_level = "N/A";
        }

        $pdf->Cell(40, 10, $year_level, 'B', 0, 'C');
        if($student->status == 'active'){
            $pdf->SetTextColor(0, 125, 0);
        $pdf->cell(0, 10, $student->status, 'RB', 0,'C');
        }else{
            $pdf->SetTextColor(255, 0, 0);
            $pdf->cell(0, 10, $student->status, 'RB', 0,'C');
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(10);
    }
} else {
    $pdf->Ln(10);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetFont('Arial', 'B', 48);
    $pdf->Cell(0, 10, 'No students found', 0, 1, 'C');
}

$pdf->Output('I', 'student_report.pdf');

}else{
    header("Location: ../");
}
?>