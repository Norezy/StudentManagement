<script>
function ConfirmLogout(){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to Logout?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Logout",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = document.createElement("form");
                        form.method = "POST";
                        form.action = "/SMS/auth/logout.php";  // The PHP file that will handle the logout

                        // Optionally, add a hidden input field if you need to send extra data
                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "logout";
                        input.value = "true";  // A flag to indicate the user confirmed logout
                        form.appendChild(input);

                        // Append the form to the body and submit it
                        document.body.appendChild(form);
                        form.submit();

                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "Logout has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c"
                        }).then(function() {
                            window.location = "/SMS/";
                        });
                    }
             });
            }
</script>
<!-- Users Functions -->
<script>
        function DeluserConfirm(bID){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to delete this User record?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "User Record has been deleted!",
                            icon: "success",
                            iconColor: "#0b7b55"
                        })
                        .then(function() { 
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'destroy.php';

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'id';
                            input.value = bID;

                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        });
                        
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "User record deletion has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c"
                        })
                        .then(function() {
                            window.location = "index.php";
                        });
                    }
             });
        }
            
        function InstructorReport() {
            Swal.fire({
                title: "Generate Record PDF",
                text: "Do you want to generate instructor's record?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0b7b55',
                cancelButtonColor: 'red'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit via POST to open in a new tab
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../reports/users_report.php';
                    form.target = '_blank';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'role';
                    input.value = 'instructor';

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        }

        function UsersReport(){
            Swal.fire({
                title: "Generate Record PDF",
                text: "Select the role you want to generate report",
                icon: 'question',
                input: 'select',
                inputOptions: {
                    'all': 'All Users',
                    'instructor': 'Instructors',
                    'admin': 'Admins'
                },
                showCancelButton: true,
                cancelButtonColor: 'red',
                confirmButtonColor: 'green'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value === 'all') {
                        // Create a form and submit via POST to open in a new tab
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '../reports/users_report.php';
                        form.target = '_blank';

                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'role';
                        input.value = 'all';

                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                        document.body.removeChild(form);
                    } else {
                        const role = result.value;
                        // Create a form and submit via POST to open in a new tab
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '../reports/users_report.php';
                        form.target = '_blank';

                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'role';
                        input.value = role;

                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                        document.body.removeChild(form);
                    }
                }
            });
        }
        
        function ViewUsersReport(userId) {
            Swal.fire({
                title: "Generate Record PDF",
                text: "Do you want to generate this user's record?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0b7b55',
                cancelButtonColor: 'red'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../reports/view_users_report.php';
                    form.target = '_blank';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = userId;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        }

        function ViewProfileReport(userId) {
            Swal.fire({
                title: "Generate Record PDF",
                text: "Do you want to generate Your Assigned Subject Record?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0b7b55',
                cancelButtonColor: 'red'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../reports/profile_report.php';
                    form.target = '_blank';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = userId;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        }

        
</script>

<!-- Student Functions -->

<script>
        function DelStudentConfirm(bID){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to delete this Subject record?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Subject Record has been deleted!",
                            icon: "success",
                            iconColor: "#0b7b55"
                        })
                        .then(function() { 
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'destroy.php';

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'id';
                            input.value = bID;

                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        });
                        
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "Subject record deletion has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c"
                        })
                        .then(function() {
                            window.location = "index.php";
                        });
                    }
             });
            }

        function StudentReport() {
            Swal.fire({
            title: "Generate Record PDF",
            text: "Select the year level to generate student report",
            icon: 'question',
            input: 'select',
            inputOptions: {
                'all': 'All Year Levels',
                '1': '1st Year',
                '2': '2nd Year',
                '3': '3rd Year',
                '4': '4th Year'
            },
            inputValue: 'all',
            showCancelButton: true,
            confirmButtonText: 'Generate',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#0b7b55',
            cancelButtonColor: 'red'
            }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../reports/student_report.php';
                form.target = '_blank';

                const inputYear = document.createElement('input');
                inputYear.type = 'hidden';
                inputYear.name = 'year_level';
                inputYear.value = result.value;

                form.appendChild(inputYear);
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
            });
        }

        function ViewStudentRecord(studentId) {
            Swal.fire({
                title: "Generate Record PDF",
                text: "Do you want to generate this student's record?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0b7b55',
                cancelButtonColor: 'red'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../reports/view_student_report.php';
                    form.target = '_blank';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = studentId;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        }
</script>

<!-- activate and deactivate user/student -->

<script>
        function ActivateUser(status,id){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to Activate This User?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#0b7b55",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Activate",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Success!",
                            text: "User has been Activated",
                            icon: "success",
                            iconColor: "#0b7b55"
                        })
                        .then(function() { 
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'index.php';

                            const inputStatus = document.createElement('input');
                            inputStatus.type = 'hidden';
                            inputStatus.name = 'status';
                            inputStatus.value = status;

                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'id';
                            inputId.value = id;

                            form.appendChild(inputStatus);
                            form.appendChild(inputId);

                            document.body.appendChild(form);
                            form.submit();
                        });
                        
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "User Activation has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c"
                        })
                        .then(function() {
                            window.location = "index.php";
                        });
                    }
             });
        }

        function DeactivateUser(status,id){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to Deactivate This User?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#808080",
                    cancelButtonColor: "#0b7b55",
                    confirmButtonText: "Deactivate",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Success!",
                            text: "User Status has been Deacativated",
                            icon: "success",
                            iconColor: "#0b7b55"
                        })
                        .then(function() { 
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'index.php';

                            const inputStatus = document.createElement('input');
                            inputStatus.type = 'hidden';
                            inputStatus.name = 'status';
                            inputStatus.value = status;

                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'id';
                            inputId.value = id; // Replace 'user_id' with the actual user ID variable

                            form.appendChild(inputStatus);
                            form.appendChild(inputId);

                            document.body.appendChild(form);
                            form.submit();
                        });
                        
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "User Deactivation has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c"
                        })
                        .then(function() {
                            window.location = "index.php";
                        });
                    }
             });
        }
</script>


<!-- Course Functions -->
<script>
        function DelCourseConfirm(bID){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to delete this Course record?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Course Record has been deleted!",
                            icon: "success",
                            iconColor: "#0b7b55"
                        })
                        .then(function() { 
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'destroy.php';

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'id';
                            input.value = bID;

                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        });
                        
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "Course record deletion has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c",
                        })
                        .then(function() {
                            window.location = "index.php";
                        });
                    }
             });
            }

        function ViewCourseReport(courseId) {
            Swal.fire({
                title: "Generate Record PDF",
                text: "Select the year level to generate course report",
                icon: 'question',
                input: 'select',
                inputOptions: {
                    'all': 'All Year Levels',
                    '1': '1st Year',
                    '2': '2nd Year',
                    '3': '3rd Year',
                    '4': '4th Year'
                },
                inputValue: 'all',
                showCancelButton: true,
                confirmButtonText: 'Generate',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0b7b55',
                cancelButtonColor: 'red'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../reports/view_course_report.php';
                    form.target = '_blank';

                    const inputYear = document.createElement('input');
                    inputYear.type = 'hidden';
                    inputYear.name = 'year_level';
                    inputYear.value = result.value;

                    const inputCourse = document.createElement('input');
                    inputCourse.type = 'hidden';
                    inputCourse.name = 'id';
                    inputCourse.value = courseId;

                    form.appendChild(inputYear);
                    form.appendChild(inputCourse);
                    
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        }

        function CourseReport() {
            Swal.fire({
                title: "Generate Record PDF",
                text: "Do you want to generate list of courses?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0b7b55',
                cancelButtonColor: 'red'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../reports/course_report.php';
                    form.target = '_blank';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'course';
                    input.value = 'course';
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        }

</script>
<!-- Subject Functions -->
<script>
        function DelSubjectConfirm(bID){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to delete this Subject record?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Subject Record has been deleted!",
                            icon: "success",
                            iconColor: "#0b7b55"
                        })
                        .then(function() { 
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'destroy.php';

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'id';
                            input.value = bID;

                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        });
                        
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "Subject record deletion has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c"
                        })
                        .then(function() {
                            window.location = "index.php";
                        });
                    }
             });
            }

        function AssignedSubjectReport(InstrucID) {
            Swal.fire({
                title: "Generate Record PDF",
                text: "Do you want to generate subject's record?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0b7b55',
                cancelButtonColor: 'red'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../reports/assigned_subject_report.php';
                    form.target = '_blank';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = InstrucID;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        }

        function SubjectReport() {
            Swal.fire({
            title: "Generate Record PDF",
            text: "Select the semester to generate subject report",
            icon: 'question',
            input: 'select',
            inputOptions: {
                'all': 'All Semesters',
                '1': '1st Semester',
                '2': '2nd Semester'
            },
            inputValue: 'all',
            showCancelButton: true,
            confirmButtonText: 'Generate',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#0b7b55',
            cancelButtonColor: 'red'
            }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../reports/subject_report.php';
                form.target = '_blank';

                const inputSemester = document.createElement('input');
                inputSemester.type = 'hidden';
                inputSemester.name = 'semester';
                inputSemester.value = result.value;

                form.appendChild(inputSemester);
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
            });
        }
        
</script>
<!-- Subject Enrollment Functions -->
<script>
        function DelStudEnrollRecordConfirm(eID,cID){
            Swal.fire({
                    title: "Warning!",
                    text: "Are you sure you want to delete this Student Record?",
                    icon: "warning",
                    iconColor: "#d97706",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Student Record has been deleted!",
                            icon: "success",
                            iconColor: "#0b7b55"
                        })
                        .then(function() { 
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'subject_enrollment/destroy.php?id='+cID;

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'id';
                            input.value = eID;

                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        });
                        
                    } else if (result.isDismissed) {
                        Swal.fire({
                            title: "Canceled!",
                            text: "Student record deletion has been canceled",
                            icon: "error",
                            iconColor: "#b91c1c"
                        })
                        .then(function() {
                            window.location = "view.php?id="+cID;
                        });
                    }
             });
            }
</script>