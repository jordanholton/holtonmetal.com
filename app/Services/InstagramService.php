<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Instagram Graph API Service
 *
 * ─────────────────────────────────────────────────────────────────
 * HOW TO GET YOUR ACCESS TOKEN
 * ─────────────────────────────────────────────────────────────────
 *
 * 1. Convert your Instagram account to a Business or Creator account:
 *    Instagram → Settings → Account → Switch to Professional Account
 *
 * 2. Connect it to a Facebook Page (required by Meta):
 *    Instagram → Settings → Account → Linked Accounts → Facebook
 *
 * 3. Go to https://developers.facebook.com and create a new App
 *    (choose: Business → Consumer or Business type)
 *
 * 4. In your App dashboard, add the "Instagram Graph API" product.
 *
 * 5. Under Instagram Graph API → Generate Access Token:
 *    - Select your Instagram Business account
 *    - Grant permissions: instagram_basic, instagram_content_publish (optional)
 *
 * 6. Exchange the short-lived token for a long-lived token (60 days):
 *    GET https://graph.instagram.com/access_token
 *        ?grant_type=ig_exchange_token
 *        &client_id={APP_ID}
 *        &client_secret={APP_SECRET}
 *        &access_token={SHORT_LIVED_TOKEN}
 *
 * 7. Add the token to your .env:
 *    INSTAGRAM_ACCESS_TOKEN=your_token_here
 *    INSTAGRAM_USERNAME=your_handle (e.g. holtonmetal)
 *
 * 8. Refresh the token before it expires (within 60 days):
 *    GET https://graph.instagram.com/refresh_access_token
 *        ?grant_type=ig_refresh_token
 *        &access_token={LONG_LIVED_TOKEN}
 *
 *    Consider setting up a scheduled command to auto-refresh.
 * ─────────────────────────────────────────────────────────────────
 */
class InstagramService
{
    private const BASE_URL = 'https://graph.instagram.com';
    private const CACHE_KEY = 'instagram_feed';
    private const CACHE_TTL = 3600; // 1 hour in seconds

    private string $accessToken;

    public function __construct()
    {
        $this->accessToken = config('services.instagram.access_token', '');
    }

    public function isConfigured(): bool
    {
        return ! empty($this->accessToken);
    }

    /**
     * Fetch the most recent media posts from the Instagram Graph API.
     * Results are cached for 1 hour to avoid hitting rate limits.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getMediaFeed(int $limit = 12): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () use ($limit) {
            try {
                $response = Http::timeout(10)->get(self::BASE_URL.'/me/media', [
                    'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp',
                    'limit' => $limit,
                    'access_token' => $this->accessToken,
                ]);

                if ($response->successful()) {
                    return $response->json('data', []);
                }

                Log::warning('Instagram API error', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return [];
            } catch (\Exception $e) {
                Log::error('Instagram API exception', ['message' => $e->getMessage()]);

                return [];
            }
        });
    }
}
