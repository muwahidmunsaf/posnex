<?php
    $errors = $errors ?? session('errors') ?? new \Illuminate\Support\ViewErrorBag;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo e(config('app.name', 'POS Login')); ?></title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            max-width: 400px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 2rem;
        }

        .login-card .form-control {
            border-radius: 8px;
        }

        .login-card .btn {
            border-radius: 8px;
        }

        .brand-logo {
            font-size: 2rem;
            font-weight: bold;
            color: #2c5364;
        }

        .form-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            padding-left: 2.5rem;
        }
    </style>
</head>

<body>
    <main>
        <div class="login-card">
            <div class="text-center mb-4">
                <div class="brand-logo text-center mb-3">
                    <img src="<?php echo e(asset('logo.png')); ?>" alt="Irshad Autos Logo" style="height: 60px;">
                    <h1 class="text-3xl font-bold text-center text-danger">Irshad Autos</h1>
                </div>
                <small class="text-muted">Please login to continue</small>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger py-1">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="small"><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-3 input-group">
                    <i class="bi bi-envelope form-icon"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required autofocus>
                </div>

                <div class="mb-3 input-group">
                    <i class="bi bi-lock form-icon"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-danger">Login <i class="bi bi-box-arrow-in-right ms-1"></i></button>
                </div>

                
            </form>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/auth/login.blade.php ENDPATH**/ ?>