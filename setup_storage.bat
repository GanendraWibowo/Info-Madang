@echo off
echo Creating storage directories...
mkdir storage\app\public 2>nul

echo Setting permissions...
icacls storage\app\public /grant Users:(OI)(CI)F

echo Creating symbolic link...
php artisan storage:link

echo Creating images directory...
mkdir public\images 2>nul

echo Checking if default image exists...
if not exist public\images\default-product.jpg (
    echo Default product image does not exist!
    echo Please place default-product.jpg in public\images directory
) else (
    echo Default product image found
)

echo.
echo Setup complete! Please verify the following:
echo 1. storage/app/public directory exists
echo 2. public/storage symbolic link exists
echo 3. public/images/default-product.jpg exists
pause
