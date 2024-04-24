<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro("base_response", function ($data=[], $code=200, $status="OK", $message="Success") {
            return response()->json([
                "code" => $code,
                "status" => $status,
                "message" => $message,
                "data" => $data,
            ], $code);
        });

        Response::macro("base_response_with_meta", function ($data = [], $meta = [], $code=200, $status="OK", $message="Success") {
            return response()->json([
                "code" => $code,
                "status" => $status,
                "message" => $message,
                "data" => $data,
                "meta" => $meta,
            ]);
        });
    }
}
