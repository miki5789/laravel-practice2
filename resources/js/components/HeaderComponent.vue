<template>
    <div class="container-fluid custom-bg mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <router-link :to="{ name: 'product.index' }" class="navbar-brand mb-0 h1">
                    AMOZONA
                </router-link>
                
                <!-- 検索バー -->
                
                <form class="form-inline" @submit.prevent="searchProducts">
                    <!-- Flexboxを使用して横並びにする -->
                    <input v-model="searchKeyword" class="form-control search-input" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light search-btn" type="submit">検索</button>
                </form>


                <!-- カートアイコン -->
                <div class="cart-icon-wrapper">
                    <router-link :to="{ name: 'cart' }">
                        <img :src="'/images/icon/cart.svg'" alt="Cart" class="cart-icon"/>
                        <span v-if="totalQuantity > 0" class="cart-badge">{{ totalQuantity }}</span>
                    </router-link>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
import { EventBus } from '../eventBus';
export default {

    data() {
        return {
            totalQuantity: 0,
            cartData: [],
            searchKeyword: '',
        };
    },
    created() {
        // イベントリスナーを登録
        EventBus.on('updateCartItemCount', this.updateCartItemCount);
    },
    methods: {
        
        updateCartItemCount(totalQuantity) {
            // カート内の商品の総数量を計算
            this.totalQuantity = totalQuantity;
            console.log("カート内の総数量:", totalQuantity);
        },
        async searchProducts() {
            // キーワードをスペースで分割
            const keywords = this.searchKeyword.trim().split(/\s+/);
            /*
            try {
                const response = await fetch(`/api/product/search`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ keywords })
                });
                const data = await response.json();
                console.log("検索結果:", data);
                
                // クエリパラメータとしても表示
                this.$router.push({ name: 'product.search', query: { results: JSON.stringify(data) } });
            } catch (error) {
                console.error("検索中にエラーが発生しました:", error);
            }
            */
            this.$router.push({ name: 'product.search', query: { keywords } });
        }
    },

    beforeDestroy() {
        EventBus.$off('updateCartItemCount', this.updateCartItemCount);
    },
    async mounted() {
    }
}
</script>

<style>
/* カスタムのヘッダースタイル */
.custom-bg {
    background-color: #9ACD32; /* 黄緑色に設定 */
    padding: 10px 0; /* 上下のパディングを追加 */
}

.form-inline {
    display: flex; /* 子要素を横並びにする */
    align-items: center; /* 垂直方向で中央揃え */
}

.search-btn {
    min-width: 100px; /* ボタンの最小幅を設定 */
    padding: 5px 15px; /* ボタンの内部パディングを調整 */
}

.cart-icon-wrapper {
    position: relative;
    display: inline-block;
}

.cart-badge {
    position: absolute;
    top: -10px; /* 位置を調整 */
    left: 0px; /* 位置を調整 */
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%; /* 〇で囲む */
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 20px; /* バッジの最小サイズ */
    height: 20px; /* バッジの高さ */
    box-shadow: 0px 0px 6px rgba(0,0,0,0.3);
}

.cart-icon {
    width: 32px; /* アイコンのサイズ調整 */
    height: auto;
}

</style>
