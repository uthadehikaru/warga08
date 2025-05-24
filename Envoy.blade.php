@servers(['web' => ['rwkelapa@103.186.30.154 -p 2254']])
 
@task('optimize', ['on' => 'web'])
    cd /home/rwkelapa/warga08
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/rwkelapa/warga08
    git pull origin main
    php artisan optimize
@endtask

@task('deploy-dev', ['on' => 'web'])
    cd /home/rwkelapa/dev
    git pull
    composer install
    php artisan migrate
    php artisan optimize
@endtask

@task('reset-dev', ['on' => 'web'])
    cd /home/rwkelapa/dev
    php artisan migrate:fresh --seed
    php artisan optimize
@endtask

@task('update', ['on' => 'web'])
    cd /home/rwkelapa/warga08
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan optimize
@endtask