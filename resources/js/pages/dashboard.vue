<template>
<div class="container row">
    <div class=" col-10 offset-md-3">
        <div class="chat card">
	    	<div class="scrollable card-body" ref="hasScrolledToBottom">
	            <template v-for="message in messages">
	                <div class="message message-receive" v-if="(user.id != message.sender_id) && message.sender_id">
	                    <p class="d-flex justify-content-start">
	                        <strong class="primary-font">
	                            {{ message.user.name }} :
	                        </strong>
	                        {{ message.message }}
	                    </p>
	                </div>
	                <div class="message message-send" v-else>
	                    <p class="d-flex justify-content-end">
	                        <strong class="primary-font">
	                            {{ message.user.name }} :
	                        </strong>
	                        {{ message.message }}
	                    </p>
	                </div>
	            </template>
	        </div>

	        <div class="chat-form input-group">
	            <input id="btn-input" type="text" name="message" class="form-control input-sm message-" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="addMessage()">

	            <span class="input-group-btn">
	                <button class="btn btn-primary" id="btn-chat" @click="addMessage()">
	                    Send
	                </button>
	            </span>
	        </div>

	    </div>
    </div>
</div>
</template>

<script>
import $axios from 'axios';
import { reactive, inject,ref, onMounted,onUpdated } from 'vue';
export default {
    name: 'Dashboard',
    data: () => ({
        messages: ref([]),
        newMessage: ref([]),
        hasScrolledToBottom: ref([]),
        user: null,
        
    }),
    beforeCreate() {
        let ref = this;
        if (!window.Laravel.isLogin) {
            // window.location.href = "/login"; 
            ref.$router.push({name: 'Login'});
        }
    },

    created() {
        $axios.post('api/messages').then(res => {
            if (res.data.status == 200) {
                this.messages = res.data.data;
                // this.user = res.data.user;
            }
        });
        this.user = window.Laravel.user;
        window.Echo.private("newMessage").listen("sendMessage", e => {
            this.messages.push(e.message);
        });
    },
    methods: {
        addMessage() {
            var userMessage = { 'user': this.user, 'message': this.newMessage };
            $axios.post('api/messageStore', { 'message': this.newMessage })
                .then(res => {
                    if (res.data.status == 200) {
                        this.messages.push(userMessage);
                    }
                })
            this.newMessage = '';
        }
    },
    mounted() {
        // this.fetchMessages();
    },
    updated() {
        // this.scrollBottom();
    }

}
</script>
<style scoped>

</style>