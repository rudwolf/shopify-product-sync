<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ShopifyService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ShopifyController extends Controller
{
    protected $shopifyService;

    public function __construct(ShopifyService $shopifyService)
    {
        $this->shopifyService = $shopifyService;
    }

    public function syncProducts(): JsonResponse
    {
        try {
            $shopifyProducts = $this->shopifyService->getProducts();
            $syncedCount = 0;

            foreach ($shopifyProducts as $shopifyProduct) {
                Product::updateOrCreate(
                    ['shopify_id' => $shopifyProduct['id']],
                    [
                        'title' => $shopifyProduct['title'],
                        'description' => $shopifyProduct['body_html'] ?? '',
                        'price' => $shopifyProduct['variants'][0]['price'] ?? 0,
                        'inventory_quantity' => $shopifyProduct['variants'][0]['inventory_quantity'] ?? 0,
                        'status' => $shopifyProduct['status'],
                        'synced_at' => now(),
                    ]
                );
                $syncedCount++;
            }

            return response()->json([
                'message' => 'Products synced successfully',
                'synced_count' => $syncedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getShopifyProducts(): JsonResponse
    {
        try {
            $products = $this->shopifyService->getProducts();
            return response()->json(['products' => $products]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch Shopify products: ' . $e->getMessage()
            ], 500);
        }
    }
}
