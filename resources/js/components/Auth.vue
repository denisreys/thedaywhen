<template>
    <div class="px-5 mt-4 sm:w-[500px] sm:m-auto flex flex-col flex-1">
        <div class="m-auto justify-self-center flex">
            <div class="m-auto">
                remember<br/>
                every day
            </div>
        </div>
        <div class="justify-self-end mb-4">
            <div class="bg-mylightgray relative px-3 py-2 rounded flex">
                <div class="w-full">
                    <input type="text" ref="usernameInput" class="!bg-transparent w-full placeholder:text-gray-500" placeholder="username" name="username" v-model="authForm.username" @input="inputUsername()" @keydown.enter="this.$refs.passwordInput.focus()">
                </div>
                <div class="flex-1">
                    <svg v-if="saving && !authForm.password.length" class="w-4 h-4 animate-spin align-middle mt-[3px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
            </div>
            <div class="bg-mylightgray relative px-3 py-2 rounded flex mt-3">
                <div class="w-full">
                    <input type="password" ref="passwordInput" class="!bg-transparent w-full placeholder:text-gray-500" placeholder="password" name="password" v-model="authForm.password" @keydown.enter="submit()">
                </div>
                <div class="flex-1">
                    <svg v-if="saving && authForm.password.length" class="w-4 h-4 animate-spin align-middle mt-[3px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <template v-else>
                        <button v-if="authForm.registered" class="px-1 pt-[1px] pb-[2px] h-[22px] bg-main text-white rounded text-sm" @click="submit()">
                            <template v-if="authForm.registered == 'yes'">login</template> 
                            <template v-else-if="authForm.registered == 'no'">register</template> 
                        </button>
                    </template>
                </div>
            </div>
            <div class="p-2 text-sm lowercase text-gray-400">
                <span v-for="error in authForm.messages" class="transition ease-in-out delay-150">{{ error[0] }}</span>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref } from 'vue';
    import axios from 'axios';

    let autoCheckTimer;
    const saving = ref(false);
    const authForm = ref({
        registered: false,
        username: '',
        password: '',
        errors: '',
        messages: 'register or login right here'
    });
    
    function inputUsername()
    {
        saving.value = true;

        if(autoCheckTimer){
            clearTimeout(autoCheckTimer);
        }

        if(authForm.value.username.length){
            authForm.value.errors = authForm.value.registered = false;

            autoCheckTimer = setTimeout(() => {
                axios.post('/auth/checkusername', {
                    username: authForm.value.username
                })
                .then(response => {
                    authForm.value.errors = '';
                    authForm.value.registered = response.data;
                })
                .catch(error => {
                    console.log(error);
                    if(error.response.status == 422){
                        authForm.value.errors = error.response.data.errors;
                        
                    }
                })
                .finally(function () {
                    saving.value = false;
                    updateMessages();
                });
            }, 1500);
        }
        else {
            authForm.value.errors = authForm.value.registered = authForm.value.password = '';
            saving.value = false;
            updateMessages();
        }
    }
    function updateMessages(){
        if(authForm.value.errors) authForm.value.messages = authForm.value.errors;
        else if(authForm.value.registered == 'yes') authForm.value.messages = 'great, now you can log in';
        else if(authForm.value.registered == 'no') authForm.value.messages = 'great, now you can register';
        else authForm.value.messages = 'registration or login';
    }
    function submit(){
        saving.value = true;
        
        let url = '/auth/';
        if(authForm.value.registered == 'yes') url += 'login';
        else if(authForm.value.registered == 'no') url += 'register';

        axios.post(url, {
            username: authForm.value.username,
            password: authForm.value.password,
        })
        .then(response => {
            if(response.data.token){
                localStorage.setItem('token', response.data.token);
                window.location.replace("/");
            }
            else {
                authForm.value.errors = 'an error occurred, try again';
                saving.value = false;
            }
        })
        .catch(error => {
            if(error.response.status == 422){
                authForm.value.errors = error.response.data.errors;
            }
        })
        .finally(function () {
            saving.value = false;
            updateMessages();
        });
    }
</script>