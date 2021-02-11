<template>
    <div class="card">
        <ul>
            <li class="side-bar-btn"><RouterLink to="/home">Search</RouterLink></li>
            <li class="side-bar-btn"><RouterLink to="/home/community">Community</RouterLink></li>
            <li class="side-bar-btn"><RouterLink to="/home/like">Like</RouterLink></li>
            <li class="side-bar-btn"><RouterLink to="/home/message">Message</RouterLink></li>
            <li class="side-bar-btn"><RouterLink to="/home/profile">Profile</RouterLink></li>
        </ul>
    </div>
</template>

<script>
export default {
    
}
</script>

<style lang="scss" scoped>
.side-bar-btn {
    list-style: none;
    margin:  0;
    padding: 0;
}
</style>