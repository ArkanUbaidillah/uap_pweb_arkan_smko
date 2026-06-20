<?php $__env->startSection('title', 'Detail Kursus'); ?>

<?php $__env->startSection('content'); ?>
<?php ($role = auth()->user()->role); ?>

<div class="container-fluid px-4">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4 mt-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-1"><?php echo e($course->name); ?> <span class="badge bg-secondary"><?php echo e($course->code); ?></span></h4>
                    <p class="mb-1 text-muted">Guru Pengampu: <strong><?php echo e($course->teacher->name); ?></strong></p>
                    <p class="mb-0 text-secondary"><?php echo e($course->description ?? 'Tidak ada deskripsi kursus.'); ?></p>
                </div>
                <div>
                    
                    <?php if($role === 'siswa'): ?>
                        <?php ($enrollment = $course->enrollments->where('student_id', auth()->id())->first()); ?>
                        <?php if($enrollment): ?>
                            <form method="POST" action="<?php echo e(url('/siswa/enrollments/' . $enrollment->id)); ?>" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan kelas ini?')">
                                <?php echo csrf_field(); ?> 
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i> Batalkan Enroll
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>

                    
                    <a href="<?php echo e(url('/' . $role . '/courses')); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fas fa-tasks me-1"></i> Daftar Tugas Kuliah</span>
                    
                    
                    <?php if($role === 'guru' && $course->teacher_id === auth()->id()): ?>
                        <a href="<?php echo e(url('/guru/assignments/create?course_id=' . $course->id)); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Tugas
                        </a>
                    <?php endif; ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Batas Pengumpulan</th>
                                <th class="text-center" style="width: 250px;">Aksi / Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $course->assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary d-block"><?php echo e($assignment->title); ?></span>
                                        <small class="text-muted"><?php echo e(Str::limit($assignment->description, 70)); ?></small>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-bold small">
                                            <?php echo e($assignment->due_date instanceof \Carbon\Carbon ? $assignment->due_date->format('d M Y, H:i') : \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i')); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        
                                        <?php if($role === 'siswa'): ?>
                                            <?php ($isEnrolled = $course->enrollments->where('student_id', auth()->id())->count()); ?>
                                            
                                            <?php if($isEnrolled): ?>
                                                <?php ($submission = $assignment->submissions->where('student_id', auth()->id())->first()); ?>
                                                
                                                <?php if($submission): ?>
                                                    <span class="badge bg-success p-2 mb-1 d-inline-block"><i class="fas fa-check-circle me-1"></i> Sudah Mengumpul</span>
                                                    <?php if($submission->score !== null): ?>
                                                        <span class="badge bg-info text-dark p-2 d-inline-block">Nilai: <strong><?php echo e($submission->score); ?></strong></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning text-dark p-2 d-inline-block">Belum Dinilai</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    
                                                    <form action="<?php echo e(url('/siswa/submissions')); ?>" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-1 justify-content-center">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="assignment_id" value="<?php echo e($assignment->id); ?>">
                                                        <input type="file" name="file_path" class="form-control form-control-sm" style="max-width: 150px;" required>
                                                        <button type="submit" class="btn btn-sm btn-primary">Kumpul</button>
                                                    </form>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted small">Silakan enroll kelas terlebih dahulu</span>
                                            <?php endif; ?>

                                        
                                        <?php elseif($role === 'guru' || $role === 'admin'): ?>
                                            <a href="<?php echo e(url('/' . $role . '/assignments/' . $assignment->id)); ?>" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-eye me-1"></i> Pantau Pengumpulan
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open d-block mb-2 fa-2x"></i>
                                        Belum ada tugas yang diterbitkan di kelas ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light fw-bold text-secondary">
                    <i class="fas fa-users me-1"></i> Mahasiswa Terdaftar (<?php echo e($course->enrollments->count()); ?>)
                </div>
                <ul class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                    <?php $__empty_1 = true; $__currentLoopData = $course->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="list-group-item d-flex align-items-center py-2">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 35px; height: 35px; font-size: 13px; font-weight: bold;">
                                <?php echo e(strtoupper(substr($e->student->name, 0, 2))); ?>

                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-bold text-dark d-block" style="font-size: 14px;"><?php echo e($e->student->name); ?></span>
                                <small class="text-muted" style="font-size: 11px;">
                                    Mulai: <?php echo e(\Carbon\Carbon::parse($e->enrolled_at)->format('d/m/Y H:i')); ?>

                                </small>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item text-muted text-center py-4">
                            <i class="fas fa-user-slash d-block mb-2 fa-lg"></i>
                            Belum ada mahasiswa di kelas ini.
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Folder Baru (2)\htdocs\2411537001_ArkanUbaidillahWarman_SMKO_Laravel\smko\resources\views/2411537001_ArkanUbaidillahWarman_courses/show.blade.php ENDPATH**/ ?>