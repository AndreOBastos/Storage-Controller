<template>
    <div class="container">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link to="/" class="nav-link">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/create" class="nav-link">Store a Product</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/products" class="nav-link">Products</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/history" class="nav-link">Change History</router-link>
                </li>
            </ul>
        </nav><br />
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s
}
.fade-enter, .fade-leave-active {
    opacity: 0
}
</style>

<script>

export default{
}
</script>
