<template>
    <div>
        <button type="button" class="btn m-0 p-1 shadow-none">
            <i class="fas fa-heart mr-1"
                :class="{'red-text':this.isLikedByUser}"
                @click="clickLike"
            />
        </button>
        {{ countLikes }}
    </div>
</template>

<script>
    export default {
        props: {
            initialIsLikedByUser: {
                type: Boolean,
                default: false,
            },
            initialCountLikes: {
                type: Number,
                default: 0,
            },
            authorized: {
                type: Boolean,
                default: false,
            },
            endpoint: {
                type: String,
            },
        },
        data() {
            return {
                isLikedByUser: this.initialIsLikedByUser,
                countLikes: this.initialCountLikes,
            }
        },
        methods: {
            clickLike() {
                if(!this.authorized) {
                    alert('いいね機能はログイン中のみ使用できます')
                    return
                }

                this.isLikedByUser ? this.unlike() : this.like()
            },
            async like() {
                const response = await axios.put(this.endpoint)

                this.isLikedByUser = true
                this.countLikes = response.data.countLikes
            },
            async unlike() {
                const response = await axios.delete(this.endpoint)

                this.isLikedByUser = false
                this.countLikes = response.data.countLikes
            },
        },
    }
</script>

