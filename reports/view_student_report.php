<?php
require_once '../models/Student.php';
require_once '../models/Grade.php';
require '../plugins/fpdf/fpdf.php';
include_once '../Database/Database.php';

session_start();
$db = new Database();
$conn = $db->getConnection();
Student::setConnection($conn);

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}
if ($_SESSION['role'] == 'instructor') {
    header("Location: ../");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $student = Student::find($_POST['id']);

    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->headerPDF();

    $pdf->SetFont('Arial', 'B', 30);
    $pdf->Cell(0, 10, 'STUDENT GRADE REPORT', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetLeftMargin(30);
    $pdf->SetRightMargin(30);

    if ($student) {
        // Custom student info layout
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(6, 31, 92);
        $pdf->SetDrawColor(6, 31, 92);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, 'STUDENT INFORMATION', 1, 1, 'C', true);
        $pdf->Ln(5);

        $labelWidth = 40;
        $valueWidth = 70;
        $gapWidth = 30;
        $i = 0;

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
                break;
        }

        $statusColor = ($student->status === 'active')
                    ? [0, 125, 0]
                    : [255, 0, 0];

        $studentInfo = [
            'Student ID' => $student->student_id,
            'Name' => $student->name,
            'Gender' => $student->gender,
            'Birthdate' => $student->birthdate,
            'Course' => $student->course()->code,
            'Year Level' => $year_level,
            'Status' => ucfirst($student->status),
        ];

        foreach ($studentInfo as $label => $value) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell($labelWidth, 10, $label . ':', 0, 0);

            $pdf->SetFont('Arial', '', 12);

            // Conditional text color for status
            if ($label === 'Status') {
                $pdf->SetTextColor(...$statusColor);
            }

            $pdf->Cell($valueWidth, 10, $value, 0, 0);

            $pdf->SetTextColor(0, 0, 0); // Reset after special case

            $i++;
            if ($i % 2 == 1) {
                $pdf->Cell($gapWidth, 10, '', 0, 0);
            }
            if ($i % 2 == 0) {
                $pdf->Ln(7);
            }
        }

        if ($i % 2 == 1) {
            $pdf->Ln(7); // Ensure line break if odd count
        }

        $pdf->Ln(5); // Space before subject table
    }


    if ($student) {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(6, 31, 92);
        $pdf->SetDrawColor(6, 31, 92);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, 'LIST OF SUBJECTS ENROLLED IN', 1, 1, 'C', true);
        // Subject Header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(6, 78, 59);
        $pdf->SetDrawColor(6, 78, 59);
        $pdf->SetTextColor(255, 255, 255);

        $pdf->Cell(10, 11, 'NO.', 1, 0, 'C', true);
        $pdf->Cell(40, 11, 'CATALOG NO.', 1, 0, 'C', true);
        $pdf->Cell(80, 11, 'SUBJECT NAME', 1, 0, 'C', true);
        $pdf->Cell(40, 11, 'SEMESTER', 1, 0, 'C', true);
        $pdf->Cell(30, 11, 'YEAR LEVEL', 1, 0, 'C', true);
        $pdf->Cell(40, 11, 'INSTRUCTOR', 1, 0, 'C', true);
        $pdf->Cell(30, 11, 'GRADE', 1, 0, 'C', true);
        $pdf->Cell(0, 11, 'REMARKS', 1, 0, 'C', true);
        $pdf->Ln(10);

        $id = 1;
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(0, 0, 0);

        if ($student->subjects() != null) {
        foreach ($student->subjects() as $subject) {
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(10, 10, $id++, 1, 0, 'C');
            $pdf->Cell(40, 10, $subject->catalog_no, 1, 0, 'C');
            $pdf->Cell(80, 10, $subject->name, 1, 0, 'C');

            switch ($subject->semester) {
                case 1:
                $semester = "1st Semester";
                break;
                case 2:
                $semester = "2nd Semester";
                break;
                default:
                $semester = "N/A";
                break;
            }
            
            $pdf->Cell(40, 10, $semester, 1, 0, 'C');

            switch ($subject->year_level) {
                case 1:
                $subject_year_level = "1st Year";
                break;
                case 2:
                $subject_year_level = "2nd Year";
                break;
                case 3:
                $subject_year_level = "3rd Year";
                break;
                case 4:
                $subject_year_level = "4th Year";
                break;
                default:
                $subject_year_level = "N/A";
                break;
            }
            
            $pdf->Cell(30, 10, $subject_year_level, 1, 0, 'C');

            $pdf->Cell(40, 10, $subject->instructor($subject->instructor_id)->name, 1, 0, 'C');

            $grade = Grade::getGrades($student->id, $subject->id);
            if (!$grade || !$grade->grade) {
                $pdf->SetFont('Arial', 'B', 6);
                $pdf->Cell(30, 10, 'NOT YET SUBMITTED', 1, 0, 'C');
            } else {
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(30, 10, $grade->grade, 1, 0, 'C');
            }

            if (!$grade) {
                $pdf->SetFont('Arial', 'B', 6);
                $pdf->Cell(0, 10, 'NOT YET SUBMITTED', 1, 0, 'C');
            } else {
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(0, 10, ucfirst($grade->remarks), 1, 0, 'C');
            }
            $pdf->Ln(10);
        }
        } else {
            $pdf->Ln(10);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetFont('Arial', 'B', 48);
            $pdf->Cell(0, 10, 'No subjects found', 0, 1, 'C');
        }
    } else {
        $pdf->Ln(10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetFont('Arial', 'B', 48);
        $pdf->Cell(0, 10, 'No student found', 0, 1, 'C');
    }

    $pdf->Output('I', 'student_report.pdf');
} else {
    header("Location: ../");
}
?>
