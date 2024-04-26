<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <form id="loginForm">
                            <!-- Login form fields -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="registerForm" style="display: none;">
                            <h5 class="card-title">Register</h5>
                            <form>
                                <!-- Registration form fields -->
                            </form>
                        </div>
                        <div class="mt-3">
                            <a href="#" onclick="toggleForm()">New user? Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        const toggleForm = () => {
            const registerForm = document.getElementById('registerForm');
            registerForm.style.display = registerForm.style.display === 'none' ? 'block' : 'none';
        };
    </script>