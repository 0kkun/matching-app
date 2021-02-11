import './bootstrap'
import Vue from 'vue'
import router from './router'

// blade上のどのダグに、どのコンポーネントを使用するかを定義
document.addEventListener('DOMContentLoaded', function() {
    // idが無い場合はVueインスタンスを作成しないようにする
    if (document.getElementById("app")) {
        const mobile = new Vue({
            el: '#app',
            router: router
        });
    }
}, false);
export default router