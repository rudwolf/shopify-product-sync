<template>
    <div class="product-sync">
        <div class="header">
            <h1>Shopify Product Sync</h1>
            <button @click="syncProducts" :disabled="syncing" class="sync-btn">
                {{ syncing ? 'Syncing...' : 'Sync Products' }}
            </button>
        </div>

        <div v-if="message" :class="messageClass">
            {{ message }}
        </div>

        <div class="products-grid">
            <div v-for="product in products" :key="product.id" class="product-card">
                <h3>{{ product.title }}</h3>
                <p class="price">${{ product.price }}</p>
                <p class="inventory">Stock: {{ product.inventory_quantity }}</p>
                <p class="status" :class="product.status">{{ product.status }}</p>
                <p class="sync-date">
                    Last synced: {{ formatDate(product.synced_at) }}
                </p>
            </div>
        </div>

        <div v-if="pagination.last_page > 1" class="pagination">
            <button @click="loadPage(pagination.current_page - 1)" :disabled="pagination.current_page <= 1">
                Previous
            </button>
            <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
            <button @click="loadPage(pagination.current_page + 1)"
                :disabled="pagination.current_page >= pagination.last_page">
                Next
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProductSync',
    data() {
        return {
            products: [],
            pagination: {
                current_page: 1,
                last_page: 1,
                total: 0
            },
            syncing: false,
            message: '',
            messageType: 'info'
        }
    },
    computed: {
        messageClass() {
            return `message ${this.messageType}`;
        }
    },
    mounted() {
        this.loadProducts();
    },
    methods: {
        async loadProducts(page = 1) {
            try {
                const response = await fetch(`/api/products?page=${page}`);
                const data = await response.json();

                this.products = data.products;
                this.pagination = data.pagination;
            } catch (error) {
                this.showMessage('Failed to load products', 'error');
            }
        },
        async syncProducts() {
            this.syncing = true;
            this.message = '';

            try {
                const response = await fetch('/api/products/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    this.showMessage(`Successfully synced ${data.synced_count} products`, 'success');
                    this.loadProducts();
                } else {
                    this.showMessage(data.error, 'error');
                }
            } catch (error) {
                this.showMessage('Sync failed', 'error');
            } finally {
                this.syncing = false;
            }
        },
        loadPage(page) {
            this.loadProducts(page);
        },
        showMessage(text, type = 'info') {
            this.message = text;
            this.messageType = type;
            setTimeout(() => {
                this.message = '';
            }, 5000);
        },
        formatDate(dateString) {
            if (!dateString) return 'Never';
            return new Date(dateString).toLocaleDateString();
        }
    }
}
</script>

<style scoped>
.product-sync {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.sync-btn {
    background: #007cba;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.sync-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.message {
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.message.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.message.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: white;
}

.product-card h3 {
    margin: 0 0 10px 0;
    color: #333;
}

.price {
    font-size: 1.2em;
    font-weight: bold;
    color: #007cba;
    margin: 5px 0;
}

.inventory,
.sync-date {
    color: #666;
    font-size: 0.9em;
    margin: 5px 0;
}

.status {
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.8em;
    text-transform: uppercase;
}

.status.active {
    background: #d4edda;
    color: #155724;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
}

.pagination button {
    padding: 8px 15px;
    border: 1px solid #ddd;
    background: white;
    cursor: pointer;
    border-radius: 4px;
}

.pagination button:disabled {
    background: #f5f5f5;
    cursor: not-allowed;
}
</style>
