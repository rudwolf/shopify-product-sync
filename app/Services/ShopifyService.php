<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShopifyService
{
    private $shopUrl;
    private $accessToken;

    public function __construct()
    {
        $this->shopUrl = config('services.shopify.shop_url');
        $this->accessToken = config('services.shopify.access_token');
    }

    public function getProducts(): array
    {
        // For demo purposes, return mock data
        // In production, this would make actual API calls to Shopify
        return $this->getMockProducts();
    }

    private function getMockProducts(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Sample T-Shirt',
                'body_html' => '<p>A comfortable cotton t-shirt</p>',
                'status' => 'active',
                'variants' => [
                    [
                        'price' => '29.99',
                        'inventory_quantity' => 100
                    ]
                ]
            ],
            [
                'id' => 2,
                'title' => 'Sample Jeans',
                'body_html' => '<p>Classic denim jeans</p>',
                'status' => 'active',
                'variants' => [
                    [
                        'price' => '89.99',
                        'inventory_quantity' => 50
                    ]
                ]
            ],
            [
                'id' => 3,
                'title' => 'Sample Sneakers',
                'body_html' => '<p>Comfortable running sneakers</p>',
                'status' => 'active',
                'variants' => [
                    [
                        'price' => '129.99',
                        'inventory_quantity' => 25
                    ]
                ]
            ]
        ];
    }

    // Uncomment and configure for actual Shopify API integration
    /*
    private function makeShopifyRequest(string $endpoint): array
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->accessToken,
            'Accept' => 'application/json',
        ])->get("{$this->shopUrl}/admin/api/2023-10/{$endpoint}");

        if ($response->failed()) {
            throw new \Exception('Shopify API request failed: ' . $response->body());
        }

        return $response->json();
    }
    */
}
