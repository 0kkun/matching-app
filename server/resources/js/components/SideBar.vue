<template>
    <div class="card">
        <ul class="pl-3">
            <li class="side-bar-btn p-2"><RouterLink to="/home">Search</RouterLink></li>
            <li class="side-bar-btn p-2"><RouterLink to="/home/community">Community</RouterLink></li>
            <li class="side-bar-btn p-2"><RouterLink to="/home/like">Like</RouterLink></li>
            <li class="side-bar-btn p-2"><RouterLink to="/home/message">Message</RouterLink></li>
            <li class="side-bar-btn p-2"><RouterLink to="/home/profile">Profile</RouterLink></li>
        </ul>
    </div>
</template>

<script>
export default {
    
}
</script>

<style lang="scss" scoped>
ul {
    padding: 0;
}
.side-bar-btn {
    list-style: none;
    font-size: 18px;
    width: 100%;
}
</style>