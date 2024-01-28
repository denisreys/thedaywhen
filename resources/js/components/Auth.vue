<template>
    <div class="px-5 mt-4 sm:w-[500px] sm:m-auto flex flex-col flex-1 fixed sm:relative bottom-0 h-full w-full">
        <div class="m-auto justify-self-center flex flex-1">
            <div class="m-auto">
                remember<br/>
                every day
            </div>
        </div>
        <div class="justify-self-end mb-4 sticky bottom-0">
            <div class="bg-block-bg dark:bg-block-bg--dark border border-block-border dark:border-block-border--dark relative px-3 py-2 rounded-md flex">
                <div class="w-full">
                    <input 
                        type="text"
                        autocapitalize="none" 
                        class="!bg-transparent w-full placeholder:text-small-text dark:placeholder:text-small-text--dark xs:h-7" 
                        placeholder="имя пользователя" 
                        name="username" 
                        @input="event => authForm.username = event.target.value"
                        @keydown.enter="this.$refs.passwordInput.focus()"
                    >
                </div>
                <div class="flex-1">
                    <svg v-if="saving && !authForm.password.length" class="w-4 h-4 xs:w-5 xs:h-5 animate-spin align-middle mt-[3px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
            </div>
            <div class="bg-block-bg dark:bg-block-bg--dark border border-block-border dark:border-block-border--dark relative px-3 py-2 rounded-md flex mt-3">
                <div class="w-full">
                    <input 
                        autocapitalize="none"
                        type="password" 
                        ref="passwordInput" 
                        class="!bg-transparent w-full dark:placeholder:text-small-text--dark xs:h-7" 
                        placeholder="пароль" 
                        name="password" 
                        v-model="authForm.password" 
                        @keydown.enter="submit()"
                    >
                </div>
                <div class="flex-1">
                    <svg v-if="saving && authForm.password.length" class="w-4 h-4 xs:w-5 xs:h-5 animate-spin align-middle mt-[3px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <template v-else>
                        <button v-if="!saving && authForm.username" class="px-1 pt-[1px] pb-[2px] h-[22px] xs:h-6 bg-main text-white dark:!text-text--dark rounded-md text-sm" @click="submit()">
                            <template v-if="authForm.registered">вход</template> 
                            <template v-else>регистрация</template> 
                        </button>
                    </template>
                </div>
            </div>
            <div class="text-sm xs:text-base mt-2 lowercase text-small-text dark:text-small-text--dark">
                <template v-if="authForm.errors">
                    <span v-for="error in authForm.errors">{{ error[0] }}</span>
                </template>
                <span v-else>{{ authForm.messages }}</span>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref, watch } from 'vue';
    import axios from 'axios';

    let userCheckTimer;
    const saving = ref(false);
    const authForm = ref({
        registered: false,
        username: '',
        password: '',
        errors: '',
        messages: 'регистрация или вход'
    });
    
    watch(() => authForm.value.username, (username) => {
        saving.value = true;

        if(userCheckTimer) clearTimeout(userCheckTimer);
        
        if(username.length) {
            authForm.value.errors = '';
            authForm.value.registered = false;

            userCheckTimer = setTimeout(() => {
                axios.post('/auth/checkusername', {
                    username: authForm.value.username
                })
                .then(response => {
                    authForm.value.registered = response.data;
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
            }, 1000);
        }
        else {
            authForm.value.errors = authForm.value.registered = authForm.value.password = '';
            saving.value = false;
            updateMessages();
        }
    });
    function updateMessages(){
        if(!authForm.value.registered &&
           !saving.value &&
           authForm.value.username
        ) {
            authForm.value.messages = 'отлично, теперь вы можете зарегистрироваться';
        }
        else if(authForm.value.registered) { 
            authForm.value.messages = 'пользователь найден, введите пароль';
        }else {
            authForm.value.messages = 'регистрация или вход';
        }
    }
    function submit(){
        if(saving.value) return;

        saving.value = true;
        
        let url = returnAuthUrl(authForm.value.registered);

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
                authForm.value.errors = 'попробуйте еще раз';
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

        function returnAuthUrl(registered) {
            let authUrl = '/auth/';

            if(registered) authUrl += 'login';
            else authUrl += 'register';

            return authUrl;
        }
    }
</script>