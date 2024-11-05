<?php
$backup_dir = 'backup/';
$files = array_diff(scandir($backup_dir), array('.', '..'));

// Sort files by modification time in descending order
$files = array_filter($files, function ($file) use ($backup_dir) {
    return is_file($backup_dir . $file);
});
usort($files, function ($a, $b) use ($backup_dir) {
    return filemtime($backup_dir . $b) - filemtime($backup_dir . $a);
});
?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Backup and Restore</h3>
            </div>
            <div class="title_right text-right">
                <button class="btn btn-primary backup">
                    <i class="fa fa-download"></i> Create New Backup
                </button>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Recent Restore Points</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Date</th>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($files): ?>
                                    <?php foreach ($files as $file): ?>
                                        <?php
                                        $file_path = $backup_dir . $file;
                                        ?>
                                        <tr class="text-center">
                                            <td><?= (new DateTime('@' . filemtime($file_path)))->format('F j, Y h:i A') ?></td>
                                            <td><?= $file ?></td>
                                            <td><?= round(filesize($file_path) / 1024, 2) ?> KB</td>
                                            <td>
                                                <button class="btn btn-sm btn-success restore_backup" data-filename="<?= $file ?>">
                                                    <i class="fa fa-history"></i> Restore
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>