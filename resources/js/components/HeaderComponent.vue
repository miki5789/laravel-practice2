<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <span class="navbar-brand mb-0 h1">AMOZONA</span>
                <div>
                    <router-link :to="{ name: 'product.index' }">
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