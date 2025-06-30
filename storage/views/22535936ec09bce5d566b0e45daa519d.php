<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SriTravel - Sign Up</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            900: '#1E3A8A',
                            800: '#1E40AF',
                            700: '#1E4BB5',
                            600: '#2563EB',
                            500: '#3B82F6',
                        },
                        accent: {
                            500: '#3B82F6',
                            600: '#2563EB',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        heading: ['Playfair Display', 'serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8fafc;
            z-index: 0;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://jetwingtravels.com/wp-content/uploads/2024/01/home-desctop.jpg') no-repeat center center;
            background-size: cover;
            filter: brightness(0.5);
            z-index: -1;
        }

        .wrapper {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 500px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }

        .wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, #2563EB, #3B82F6);
        }

        .home-icon {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            font-size: 1.5rem;
            color: #3B82F6;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .home-icon:hover {
            transform: scale(1.1);
            color: #2563EB;
        }

        .input-box {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .input-box label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1E3A8A;
            font-size: 0.875rem;
        }

        .input-box input, .input-box select {
            width: 100%;
            padding: 0.875rem 2.5rem 0.875rem 1.25rem;
            border-radius: 0.5rem;
            border: 2px solid #c7d2fe;
            outline: none;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            background-color: #e0e7ff;
        }

        .input-box input:focus, .input-box select:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background-color: white;
        }

        .input-box .icon {
            position: absolute;
            right: 0.9375rem;
            top: 55px;
            transform: translateY(-50%);
            color: #6366f1;
            font-size: 1rem;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.8125rem;
            margin-top: 0.3125rem;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 0.3125rem;
            font-size: 0.875rem;
        }

        .terms-box {
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
        }

        .terms-box input {
            margin-right: 0.5rem;
            width: 1.25rem;
            height: 1.25rem;
            accent-color: #3B82F6;
        }

        .terms-box label {
            font-size: 0.875rem;
            color: #1E3A8A;
        }

        .terms-box a {
            color: #2563EB;
            text-decoration: none;
            font-weight: 600;
        }

        .terms-box a:hover {
            color: #1E40AF;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .wrapper {
                padding: 1.875rem 1.25rem;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <a href="/" class="home-icon"><i class="fas fa-home"></i></a>

    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>
        <h2 class="text-2xl md:text-3xl font-bold font-heading text-gray-800 text-center mb-8 relative after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-1 after:bg-blue-600 after:rounded">
            Create Your Account
        </h2>

        <div class="input-box">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus placeholder="Enter your full name">
            <span class="icon"><i class="fas fa-user"></i></span>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="input-box">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="Enter your email">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="input-box">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required placeholder="Create a password">
            <span class="icon"><i class="fas fa-lock"></i></span>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="input-box">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm your password">
            <span class="icon"><i class="fas fa-lock"></i></span>
            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="terms-box">
            <input id="terms" type="checkbox" name="terms" required>
            <label for="terms">
                I agree to the <a href="/terms">Terms and Conditions</a>
            </label>
            <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center hover:scale-105">
            <i class="fas fa-user-plus mr-2"></i> Sign Up
        </button>

        <div class="text-center mt-5 text-gray-600 text-sm">
            <p>Already have an account? <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold relative after:content-[''] after:absolute after:bottom-[-2px] after:left-0 after:w-full after:h-0.5 after:bg-blue-600 after:scale-x-0 after:origin-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-left">Sign in here</a></p>
        </div>
    </form>
</div>
</body>
</html><?php /**PATH D:\fproject\project\project\sritravel\sritravel\resources\views/auth/register.blade.php ENDPATH**/ ?>