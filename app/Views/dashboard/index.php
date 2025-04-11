<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header bg-info text-white">
        <h3 class="card-title mb-0">Dashboard</h3>
    </div>
    <div class="card-body">
        <h4>Welcome, <?= esc($username) ?>!</h4>
        <p>You are logged in with email: <?= esc($email) ?></p>
        
        <div id="profile-data" class="mt-4">
            <h5>Your Profile Data (from API):</h5>
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div id="profile-info" class="d-none">
                <!-- Profile info will be loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Fetch user profile data from API
        $.ajax({
            url: '/api/profile',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('.spinner-border').hide();
                $('#profile-info').removeClass('d-none');
                
                const user = response.user;
                let html = `
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>${user.id}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>${user.username}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>${user.email}</td>
                        </tr>
                    </table>
                `;
                
                $('#profile-info').html(html);
            },
            error: function(xhr) {
                $('.spinner-border').hide();
                const response = JSON.parse(xhr.responseText);
                $('#profile-info').removeClass('d-none').html(
                    `<div class="alert alert-danger">${response.messages}</div>`
                );
            }
        });
    });
</script>
<?= $this->endSection() ?>