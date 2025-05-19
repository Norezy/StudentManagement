<?php
require_once '../models/subject.php';
require '../plugins/fpdf/fpdf.php';
include_once '../Database/Database.php';
$db = new Database();
$conn = $db->getConnection();
?>

<?php 
session_start();
Subject::setConnection($conn);

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role'] == 'instructor') {
    header("Location: ../");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['semester'] == 'all'){
        $subjects = Subject::all();
    }else{
        $subjects = Subject::where('semester','=', $_POST['semester']);
    }

    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->headerPDF();

    // Title
    $pdf->SetFont('Arial', 'B', 30);
    $pdf->Cell(0, 15, 'LIST OF ALL SUBJECTS', 0, 1, 'C');
    $pdf->Ln(5);

    // Header styling
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(6, 31, 92);
    $pdf->SetDrawColor(6, 31, 92);
    $pdf->SetTextColor(255, 255, 255);

    // Header row
    $pdf->Cell(12, 11, 'NO.', 1, 0, 'C', true);
    $pdf->Cell(30, 11, 'SUBJECT CODE', 1, 0, 'C', true);
    $pdf->Cell(30, 11, 'CATALOG NO.', 1, 0, 'C', true);
    $pdf->Cell(70, 11, 'SUBJECT NAME', 1, 0, 'C', true);
    $pdf->Cell(35, 11, 'SCHEDULE', 1, 0, 'C', true);
    $pdf->Cell(25, 11, 'ROOM', 1, 0, 'C', true);
    $pdf->Cell(30, 11, 'COURSE', 1, 0, 'C', true);
    $pdf->Cell(30, 11, 'SEMESTER', 1, 0, 'C', true);
    $pdf->Cell(30, 11, 'YEAR LEVEL', 1, 0, 'C', true);
    $pdf->Cell(0, 11, 'INSTRUCTOR', 1, 1, 'C', true);

    // Reset font & colors for content
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0);

    $i = 1;
    if ($subjects) {
        foreach ($subjects as $subject) {
            $pdf->Cell(12, 10, $i++, 'LB', 0, 'C');
            $pdf->Cell(30, 10, $subject->code, 'B', 0, 'C');
            $pdf->Cell(30, 10, $subject->catalog_no, 'B', 0, 'C');
            $pdf->Cell(70, 10, $subject->name, 'B', 0, 'C');
            $pdf->Cell(35, 10, $subject->day . " " . $subject->time, 'B', 0, 'C');
            $pdf->Cell(25, 10, $subject->room, 'B', 0, 'C');
            $pdf->Cell(30, 10, $subject->course()->code, 'B', 0, 'C');

            switch ($subject->semester) {
                case 1:
                $semester = "1st Sem";
                break;
                case 2:
                $semester = "2nd Sem";
                break;
                default:
                $semester = "N/A";
                break;
            }

            $pdf->Cell(30, 10, $semester, 'B', 0, 'C');

            switch ($subject->year_level) {
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
                break;
            }

            $pdf->Cell(30, 10, $year_level, 'B', 0, 'C');

            $pdf->Cell(0, 10, $subject->instructor($subject->instructor_id)->name, 'RB', 1, 'C');
        }
    } else {
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 40);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(0, 15, 'No subjects found', 0, 1, 'C');
    }

    $pdf->Output('I', 'subject_report.pdf');
}else{
    header("Location: ../");
}
?>
