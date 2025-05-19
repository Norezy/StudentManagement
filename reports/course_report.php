<?php
require_once '../models/Course.php';
require '../plugins/fpdf/fpdf.php';
include_once '../Database/Database.php';

$db = new Database();
$conn = $db->getConnection();

session_start();
Course::setConnection($conn);

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role'] == 'instructor') {
    header("Location: ../");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $courses = Course::all();

    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->headerPDF();

    $pdf->SetFont('Arial', 'B', 30);
    $pdf->Cell(0, 10, 'COURSE REPORT', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetLeftMargin(30);
    $pdf->SetRightMargin(30);

    if ($courses) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(6, 31, 92);
        $pdf->SetDrawColor(6, 31, 92);
        $pdf->SetTextColor(255, 255, 255);

        // Table Headers
        $pdf->Cell(20, 11, 'N0.', 1, 0, 'C', true);
        $pdf->Cell(50, 11, 'COURSE CODE', 1, 0, 'C', true);
        $pdf->Cell(0, 11, 'COURSE NAME', 1, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(0, 0, 0);

        $i = 1;
        foreach ($courses as $course) {
            $pdf->Cell(20, 10, $i++, 1, 0, 'C');
            $pdf->Cell(50, 10, $course->code, 1, 0, 'C');
            $pdf->Cell(0, 10, $course->name, 1, 0, 'C');
            $pdf->Ln(10);
        }

    } else {
        $pdf->Ln(10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetFont('Arial', 'B', 48);
        $pdf->Cell(0, 10, 'No Courses found', 0, 1, 'C');
    }

    $pdf->Output('I', 'Course_report.pdf');

}else{
    header("Location: ../");
    exit();
}

?>
