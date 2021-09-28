import { checkEmail } from "../../utilities.js";

// helper for change email 
export default class ChangeEmail{

    constructor(){

        this.emailInput = document.querySelector('input[name="email"]');
        this.emailOk = false;
        this.emailError = document.querySelector('small#E-'+this.emailInput.id);
        
        this.submitButton = this.emailInput.closest('form').querySelector('input[type="submit"]');
        
        this.emailInput.addEventListener('blur', this.onEmailChange.bind(this));
        this.emailInput.addEventListener('keyup', this.onEmailPress.bind(this));

        this.buttonDisable();

    }

    onEmailChange(e){
        
        if(e.target.value === ''){
            this.emailError.innerText = '';
        }else if(!checkEmail(e.target.value)){
            this.emailError.innerText = 'Adresse mail invalide !';
        }else{
            this.emailError.innerText = '';
        }

        this.buttonDisable();
    }

    onEmailPress(e){
        
        if(e.target.value === ''){
            this.emailOk = false;
        }else if(!checkEmail(e.target.value)){
            this.emailOk = false;
        }else{
            this.emailOk = true;
        }

        this.buttonDisable();
    }
    
    buttonDisable(){

        if(this.emailOk)
            this.submitButton.disabled = false;
        else
            this.submitButton.disabled = true; 
    }
}