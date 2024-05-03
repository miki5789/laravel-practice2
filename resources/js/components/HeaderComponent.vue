<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <router-link :to="{ name: 'product.index' }" class="navbar-brand mb-0 h1">
                    AMOZONA
                </router-link>
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
        }
        /*
        getCartQuantity() {
            const cartData = sessionStorage.getItem('cart');
            totalQuantity = this.cart.reduce((total, item) => total + item.quantity, 0);
            console.log("数量:", totalQuantity);
        }*/
        
    },
    beforeDestroy() {
        EventBus.$off('updateCartItemCount', this.updateCartItemCount);
    },
    async mounted() {
    }
}
</script>

<style>
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
