<template>
    <div class="col-12 col-lg-5 col-xl-3 border-right recent-chats" :class="toggleActive ? 'active' : ''" v-if="isLoading">

    </div>
    <div v-else class="col-12 col-lg-5 col-xl-3 border-right recent-chats" :class="toggleActive ? 'active' : ''">
        <a v-for="chat in recent_chats" :key="chat.id" class="list-group-item list-group-item-action border-0" :href="'/'+auth_type+'/live-chat/'+chat.hash" :class="current == '' ? '' : (chat.hash == current ? 'active' : '')">
            <div class="badge bg-primary text-white float-right" v-if="chat.unread.length > 0">{{ chat.unread.length }}</div>
            <div class="d-flex align-items-start" v-if="chat.user1.email == auth_email">
                    <img :src="'/assets/images/user/profile/'+chat.user2.image" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-if="chat.user_2_type == 'user'" alt="Sharon Lessman" width="40" height="40">
                    <img :src="'/assets/images/seller/shop_logo/'+chat.user2.store_.logo" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-else alt="Sharon Lessman" width="40" height="40">
                <div class="flex-grow-1 ml-3">
                    {{ chat.user2.firstname}} {{ chat.user2.lastname}}
                    <div v-if="chat.messages.length > 0">
                        <div class="small"><span class="fas fa-circle chat-online"></span> {{ chat.messages[chat.messages.length - 1].message }}</div>
                    </div>
                    <div v-else class="small"><span class="fas fa-circle chat-online"></span> Start conversation</div>
                </div>
            </div>
            <div class="d-flex align-items-start" v-else>
                <img :src="'/assets/images/user/profile/'+chat.user1.image" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-if="chat.user_1_type == 'user'" alt="Sharon Lessman" width="40" height="40">
                <img :src="'/assets/images/seller/shop_logo/'+chat.user1.store_.logo" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-else alt="Sharon Lessman" width="40" height="40">
                <div class="flex-grow-1 ml-3">
                    {{chat.user1.firstname}} {{chat.user1.lastname}}
                    <div v-if="chat.messages.length > 0">
                        <div class="small"><span class="fas fa-circle chat-online"></span> {{ chat.messages[chat.messages.length - 1].message }}</div>
                    </div>
                    <div v-else class="small"><span class="fas fa-circle chat-online"></span> Start conversation</div>
                </div>
            </div>
        </a>
        <div v-if="recent_chats.length ==0" class="text-center h-100 d-flex justify-content-center align-items-center flex-column">
            <img src="/assets/errors/images/no-chats.png" height="100" width="100" alt="not-found">
            <h6>No chat history found</h6>
        </div>
	    <hr class="d-block d-lg-none mt-1 mb-0">
    </div>
</template>


<script>
export default {
    props : ["auth_email", "auth_type", "auth_user", "current"],
    data() {
        return {
            recent_chats : [],
            isLoading : true,
            toggleActive : false,
        }
    },
    mounted() {
        this.$root.$on("chatLoaded", (res)=>{
            this.recent_chats = res.chats
            this.isLoading = false
        })
        this.$root.$on("toggleSidebar", ()=>{
            this.toggleActive = !this.toggleActive
        })
    },
}
</script>