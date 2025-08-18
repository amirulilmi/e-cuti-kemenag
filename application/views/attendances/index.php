<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Attendance</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="page-body">
                    <div class="row">
                        <!-- Clock In/Out Card -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Today's Attendance</h5>
                                </div>
                                <div class="card-block text-center">
                                    <?php if($today_status): ?>
                                        <h3>Clocked In: <?= date('h:i A', strtotime($today_status->time_in)) ?></h3>
                                        <?php if($today_status->time_out): ?>
                                            <h3>Clocked Out: <?= date('h:i A', strtotime($today_status->time_out)) ?></h3>
                                        <?php else: ?>
                                            <button id="clock-out" class="btn btn-danger btn-lg">
                                                <i class="fa fa-sign-out"></i> Clock Out
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <button id="clock-in" class="btn btn-success btn-lg">
                                            <i class="fa fa-sign-in"></i> Clock In
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Monthly Report -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>This Month's Report</h5>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>In Time</th>
                                                    <th>Out Time</th>
                                                    <th>Total Hours</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($monthly_attendance as $att): ?>
                                                <tr>
                                                    <td><?= date('d M Y', strtotime($att->date)) ?></td>
                                                    <td><?= date('h:i A', strtotime($att->time_in)) ?></td>
                                                    <td>
                                                        <?= $att->time_out ? date('h:i A', strtotime($att->time_out)) : '-' ?>
                                                    </td>
                                                    <td><?= $att->total_hours ?: '-' ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#clock-in').click(function() {
        $.ajax({
            url: '<?= site_url("attendance/clock_in") ?>',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.status) {
                    Swal.fire('Success', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });
    
    $('#clock-out').click(function() {
        $.ajax({
            url: '<?= site_url("attendance/clock_out") ?>',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.status) {
                    Swal.fire('Success', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });
});
</script>