<template>
    <div class="col-12 col-lg-7 col-xl-9" v-if="current == ''">
        <div class="h-100 no_current d-flex flex-column justify-content-center align-items-center " >
            <div class=" d-flex rounded flex-column justify-content-center align-items-center bg-white p-3 no_current_wrapper" style="height: calc(100vh - 72px)">
                <img src="/assets/errors/images/no-chats.png" height="150" width="150" alt="not-found">
                <h4 style="font-weight: 700">Airshop Chat System</h4>
                <p class="text-muted text-center">
                    Select a chat from the left panel or Start chat from product page.
                </p>
            </div>
        </div>
    </div>
    <div v-else class="col-12 col-lg-7 col-xl-9">
        <!-- d-none d-lg-block -->
        <div class="py-2 px-4 border-bottom ">
            <div class="d-flex align-items-center py-1">

                <div class="position-relative" v-if="auth_email == user_1.email">
                    <img :src="'/assets/images/user/profile/'+user_2.image" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-if="currentChat.user_2_type == 'user'" alt="Sharon Lessman" width="40" height="40">
                    <img :src="'/assets/images/seller/shop_logo/'+user_2.store_.logo" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-else alt="Sharon Lessman" width="40" height="40">
                </div>
                <div class="position-relative" v-else>
                    <img :src="'/assets/images/user/profile/'+user_1.image" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-if="currentChat.user_1_type == 'user'" alt="Sharon Lessman" width="40" height="40">
                    <img :src="'/assets/images/seller/shop_logo/'+user_1.store_.logo" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-else alt="Sharon Lessman" width="40" height="40">
                </div>

                <div class="flex-grow-1 pl-3" v-if="auth_email == user_1.email">
                    <strong>{{ user_2.firstname }} {{ user_2.lastname }}</strong>
                    <div class="text-muted small">{{ user_2.store_ ? user_2.store_.name : '' }}</div>
                </div>
                <div class="flex-grow-1 pl-3" v-else>
                    <strong>{{ user_1.firstname }} {{ user_1.lastname }}</strong>
                    <div class="text-muted small">{{ user_1.store_ ? user_1.store_.name : '' }}</div>
                </div>

                <div>
                    <button class="btn btn-primary mr-1 text-white px-3">
                        <i class="mdi mdi-paperclip"></i>
                    </button>
                    
                    <button v-on:click="toggleSidebar()" class="btn btn-light border px-3 d-inline d-lg-none d-xl-none"><i class="mdi mdi-menu"></i></button>
                </div>
            </div>
        </div>
        <div class="position-relative">
            <div class="chat-messages p-4 h-100 msg_container_base" id="msg_container">

                <div v-for="message in messages" :key="message.id" :class=" message.user == auth_email ? 'chat-message-right pb-4' : 'chat-message-left pb-4'">
                    <div class="" v-if="message.user == user_1.email">
                        <img :src="'/assets/images/user/profile/'+user_1.image" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-if="currentChat.user_1_type == 'user'" alt="Sharon Lessman" width="40" height="40">
                        <img :src="'/assets/images/seller/shop_logo/'+user_1.store_.logo" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-else alt="Sharon Lessman" width="40" height="40">
                        <div class="text-muted small text-nowrap mt-2">{{ momentAgo(message.created_at) }}</div>
                    </div>
                    <div class="" v-else>
                        <img :src="'/assets/images/user/profile/'+user_2.image" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-if="currentChat.user_2_type == 'user'" alt="Sharon Lessman" width="40" height="40">
                        <img :src="'/assets/images/seller/shop_logo/'+user_2.store_.logo" onerror="this.src='/assets/images/avatar.png'" class="rounded-circle mr-1" v-else alt="Sharon Lessman" width="40" height="40">
                        <div class="text-muted small text-nowrap mt-2">{{ momentAgo(message.created_at) }}</div>
                    </div>
                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                        <div class="font-weight-bold mb-1">{{message.user == auth_email ? 'You' : (user_1.email == message.user ? user_1.firstname + ' ' + user_1.lastname : user_2.firstname + ' ' + user_2.lastname)}}</div>
                        {{ message.message }}
                    </div>
                </div>

            </div>
        </div>

        <div class="flex-grow-0 py-3 px-4 border-top">
            <div class="input-group">
                <input type="text" v-model="msg" class="form-control" placeholder="Type your message">
                <button v-on:click="" v-if="isLoading" id="send_btn" disabled class="btn btn-primary">...</button>
                <button v-on:click="sendMessage()" v-else id="send_btn" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .no_current_wrapper {
        max-width: 380px;
        margin: 0 auto;
    }
</style>




<script>
import axios from 'axios'
import moment from 'moment'
import momentTZ from 'moment-timezone'
export default {
    props : ["auth_user", "auth_type", "auth_email", "current", "now"],
    data() {
        return {
            messages: [],
            currentChat: null,
            user_1: {},
            user_2: {},
            user_email : this.auth_email,
            msg : '',
            isLoading : false,
        }
    },
    methods: {
        sendMessage(){
            if(this.msg == '') return false;
            this.isLoading = true
            let self = this;
            axios.post(`/${this.auth_type}/live-chat/send-message/${this.current}`, {
                'msg' : self.msg
            }).then((response) => {
                self.getCurrent();
                self.loadChats();
                self.isLoading = false
                self.msg = ''
            }).catch((error) => {
                self.isLoading = false
                alert('unable to send your message')
            })
        },
        getCurrent(scroll = true){
            if(this.current == '') {
                this.messages = []
                this.currentChat = null
                return;
            }
            let self = this;
            var url = `/${this.auth_type}/live-chat/get-chat/${this.current}`
            axios.get(url)
            .then((response) =>{
                self.currentChat = response.data;
                self.user_1 = response.data.user1
                self.user_2 = response.data.user2
                self.messages = response.data.messages
                // $(".msg_container_base").stop().animate({ scrollTop: $(".msg_container_base")[0].scrollHeight}, 1); 
                if (scroll == true) this.scrollToButtom()
            })
            .catch((err)=>{
            })
        },
        loadChats(){
            let self = this;
            var url = `/${this.auth_type}/live-chat/load-chats`
            axios.get(url)
            .then((response) =>{
                if(response.data.status == true){
                    self.$root.$emit("chatLoaded", {chats: response.data.chats})
                }
            })
            .catch((err)=>{

            })
        },
        momentAgo(date){
            // var mmt = moment(date).utc(0).from(moment(this.now));
            var mmt = moment(date, moment.defaultFormat).fromNow()
            return mmt.replace('minutes', 'mins').replace('hours', 'hr').replace('seconds', 'sec').replace('day', 'd').replace('year', 'Y').replace('months', 'mo').replace('month', 'mo');
        },
        scrollToButtom(){
            setTimeout(() => {
            var objDiv = document.getElementById("msg_container");
            objDiv.scrollTop = objDiv.scrollHeight;
        }, 1000);
        },
        toggleSidebar(){
            this.$root.$emit("toggleSidebar")
        }
    },
    mounted() {
        this.loadChats()
        this.getCurrent()
        setInterval(() => {
            this.getCurrent(false)
            this.loadChats()        
        }, 10000);   
    },
}
</script>