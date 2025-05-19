<?php
include_once '../Database/Database.php';
$db = new Database();
$conn = $db->getConnection();
require_once '../models/Course.php';
require '../plugins/fpdf/fpdf.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role'] == 'instructor') {
    header("Location: ../");
    exit();
}

Course::setConnection($conn);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['id'])) {
        $course = Course::find($_POST['id']);
    } else {
        header("Location: ../courses/index.php");
        exit();
    }


    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->headerPDF();
    $pdf->SetLeftMargin(30);
    $pdf->SetRightMargin(30);

    if ($course) {
        $pdf->SetFont('Arial', 'B', 30);
        $pdf->Cell(0, 10, 'LIST OF STUDENTS ENROLLED IN', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->Cell(0, 10, strtoupper($course->name) . " (" . $course -> code . ")", 0, 1, 'C');
        $pdf->Ln(10);
    }

    if ($course) {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(6, 31, 92);
        $pdf->SetDrawColor(6, 31, 92);
        $pdf->SetTextColor(255, 255, 255);

        // Header
        $pdf->Cell(20, 15, 'NO.', 1, 0, 'C', true);
        $pdf->Cell(50, 15, 'STUDENT ID', 1, 0, 'C', true);
        $pdf->Cell(80, 15, 'NAME', 1, 0, 'C', true);
        $pdf->Cell(50, 15, 'GENDER', 1, 0, 'C', true);
        $pdf->Cell(0, 15, 'YEAR LEVEL', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(0, 0, 0);

        $i = 1;
        $count=0;
        if ($course->students()) {
            foreach ($course->students() as $student) {
            if($student->status == 'active' && ($_POST['year_level'] == $student->year_level || $_POST['year_level'] == 'all')){
                $pdf->Cell(20, 10, $student->id, 'LB', 0, 'C');
                $pdf->Cell(50, 10, $student->student_id, 'B', 0, 'C');
                $pdf->Cell(80, 10, $student->name, 'B', 0, 'C');
                $pdf->Cell(50, 10, ucfirst($student->gender), 'B', 0, 'C');

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
                $pdf->Cell(0, 10, $year_level, 'RB', 1, 'C');

                $count++;
                }
                
            }

            if($count == 0){
                $pdf->Ln(10);
                $pdf->SetTextColor(255, 0, 0);
                $pdf->SetFont('Arial', 'B', 36);
                $pdf->Cell(0, 10, 'No Students found', 0, 1, 'C');
            }

        } else {
            $pdf->Ln(10);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetFont('Arial', 'B', 36);
            $pdf->Cell(0, 10, 'No Students found', 0, 1, 'C');
        }

    } else {
        $pdf->Ln(10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetFont('Arial', 'B', 36);
        $pdf->Cell(0, 20, 'No Courses found', 0, 1, 'C');
    }

    $pdf->Output('I', 'Course_report.pdf');
} else {
    header("Location: ../");
    exit();
}
?>