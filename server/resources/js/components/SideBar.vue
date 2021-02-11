<template>
    <div class="card">
        <ul>
            <li class="side-bar-btn"><RouterLink to="/home">Search</RouterLink></li>
            <li class="side-bar-btn">Comunity</li>
            <li class="side-bar-btn">Like</li>
            <li class="side-bar-btn">Message</li>
            <li class="side-bar-btn"><RouterLink to="/home/profile">Profile</RouterLink></li>
            <li class="side-bar-btn">Etc</li>
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