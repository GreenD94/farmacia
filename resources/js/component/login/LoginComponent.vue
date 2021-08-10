<template>
    <div class="row gutters-tiny justify-content-center">
        <div class="col-md-8">
            <div class="row p-20">
                <div class="col-12">
                        <b>VILAVELONI</b>
                </div>
                    <div class="col-12">
                        {{'login.subtitle'}}
                </div>
            </div>
            <div class="row">
                <input id="password" style= "display: none" type="password" name="password" />
                <input id="email" style= "display: none" type="text" name="email" />
                <div class="col-md-6">
                    <div class="block block-transparent">
                        <div class="block-header  pt-0 pb-0">
                            <h3 class="block-title"> </h3>
                            <div class="block-options mr-0">
                            </div>
                        </div>
                        <div class="block-content pt-0" >
                            <div class="row ">
                                <div class="col-12">
                                    <b>{{'login.connect'}}</b>
                                </div>
                            </div>
                            <div class="  row gutters-tiny mt-20">
                                <span class="col-12 m-0" >{{'login.email'}}:</span>
                                <div class="col-12 " >
                                    <input class="form-control form-control-lg bold hover-border "  :ref="email" type="text"  v-model="input.email" :placeholder="'login.placeholder.email'" :disabled="loading.email" :class="{'is-invalid':error.email,'is-valid':input.email}" autocomplete="off"  @keyup.enter="login">
                                    <div class="text-danger">
                                        {{error.email}}
                                    </div>
                                </div>
                            </div>
                            <div class="  row gutters-tiny mt-20">
                                <span class="col-8 m-0" >{{'login.password'}}:</span>
                                <span class="col-4 m-0 text-right" ><a href="#" class="text-black"  @click="showPasswordClick" style="text-decoration: underline;" v-html="showPasswordText"></a></span>
                                <div class="col-12 " >
                                    <input class="form-control form-control-lg bold hover-border "  :type="passwordType"  v-model="input.password" :placeholder="'login.placeholder.password'" :disabled="loading.password" :class="{'is-invalid':error.password,'is-valid':input.password}" autocomplete="off"  @keyup.enter="login">
                                    <div class="text-danger">
                                        {{error.password}} <br>
                                        {{error.auth}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20 mb-20">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-lg btn-block  hover btn-dark   mb-5 mt-1 br-0 p-20" @click="login"  :disabled="loading.login" >
                                        {{'login.login'}}<template v-if="loading.login"><img :src="'/img/loading3.gif'" :width="12"></template>
                                        <template v-if="loading.login"><img :src="'/img/loading3.gif'" :width="22"></template>
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-20 mb-100">
                                <div class="col-12">
                                    <a href="/forgot-password" class="text-black" style="text-decoration: underline;"><b>¿OLVIDASTE TU CONTRASEÑA?</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row  mb-20">
                        <div class="col-12 ">
                            <b>{{'login.register'}}</b>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row mt-20 mb-20">
            <div class="col-12">
               {{'login.text1'}} <a href="" class="text-black" style="text-decoration: underline;"><b>{{'login.text1_link'}}</b></a> {{'login.text2'}} <a href="" class="text-black" style="text-decoration: underline;"><b>{{'login.text2_link'}}</b></a>
            </div>
        </div>
    </div>
</template>
<script>


export default {
    props: {
         routes:Object,
      
	},

	data() {
		return {
            input:{},
            error:[],
            loading:[],
            showPassword:false,
            showPasswordText:'login.show',
            passwordType:'password',
            input:{}
		}
	},
    watch: {

    },
	mounted() {
		console.log('Component mounted.');
	},
	created(){

	},
	methods:{
        showPasswordClick:function(){
            if(this.showPassword){
                this.passwordType='password'
                this.showPasswordText='login.show'
            }else{
                this.passwordType='text'
                this.showPasswordText='login.hide'
            }
             this.showPassword=!this.showPassword
        },
        login:function(){
            this.loading.login=true
            this.loading.piece      =   true;
            this.error              =   [];
            console.log('logging in...')
            axios.post(this.routes.api_login,this.input
                ).then((response) =>{
                    console.log('logged');
                    this.clearVariables();
                    this.redirect(this.routes.redirect);

                })
                .catch(error => {
                    const errorBag=error.response.data.data;
                    for (const attrib in errorBag){
                        this.error[attrib]=errorBag[attrib].toString();
                    }
                })
                .finally(() => this.loading.login = false);
        },
        clearVariables:function(){
            this.input={}
        },
        redirect:function(url){
            if(!url==null){
                window.location=url
            }
            window.location=this.routes.chat;
        },
	},
}
</script>

<style>

</style>
