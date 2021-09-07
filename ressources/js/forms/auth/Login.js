import { checkEmail } from "../../utilities.js";

export default class Login{

    constructor(){

        this.emailInput = document.querySelector('input[name="email"]');
        this.emailOk = false;
        this.emailError = document.querySelector('small#E-'+this.emailInput.id);

        this.passwordInput = document.querySelector('input[name="password"]');
        this.passwordOk = false;
        
        this.submitButton = this.emailInput.closest('form').querySelector('input[type="submit"]');
        
        
        this.emailInput.addEventListener('blur', this.onEmailChange.bind(this));
        this.passwordInput.addEventListener('blur', this.onPasswordChange.bind(this));

        this.buttonDisable();

    }

    onEmailChange(e){
        
        if(e.target.value === ''){
            this.emailError.innerText = '';
            this.emailOk = false;
        }else if(!checkEmail(e.target.value)){
            this.emailError.innerText ='Adresse mail invalide !';
            this.emailOk = false;
        }else{
            this.emailError.innerText = '';
            this.emailOk = true;
        }

        this.buttonDisable();
    }

    onPasswordChange(e){

        if(e.target.value === ''){
            this.passwordOk = false;
        }else{
            this.passwordOk = true;
        }

        this.buttonDisable();
    }

    buttonDisable(){

        if(this.passwordOk && this.emailOk)
            this.submitButton.disabled = false;
        else
            this.submitButton.disabled = true; 
    }

}