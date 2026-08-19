@servers(['web' => ['gdzenesv@207.180.225.198']])

@story('dev')
    deploy-dev
    deploy-posyandu
@endstory

@task('optimize', ['on' => 'web'])
    cd /home/gdzenesv/warga08
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/gdzenesv/warga08
    git pull origin main
    php artisan optimize
@endtask

@task('deploy-dev', ['on' => 'web'])
    cd /home/gdzenesv/dev
    git pull
    composer install
    php artisan migrate --force
@endtask

@task('deploy-posyandu', ['on' => 'web'])
    cd /home/gdzenesv/posyandu
    git pull
    composer install
    php artisan migrate --force
@endtask

@task('reset-dev', ['on' => 'web'])
    cd /home/gdzenesv/dev
    php artisan migrate:fresh --seed --force
@endtask

@task('update', ['on' => 'web'])
    cd /home/gdzenesv/warga08
    php artisan down
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan optimize
    php artisan up
@endtask