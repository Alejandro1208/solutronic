public function boot()
{
    $this->configureRateLimiting();

    $this->routes(function () {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::middleware(['web', 'auth'])
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));
    });
}