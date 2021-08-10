<template>
    <div>
        <input  style= "display: none" type="password" name="password" />
        <input  style= "display: none" type="text" name="email" />

        <div class=" form-group-sm row gutters-tiny" >
            <span class="col-12 m-0" >{{'register.name'}}:<span class="text-danger">*</span></span>
            <div class="col-12 ">
                <input class="form-control form-control-lg bold hover-border" type="text"   :placeholder="'register.placeholder.name'"  autocomplete="off" v-model="input.first_name" :class="{'is-invalid':error.name,'is-valid':input.name}">
                <span class="text-danger">{{error.name}}</span>
            </div>
        </div>

        <div class=" form-group-sm row gutters-tiny" >
            <span class="col-12 m-0" >{{'register.email'}}:<span class="text-danger">*</span></span>
            <div class="col-12 " >
                <input class="form-control form-control-lg bold hover-border"  type="text"   :placeholder="'register.placeholder.email'"  autocomplete="off" v-model="input.email" :class="{'is-invalid':error.email,'is-valid':input.email}">
                <span class="text-danger">{{error.email}}</span>
            </div>
        </div>

        <div class=" form-group-sm row gutters-tiny" >
            <span class="col-8 m-0" >{{'register.password'}}:<span class="text-danger">*</span></span>
            <span class="col-4 m-0 text-right" ><a href="#" class="text-black"  @click="showPasswordClick()" style="text-decoration: underline;" v-html="showPasswordText"></a></span>
            <div class="col-12 " id="password_register">
            <input class="form-control form-control-lg bold hover-border" name="password" :type="passwordType"   :placeholder="'register.placeholder.password'"  autocomplete="off" v-model="input.password" :class="{'is-invalid':error.password,'is-valid':input.password}">
                    <span class="text-danger">{{error.password}}</span>
            </div>
        </div>

        <div class=" form-group-sm row gutters-tiny" >
            <span class="col-8 m-0" >{{'register.password_confirm'}}:<span class="text-danger">*</span></span>
            <span class="col-4 m-0 text-right" ><a href="#" class="text-black"  @click="showPasswordClick('confirm')" style="text-decoration: underline;" v-html="showPasswordConfirmText"></a></span>
            <div class="col-12 " id="password_confirmation">
            <input class="form-control form-control-lg bold hover-border" :type="passwordConfirmType"   :placeholder="'register.placeholder.password_confirm'"  autocomplete="off" v-model="input.password_confirmation" :class="{'is-invalid':error.password_confirmation,'is-valid':input.password_confirmation}">
                <span class="text-danger">{{error.password_confirmation}}</span>
            </div>
        </div>







            <div class="form-group row gutters-tiny">
                <div class="col-md-12 ">
                    <button type="button" class="btn btn-lg btn-block  hover btn-dark   mb-5 mt-1 br-0 p-20" @click="Register"  :disabled="loading.register" >
                        {{'register.register'}}<template v-if="loading.login"><img :src="'/img/loading3.gif'" :width="12"></template>
                        <template v-if="loading.register"><img :src="'/img/loading3.gif'" :width="22"></template>
                    </button>
                </div>
            </div>


    </div>
</template>

<script>

export default {
    components: {
          },
    props: {
        routes:Object,

	},
    watch: {
        'clearForm': function(arMsg) {
            if(arMsg){
                this.clearVariables();
                this.$emit('clear');
            }
        },
    },
	data() {
		return {
            loading:{},
            showPassword:false,
            showPasswordText:'login.show',
            showPasswordConfirm:false,
            showPasswordConfirmText:'login.show',
            passwordType:'password',
            passwordConfirmType:'password',
            error:{},
            input:{}
		}
	},
	mounted() {
		console.log('Register Component mounted.');
	},
	created(){
	},
	methods:{

        Register:function(){
            this.loading.register=true;

            console.log('Creating user...')
            axios.post(this.routes.api_users_store,this.input)
                .then((response) =>{
                    console.log('User Created');
                    this.clearVariables();
                  
                        window.location.href=this.routes.chat

                })
                .catch(error => {
                    this.error={};
                    const errorBag=error.response.data.data;
                    for (const attrib in errorBag){
                        this.error[attrib]=errorBag[attrib].toString();
                    }
                })
                .finally(() => this.loading.register = false);
        },
        clearVariables:function(){
            this.error={};
            this.input={};
            this.SelectedCountry=[];
            this.SelectedState=""
        },
        showPasswordClick:function(type){
            if(type==null){
                if(this.showPassword){
                    this.passwordType='password'
                    this.showPasswordText='login.show'
                }else{
                    this.passwordType='text'
                    this.showPasswordText='login.hide'
                }
                this.showPassword=!this.showPassword
            }else{
                if(this.showPasswordConfirm){
                    this.passwordConfirmType='password'
                    this.showPasswordConfirmText='login.show'
                }else{
                    this.passwordConfirmType='text'
                    this.showPasswordConfirmText='login.hide'
                }
                this.showPasswordConfirm=!this.showPasswordConfirm
            }
        },
	}
}
</script>

<style>

</style>
