@servers(['web' => ['rwkelapa@103.186.30.154 -p 2254']])

@story('dev')
    deploy-dev
    deploy-posyandu
@endstory

@task('optimize', ['on' => 'web'])
    cd /home/rwkelapa/warga08
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/rwkelapa/warga08
    git pull origin main
    composer dump-autoload
    php artisan config:clear
    php artisan cache:clear
    php artisan optimize
@endtask

@task('deploy-dev', ['on' => 'web'])
    cd /home/rwkelapa/dev
    git pull
    composer install
    php artisan migrate --force
@endtask

@task('deploy-posyandu', ['on' => 'web'])
    cd /home/rwkelapa/posyandu
    git pull
    composer install
    php artisan migrate --force
@endtask

@task('reset-dev', ['on' => 'web'])
    cd /home/rwkelapa/dev
    php artisan migrate:fresh --seed --force
@endtask

@task('update', ['on' => 'web'])
    cd /home/rwkelapa/warga08
    php artisan down
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan optimize
    php artisan up
@endtask