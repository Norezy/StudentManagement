<footer></footer>    
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.2.2/af-2.7.0/b-3.2.2/b-colvis-3.2.2/b-html5-3.2.2/b-print-3.2.2/cr-2.0.4/date-1.5.5/fc-5.0.4/fh-4.0.1/kt-2.12.1/r-3.0.4/rg-1.5.1/rr-1.5.0/sc-2.4.3/sb-1.8.2/sp-2.3.3/sl-3.0.0/sr-1.4.1/datatables.min.js" integrity="sha384-10kTwhFyUU637a6/7q0kLBdo8jQWjxteg63DT/K8Sdq/nCDaDAkH+Nq/MIrsp8wc" crossorigin="anonymous"></script>
     


    <script>
    $(document).ready( function () {
        $('#usersTable thead th').css('background-color', '#064e3b')
        var table = $('#usersTable').DataTable({
            dom: '<"d-flex justify-content-between mb-2"lf>t<"d-flex justify-content-between mt-2" ip>'
        });
    });
    </script>

        <script>
                $(document).ready(function() {
                    $('#enrollsubTable thead th').css('background-color', '#064e3b');
                    
                    var table = $('#enrollsubTable').DataTable({
                        dom: `
                            <"top-section d-flex justify-content-between mb-2"lf>
                            <"custom-text-row"T>
                            t
                            <"d-flex justify-content-between mt-2"ip>
                        `,
                        initComplete: function() {
                            // Style the custom text row (full-width background)
                            $('.custom-text-row').html(`
                                <div style="
                                    background-color: #112c75;
                                    color: white;
                                    padding: 0.75rem;
                                    text-align: center;
                                    padding-top: 2vh;
                                    padding-bottom: 2vh;
                                    border-top: 4px;
                                    border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                    <strong>LIST OF STUDENTS ENROLLED IN THIS SUBJECT</strong>
                                </div>
                            `);
                            
                            // Style the top row (lf controls)
                            $('.top-section').css('margin-bottom', '10px');
                        }
                    });
                });
        </script>

        <script>
                $(document).ready(function() {
                    $('#listEnrollTable thead th').css('background-color', '#064e3b');
                    
                    var table = $('#listEnrollTable').DataTable({
                        dom: `
                            <"top-section d-flex justify-content-between mb-2"lf>
                            <"custom-text-row"T>
                            t
                            <"d-flex justify-content-between mt-2"ip>
                        `,
                        initComplete: function() {
                            // Style the custom text row (full-width background)
                            $('.custom-text-row').html(`
                                <div style="
                                    background-color: #112c75;
                                    color: white;
                                    padding: 0.75rem;
                                    text-align: center;
                                    padding-top: 2vh;
                                    padding-bottom: 2vh;
                                    border-top: 4px;
                                    border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                    <strong>LIST OF SUBJECTS ENROLLED IN</strong>
                                </div>
                            `);
                            
                            // Style the top row (lf controls)
                            $('.top-section').css('margin-bottom', '10px');
                        }
                    });
                });
        </script>

        <script>
                $(document).ready(function() {
                    $('#CourseTable thead th').css('background-color', '#064e3b');
                    
                    var table = $('#CourseTable').DataTable({
                        dom: `
                            <"top-section d-flex justify-content-between mb-2"lf>
                            <"custom-text-row"T>
                            t
                            <"d-flex justify-content-between mt-2"ip>
                        `,
                        initComplete: function() {
                            // Style the custom text row (full-width background)
                            $('.custom-text-row').html(`
                                <div style="
                                    background-color: #112c75;
                                    color: white;
                                    padding: 0.75rem;
                                    text-align: center;
                                    padding-top: 2vh;
                                    padding-bottom: 2vh;
                                    border-top: 4px;
                                    border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                    <strong>LIST OF STUDENTS ENROLLED IN THIS COURSE</strong>
                                </div>
                            `);
                            
                            // Style the top row (lf controls)
                            $('.top-section').css('margin-bottom', '10px');
                        }
                    });
                });
        </script>

        <script>
                $(document).ready(function() {
                    $('#InstructorTable thead th').css('background-color', '#064e3b');
                    
                    var table = $('#InstructorTable').DataTable({
                        dom: `
                            <"top-section d-flex justify-content-between mb-2"lf>
                            <"custom-text-row"T>
                            t
                            <"d-flex justify-content-between mt-2"ip>
                        `,
                        initComplete: function() {
                            // Style the custom text row (full-width background)
                            $('.custom-text-row').html(`
                                <div style="
                                    background-color: #112c75;
                                    color: white;
                                    padding: 0.75rem;
                                    text-align: center;
                                    padding-top: 2vh;
                                    padding-bottom: 2vh;
                                    border-top: 4px;
                                    border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                    <strong>LIST OF ASSIGNED SUBJECT</strong>
                                </div>
                            `);
                            
                            // Style the top row (lf controls)
                            $('.top-section').css('margin-bottom', '10px');
                        }
                    });
                });
        </script>
  
</body>
</html>