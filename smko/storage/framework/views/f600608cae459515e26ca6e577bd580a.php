<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'SMKO'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body{background:#f8f9fc}.sidebar{min-height:100vh;background:#4e73df}.sidebar a{color:#fff;text-decoration:none;display:block;padding:.75rem 1rem;border-radius:.35rem}.sidebar a:hover,.sidebar a.active{background:rgba(255,255,255,.18)}.card{border:0;box-shadow:0 .15rem 1.75rem rgba(58,59,69,.12)}.brand{font-weight:800;color:#fff;font-size:1.1rem}.table td,.table th{vertical-align:middle}.topbar{height:64px;background:#fff;box-shadow:0 .15rem 1.75rem rgba(58,59,69,.08)}
    </style>
</head>
<body>
<div class="container-fluid"><div class="row">
    <?php if(auth()->guard()->check()): ?>
    <aside class="col-md-3 col-lg-2 sidebar p-3">
        <div class="brand mb-4"><i class="fa-solid fa-graduation-cap me-2"></i>SMKO</div>
        <?php ($role=auth()->user()->role); ?>
        <a href="/<?php echo e($role); ?>/dashboard"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a>
        <?php if($role==='admin'): ?>
            <a href="<?php echo e(route('admin.users.index')); ?>"><i class="fa-solid fa-users me-2"></i>Kelola User</a>
            <a href="<?php echo e(route('admin.courses.index')); ?>"><i class="fa-solid fa-book me-2"></i>Kursus</a>
            <a href="<?php echo e(route('admin.assignments.index')); ?>"><i class="fa-solid fa-list-check me-2"></i>Tugas</a>
            <a href="<?php echo e(route('admin.submissions.index')); ?>"><i class="fa-solid fa-file-lines me-2"></i>Submission</a>
            <a href="<?php echo e(route('admin.grades.index')); ?>"><i class="fa-solid fa-star me-2"></i>Rekap Nilai</a>
        <?php elseif($role==='guru'): ?>
            <a href="<?php echo e(route('guru.courses.index')); ?>"><i class="fa-solid fa-book me-2"></i>Kursus Saya</a>
            <a href="<?php echo e(route('guru.assignments.index')); ?>"><i class="fa-solid fa-list-check me-2"></i>Tugas</a>
            <a href="<?php echo e(route('guru.submissions.index')); ?>"><i class="fa-solid fa-file-lines me-2"></i>Submission</a>
            <a href="<?php echo e(route('guru.grades.index')); ?>"><i class="fa-solid fa-star me-2"></i>Rekap Nilai</a>
        <?php else: ?>
            <a href="<?php echo e(route('siswa.courses.index')); ?>"><i class="fa-solid fa-book-open me-2"></i>Daftar Kursus</a>
            <a href="<?php echo e(route('siswa.submissions.index')); ?>"><i class="fa-solid fa-upload me-2"></i>Submission Saya</a>
        <?php endif; ?>
    </aside>
    <?php endif; ?>
    <main class="<?php if(auth()->guard()->check()): ?> col-md-9 col-lg-10 <?php else: ?> col-12 <?php endif; ?> px-0">
        <?php if(auth()->guard()->check()): ?>
        <nav class="topbar d-flex align-items-center justify-content-between px-4 mb-4">
            <div><strong><?php echo $__env->yieldContent('title', 'SMKO'); ?></strong></div>
            <div class="d-flex align-items-center gap-3"><span><?php echo e(auth()->user()->name); ?> <span class="badge bg-primary"><?php echo e(auth()->user()->role); ?></span></span><form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-danger">Logout</button></form></div>
        </nav>
        <?php endif; ?>
        <div class="container-fluid px-4 pb-5">
            <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
            <?php if(session('error')): ?><div class="alert alert-danger"><?php echo e(session('error')); ?></div><?php endif; ?>
            <?php if($errors->any()): ?><div class="alert alert-danger"><strong>Validasi gagal:</strong><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div><?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>
</div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Folder Baru (2)\htdocs\2411537001_ArkanUbaidillahWarman_SMKO_Laravel\smko\resources\views/layouts/app.blade.php ENDPATH**/ ?>