import { checkEmail } from "../../utilities.js";

export default class ChangeUsername{

    constructor(){

        this.usernameInput = document.querySelector('input[name="username"]');
        this.usernameOk = false;
        this.usernameError = document.querySelector('small#E-'+this.usernameInput.id);
        
        this.submitButton = this.usernameInput.closest('form').querySelector('input[type="submit"]');
        
        
        this.usernameInput.addEventListener('blur', this.onUsernameChange.bind(this));

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

    buttonDisable(){

        if(this.usernameOk)
            this.submitButton.disabled = false;
        else
            this.submitButton.disabled = true; 
    }

}