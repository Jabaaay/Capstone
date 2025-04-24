<!DOCTYPE html>
<html lang="en">

<head>
    {{-- ... existing head content ... --}}
    <title>Admin Dashboard - Psychological Test System</title>
    

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.sideLayout')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card mb-4 py-3 border-left-primary">
                        <div class="card-body">
                            <b>Instructions:</b> Make sure your webcam is enabled, and stay in a well-lit environment for accurate detection.
                            Answer honestly and remain focused throughout the test. Your facial expressions will be
                            recorded in real-time for analysis. All collected data is strictly confidential.
                        </div>
                    </div>

                    <div class="max-w-2xl mx-auto p-6">
                        <form action="{{ route('user.test.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="form-group">
                                <label>First Name</label>
                                {{-- Display user's first name, disable input --}}
                                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ Auth::user()->first_name }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                {{-- Display user's last name, disable input --}}
                                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ Auth::user()->last_name }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="college" class="block text-sm font-medium text-gray-700">College</label><br>
                                <select id="college" name="college" required class="form-control">
                                    <option value="">Select College</option>
                                    {{-- Add College of Technology and College of Public Administration --}}
                                    <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                                    <option value="College of Business Administration">College of Business Administration</option>
                                    <option value="College of Education">College of Education</option>
                                    <option value="College of Technology">College of Technology</option> {{-- Added --}}
                                    <option value="College of Nursing">College of Nursing</option>
                                    <option value="College of Public Administration">College of Public Administration</option> {{-- Added --}}
                                    {{-- Remove College of Engineering if not needed, or add its courses to JS --}}
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="course" class="block text-sm font-medium text-gray-700">Course</label><br>
                                <select id="course" name="course" class="form-control" required>
                                    {{-- Course options will be populated by JavaScript --}}
                                    <option value="">Select College First</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Age</label>
                                {{-- Remove duplicate 'required' attribute --}}
                                <input type="number" id="age" name="age" required min="18" max="100" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="tel" id="contact_number" name="contact_number" class="form-control" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sex</label>
                                <div class="mt-1 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="sex" value="male" required>
                                        <span class="ml-2">Male</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="sex" value="female" required>
                                        <span class="ml-2">Female</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                {{-- Display user's email, disable input --}}
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="form-control" disabled>
                            </div>

                             <!-- Checkbox with Modal Trigger -->
                             <div class="form-group d-flex justify-content-between align-items-center">
                                <div>
                                    <input type="checkbox" id="terms_accepted" name="terms_accepted" value="1" required>
                                    <label for="accepted_terms">I agree that my face and voice will be recorded for analysis.</label>
                                </div>
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#termsModal">View Terms</button>
                            </div>

                            <!-- Terms and Conditions Modal -->
                            <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>1. Data Collection:</strong> Your face and voice will be recorded for analysis.</p>
                                            <p><strong>2. Privacy:</strong> Your data will be kept confidential and used only for research purposes.</p>
                                            <p><strong>3. Voluntary Participation:</strong> You can withdraw anytime before the analysis starts.</p>
                                            <p><strong>4. Security:</strong> All stored data is encrypted and protected.</p>
                                            <p>By proceeding, you agree to these terms.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block">Proceed to Test</button>
                            <br>
                        </form>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            {{-- @include('layouts.footer') --}} {{-- Assuming footer exists --}}
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <script>
        // College to Course Mapping
        const coursesByCollege = {
            "College of Technology": [
                "Bachelor of Science in Information Technology",
                "Bachelor of Science in Entertainment and Multimedia Computing major in Digital Animation Technology Game Development",
                "Bachelor of Science in Automotive Technology",
                "Bachelor of Science in Electronics Technology",
                "Bachelor of Science in Food Technology"
            ],
            "College of Business Administration": [
                "Bachelor of Science in Accountancy",
                "Bachelor of Science in Business Administration Major in Financial Management",
                "Bachelor of Science in Hospitality Management"
            ],
            "College of Education": [
                "Bachelor of Elementary Education",
                "Bachelor of Secondary Education Major in Mathematics",
                "Bachelor of Secondary Education Major in Filipino",
                "Bachelor of Secondary Education Major in English",
                "Bachelor of Secondary Education Major in Social Studies",
                "Bachelor of Secondary Education, Major in Science",
                "Bachelor of Early Childhood Education",
                "Bachelor of Physical Education"
            ],
            "College of Arts and Sciences": [
                "Bachelor of Science in Biology Major in Biotechnology",
                "Bachelor of Arts in English Language",
                "Bachelor of Arts in Economics",
                "Bachelor of Arts in Sociology",
                "Bachelor of Arts in Philosophy",
                "Bachelor of Arts in Social Science",
                "Bachelor of Science in Mathematics",
                "Bachelor of Science in Community Development",
                "Bachelor of Science in Development Communication"
            ],
            "College of Nursing": [
                "Bachelor of Science in Nursing"
            ],
            "College of Public Administration": [
                "Bachelor of Public Administration Major in Local Governance"
            ]
            // Add other colleges like "College of Engineering" here if needed
        };

        // Get references to the select elements
        const collegeSelect = document.getElementById('college');
        const courseSelect = document.getElementById('course');

        // Add event listener to the college dropdown
        collegeSelect.addEventListener('change', function() {
            const selectedCollege = this.value;
            // Clear existing course options
            courseSelect.innerHTML = '';

            // Add default placeholder option
            const defaultOption = document.createElement('option');
            defaultOption.value = "";
            if (selectedCollege && coursesByCollege[selectedCollege]) {
                 defaultOption.textContent = "Select Course";
            } else {
                 defaultOption.textContent = "Select College First";
                 defaultOption.disabled = true; // Disable if no college selected or no courses found
            }
             courseSelect.appendChild(defaultOption);


            // Populate with new courses if a college is selected and has courses defined
            if (selectedCollege && coursesByCollege[selectedCollege]) {
                const courses = coursesByCollege[selectedCollege];
                courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course;
                    option.textContent = course;
                    courseSelect.appendChild(option);
                });
                courseSelect.disabled = false; // Enable the course select
            } else {
                 courseSelect.disabled = true; // Disable if no courses
            }
        });

         // Trigger change event on page load if a college might be pre-selected (optional)
        // collegeSelect.dispatchEvent(new Event('change'));

         // Initialize datatables if needed (kept from original code)
        $(document).ready(function() {
            $('#dataTable').DataTable();
             // Initial state for course dropdown
            if (!collegeSelect.value) {
                courseSelect.disabled = true;
            }
        });
    </script>

</body>

</html>