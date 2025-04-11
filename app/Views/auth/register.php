<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title mb-0">Register</h3>
            </div>
            <div class="card-body">
                <div id="error-message" class="alert alert-danger d-none"></div>
                
                <form id="register-form">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success">Register</button>
                </form>
                
                <div class="mt-3">
                    <p>Already have an account? <a href="/login">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#register-form').submit(function(e) {
            e.preventDefault();
            
            const username = $('#username').val();
            const email = $('#email').val();
            const password = $('#password').val();
            
            $.ajax({
                url: '/api/register',
                type: 'POST',
                data: {
                    username: username,
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    window.location.href = '/login';
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    let errorMsg = '';
                    
                    if (typeof response.messages === 'object') {
                        for (const key in response.messages) {
                            errorMsg += response.messages[key] + '<br>';
                        }
                    } else {
                        errorMsg = response.messages;
                    }
                    
                    $('#error-message').removeClass('d-none').html(errorMsg);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>