<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-2">
                <div class="card">
                    <div class="card-header">Chat Room</div>

                    <div id="chat-box" class="card-body bg-secondary ">
                        <div v-for="chat in messages" :key="chat.id" 
                        class="media bg-light rounded mb-3">
                            <div class="media-body m-2">
                                <h5 class="mt-0">{{ chat.user.name }}</h5>
                                {{ chat.message }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="form-group">
                            <input v-model="message" @keydown="typingEvent()" @keyup.enter="sendMessage()" type="text" name="" class="form-control">
                        </div>
                        <p class="text-muted" v-if="userTyping">{{ userTyping.name }} typing ....</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        User Online
                    </div>
                    <div class="card-body bg-secondary" id="user-online">
                        <div class="list-group">
                            <li class="list-group-item mb-2" 
                            v-for="(user,index) in users " :key="index"
                            > {{ user.name }} </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-10">
                <form @submit.prevent="getDataFromQuery()" class="d-flex">
                    <input type="text" v-model="search" class="form-control d-inline">
                    <button class="btn btn-success ml-3">Go!</button>
                </form>

                <div class="products">
                    <ul>
                        <li v-for="(product,index) in products" :key="index">
                            {{ product }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
</template>

<script>
    export default {
        data(){
            return {
                message : '',
                messages :[],
                users: [],
                userTyping : false,
                //-----------------------
                search :'',
            }
        },

        props: {
            user : Object,
        },

        methods :{
         
            fetchMessage()
            {
                axios.get('/fetch')
                .then((result) => {
                    this.messages = result.data;
                }).catch((err) => {
                    console.log(err);
                })
            },

            typingEvent(){
                Echo.join('chat')
                    .whisper('typing', this.user);
            },

            sendMessage(){
                this.messages.push({
                    user : this.user,
                    message : this.message
                });
                
                axios.post('/send',{
                    message : this.message
                })
                .then((result) => {
                    console.log(result)
                })
                .catch((err) => {
                    console.log(err);
                })
            
                this.message = '';

            },

            scrollDown(){
                let container = document.getElementById('chat-box');
                let scrollHeight = container.scrollHeight;

                container.scrollTop = scrollHeight;
            }
        },
        mounted() {

            this.fetchMessage();
            // console.log('Component mounted.')
            Echo.join('chat')
                .here((users) => {
                    this.users  = users;
                })
                .joining((user) => {
                    this.users.push(user);
                })
                .leaving((user) => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('ChatSent',(e) => {
                    this.messages.push(e.message);
                })
                .listenForWhisper('typing', (user) => {
                    console.log('wefwefwef');
                    // this.userTyping = user;

                    // setTimeout(function(){
                    //     this.userTyping = false;
                    // },2000)
                })
                
            
            // this.scrollDown();
        },
        updated(){
            this.scrollDown();
        }
    }
</script>

<style lang="css" scoped>
    #chat-box{
        overflow: auto;
        height: 300px;
    }
</style>