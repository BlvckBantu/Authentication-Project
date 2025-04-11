<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Login</h3>
            </div>
            <div class="card-body">
                <div id="error-message" class="alert alert-danger d-none"></div>
                
                <form id="login-form">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                
                <div class="mt-3">
                    <p>Don't have an account? <a href="/register">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#login-form').submit(function(e) {
            e.preventDefault();
            
            const username = $('#username').val();
            const password = $('#password').val();
            
            $.ajax({
                url: '/api/login',
                type: 'POST',
                data: {
                    username: username,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    window.location.href = '/dashboard';
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    $('#error-message').removeClass('d-none').text(response.messages);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>