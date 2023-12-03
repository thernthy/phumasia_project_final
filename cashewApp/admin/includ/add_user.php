<div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Add Producer</h4>
                    </div>
                    <div class="card-body">
                        <form id="addProducerForm">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="place">Place:</label>
                                <select class="form-control" name="place" id="place" required>
                                    <option value="">Select Place</option>
                                    <option value="phumasia">Phumasia</option>
                                    <option value="scy">SCY</option>
                                    <option value="moni village">Moni's House</option>
                                    <option value="spk village">Spk village</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control" name="role" id="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="producer">Producer</option>
                                </select>
                            </div>
                            <div id="passwordField" class="form-group" style="display: none;">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <button class="btn btn-success mt-3">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        // Show/hide the password field based on the selected role
        document.getElementById('role').addEventListener('change', function() {
            var passwordField = document.getElementById('passwordField');
            if (this.value === 'admin' || this.value === 'user') {
                passwordField.style.display = 'block';
            } else {
                passwordField.style.display = 'none';
            }
        });
        $(document).ready(function() {
            // Submit the form using AJAX
            $('#addProducerForm').submit(function(event) {
                event.preventDefault(); // Prevent the form from submitting normally
                // Get the form data
                var formData = $(this).serialize();
                // Send the form data to add_user_form_control.php
                $.ajax({
                    type: 'POST',
                    url: 'includ/add_user_form_control.php',
                    data: formData,
                    success: function(response) {
                        // Display the response message
                        alert(response);

                        // Reset the form
                        $('#addProducerForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        // Display an error message
                        alert('Error: ' + error);
                    }
                });
            });
        });
</script>