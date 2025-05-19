<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../plugins/FPDF/fpdf.php';
require_once '../models/Grade.php';
require_once '../database/Database.php';
require_once '../models/Subject.php';
require_once '../models/Subject_Enrollment.php';

$database = new Database();
$db = $database->getConnection();
User::setConnection($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $subject = Subject::find($_POST['id']);

    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->headerPDF();

    $pdf->SetFont('Arial', 'B', 18);
    $pdf->SetTextColor(0, 0, 0); // Blue
    $pdf->Cell(0, 10, 'SUBJECT GRADE REPORT', 0, 1, 'C');
    $pdf->Ln(5);

    if ($subject) {
    $enrolled_students_count = 0;

        foreach ($subject->students() as $student) {
            if ($student->subject_enrollment()->status == 'enrolled') {
                $enrolled_students_count++;
            }
        }

        $pdf->SetTextColor(0, 0, 0);
        $halfWidth = 200; // Half of landscape width
        $lineHeight = 5;

        // Row 1: Subject Name & Instructor
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, $lineHeight, 'Subject Name:', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($halfWidth - 40, $lineHeight, $subject->catalog_no . ": " . ucwords($subject->name), 0, 0);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, $lineHeight, 'Instructor:', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($halfWidth - 30, $lineHeight, '        ' . ucwords($subject->instructor($subject->instructor_id)->name), 0, 1);

        // Row 2: Total Students & Course + Year Level
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, $lineHeight, 'Total Enrolled:', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($halfWidth - 40, $lineHeight, $enrolled_students_count, 0, 0);

        switch ($subject->year_level) {
            case 1: $textYearLevel = "1st Year"; break;
            case 2: $textYearLevel = "2nd Year"; break;
            case 3: $textYearLevel = "3rd Year"; break;
            case 4: $textYearLevel = "4th Year"; break;
            default: $textYearLevel = "N/A";
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, $lineHeight, 'Course & Year:', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($halfWidth - 40, $lineHeight, $subject->course()->code . " - " . $textYearLevel, 0, 1);

        $pdf->Ln(5);


        // Table Headers
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(6, 31, 92);
        $pdf->SetDrawColor(6, 31, 92);
        $pdf->SetTextColor(255, 255, 255);

        $pdf->Cell(25, 10, 'NO.', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'STUDENT ID', 1, 0, 'C', true);
        $pdf->Cell(100, 10, 'NAME', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'GRADE', 1, 0, 'C', true);
        $pdf->Cell(60, 10, 'REMARKS', 1, 0, 'C', true);
        $pdf->Cell(0, 10, 'STATUS', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0); // Back to black
        $id = 1;

        if ($subject->students()) {
            foreach ($subject->students() as $student) {
                if ($student->status == 'inactive') continue;

                $gradeObj = Grade::getGrades($student->id, $subject->id);
                $grade = $gradeObj?->grade 
                        ?? 'NOT YET SUBMITTED';

                $remarks = $gradeObj?->remarks 
                        ?? 'NOT YET SUBMITTED';

                $status = $student->subject_enrollment()->status;

                $pdf->Cell(25, 10, $id++, 'LB', 0, 'C');
                $pdf->Cell(50, 10, $student->student_id, 'B', 0, 'C');
                $pdf->Cell(100, 10, $student->name, 'B', 0, 'C');
                $pdf->Cell(50, 10, $grade, 'B', 0, 'C');
                $pdf->Cell(60, 10, ucfirst($remarks), 'B', 0, 'C');
                $pdf->Cell(0, 10, ucfirst($status), 'RB', 1, 'C');
                $pdf->SetTextColor(0); // Reset after row
            }
        } else {
            $pdf->Ln(10);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetFont('Arial', 'B', 24);
            $pdf->Cell(0, 10, 'No Enrolled Students Found', 0, 1, 'C');
        }

    } else {
        $pdf->Ln(10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->Cell(0, 10, 'No Subject Found', 0, 1, 'C');
    }

    $pdf->Output('I', 'subject_grades_report.pdf');
} else {
    header("Location: ../");
    exit();
}
?>
