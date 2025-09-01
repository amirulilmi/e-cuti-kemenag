<div class="row users-card">
    <?php if (!empty($staffList)): ?>
        <?php foreach ($staffList as $staff): ?>
            <?php
            $imgPath = (!empty($staff['image_path']) && file_exists(FCPATH . ltrim($staff['image_path'], '/')))
                ? base_url($staff['image_path'])
                : base_url('uploads/images/default-avatar.jpg');
            $fullName = $staff['first_name'] . ' ' . $staff['last_name'];
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card user-card" style="position: relative; overflow: hidden;">
                    <div class="card-block">
                        <div class="user-image" style="position: relative;">
                            <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($fullName) ?>" class="img-radius staff-photo"
                                style="width:235px; height:250px; border-radius:5%; display:block; margin:0 auto;">
                            <span class="hover-buttons" style="position: absolute;top:0;left:0;width:100%;height:100%;
                                background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;
                                gap:6px;opacity:0;transition:opacity 0.3s ease;">
                                <a href="<?= site_url('staff/profile/' . $staff['emp_id'] . '?view=2') ?>"
                                    class="btn btn-sm btn-primary">
                                    <i class="icofont icofont-eye-alt"></i>
                                </a>
                                <a href="<?= site_url('staff/form/' . $staff['emp_id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="icofont icofont-edit"></i>
                                </a>
                                <?php if ($staff['designation'] !== 'Admin'): ?>
                                    <a href="#" class="btn btn-sm btn-danger delete-staff" data-id="<?= $staff['emp_id'] ?>">
                                        <i class="icofont icofont-ui-delete"></i>
                                    </a>
                                <?php endif; ?>
                            </span>
                        </div>
                        <h6 style="margin-top: 10px;"><?= htmlspecialchars($fullName) ?></h6>
                        <p class="text-muted"><?= htmlspecialchars($staff['designation']) ?></p>
                        <p><?= htmlspecialchars($staff['email_id']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- <div class="col-12"><p>No staff found.</p></div> -->
        <div class="col-sm-12 text-center">
            <img src="<?= base_url('files/assets/images/no_data.png') ?>" class="img-radius" alt="No Data Found"
                style="width: 200px; height: auto;">
        </div>
    <?php endif; ?>
</div>