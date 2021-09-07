import { checkEmail } from "../../utilities.js";

export default class Register{

    constructor(){

        this.usernameInput = document.querySelector('input[name="username"]');
        this.usernameOk = false;
        this.usernameError = document.querySelector('small#E-'+this.usernameInput.id);

        this.emailInput = document.querySelector('input[name="email"]');
        this.emailOk = false;
        this.emailError = document.querySelector('small#E-'+this.emailInput.id);

        this.passwordInput = document.querySelector('input[name="password"]');
        this.passwordOk = false;
        this.passwordError = document.querySelector('small#E-'+this.passwordInput.id);
        
        this.passwordConfirmInput = document.querySelector('input[name="password-confirm"]');
        this.passwordConfirmOk = false;
        this.passwordConfirmError = document.querySelector('small#E-'+this.passwordConfirmInput.id);
        
        this.submitButton = this.emailInput.closest('form').querySelector('input[type="submit"]');
        
        this.usernameInput.addEventListener('blur', this.onUsernameChange.bind(this));
        this.emailInput.addEventListener('blur', this.onEmailChange.bind(this));
        this.passwordInput.addEventListener('blur', this.onPasswordChange.bind(this));
        this.passwordConfirmInput.addEventListener('blur', this.onPasswordConfirmChange.bind(this));

        this.buttonDisable();

    }

    onUsernameChange(e){
        if(e.target.value === ''){
            this.usernameError.innerText = '';
            this.usernameOk = false;
        }else if(e.target.value.length < 3){
            this.usernameError.innerText = 'Le nom d\'utilisateur doit faire au moin 3 carractères !';
            this.usernameOk = false;
        }else{
            this.usernameError.innerText = '';
            this.usernameOk = true;
        }
        this.buttonDisable();
    }

    onEmailChange(e){
        
        if(e.target.value === ''){
            this.emailError.innerText = '';
            this.emailOk = false;
        }else if(!checkEmail(e.target.value)){
            this.emailError.innerText = 'Adresse mail invalide !';
            this.emailOk = false;
        }else{
            this.emailError.innerText = '';
            this.emailOk = true;
        }

        this.buttonDisable();
    }

    onPasswordChange(e){

        let re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/g;

        if(e.target.value === ''){
            this.passwordOk = false;
            this.passwordError.innerText = '';
        }else if(e.target.value.length < 8){
            this.passwordError.innerText = 'Le mot de passe doit faire au moin 8 carractères !';
            this.passwordOk = false;
        }else if(!re.test(e.target.value)){
            this.passwordError.innerText = 'Le mot-de-passe doit contenir au moin une lettre majuscule, une lettre minuscule, un nombre et un carractère spécial (!, @, #, \$, %, \^, &, \*) !';
            this.passwordOk = false;
            console.log(e.target.value, re.test(e.target.value))
        }else{
            this.passwordError.innerText = '';
            this.passwordOk = true;
        }

        this.buttonDisable();
    }

    onPasswordConfirmChange(e){
        if(e.target.value === ''){
            this.passwordConfirmOk = false;
            this.passwordConfirmError.innerText = '';
        }else if(e.target.value !== this.passwordInput.value){
            this.passwordConfirmOk = false;
            this.passwordConfirmError.innerText = 'Les mots de passe ne coresponde pas !';
        }else{
            this.passwordConfirmOk = true;
            this.passwordConfirmError.innerText = '';
        }

        this.buttonDisable();
    }
    
    buttonDisable(){

        if(this.usernameOk && this.emailOk && this.passwordOk && this.passwordConfirmOk)
            this.submitButton.disabled = false;
        else
            this.submitButton.disabled = true; 
    }
}