<?php

namespace App\Http\Controllers;

use App\Services\InstagramService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(InstagramService $instagram): Response
    {
        return Inertia::render('Welcome', [
            'instagramPosts' => $instagram->getMediaFeed(12),
            'instagramUsername' => config('services.instagram.username', ''),
        ]);
    }
}
