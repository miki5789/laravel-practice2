<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <router-link :to="{ name: 'product.index' }" class="navbar-brand mb-0 h1">
                    AMOZONA
                </router-link>
                <div>
                    <router-link :to="{ name: 'cart' }">
                        <img :src="'images/icon/cart.svg'" alt="Logo" />
                    </router-link>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {}
</script>