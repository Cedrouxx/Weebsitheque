
// helper for change password 
export default class ChangePassword{

    constructor(){

        this.passwordInput = document.querySelector('input[name="password"]');
        this.passwordOk = false;
        this.passwordError = document.querySelector('small#E-'+this.passwordInput.id);
        
        this.passwordConfirmInput = document.querySelector('input[name="password-confirm"]');
        this.passwordConfirmOk = false;
        this.passwordConfirmError = document.querySelector('small#E-'+this.passwordConfirmInput.id);
        
        this.submitButton = this.passwordInput.closest('form').querySelector('input[type="submit"]');

        this.passwordInput.addEventListener('blur', this.onPasswordChange.bind(this));
        this.passwordConfirmInput.addEventListener('blur', this.onPasswordConfirmChange.bind(this));

        this.passwordInput.addEventListener('keyup', this.onPasswordPress.bind(this));
        this.passwordConfirmInput.addEventListener('keyup', this.onPasswordConfirmPress.bind(this));

        this.buttonDisable();

    }

    onPasswordChange(e){

        let re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/g;

        if(e.target.value === ''){
            this.passwordError.innerText = '';
        }else if(e.target.value.length < 8){
            this.passwordError.innerText = 'Le mot de passe doit faire au moin 8 carractères !';
        }else if(!re.test(e.target.value)){
            this.passwordError.innerText = 'Le mot-de-passe doit contenir au moin une lettre majuscule, une lettre minuscule, un nombre et un carractère spécial (!, @, #, \$, %, \^, &, \*) !';
            console.log(e.target.value, re.test(e.target.value))
        }else{
            this.passwordError.innerText = '';
        }

        this.buttonDisable();
    }

    onPasswordConfirmChange(e){
        if(e.target.value === ''){
            this.passwordConfirmError.innerText = '';
        }else if(e.target.value !== this.passwordInput.value){
            this.passwordConfirmError.innerText = 'Les mots de passe ne coresponde pas !';
        }else{
            this.passwordConfirmError.innerText = '';
        }

        this.buttonDisable();
    }

    onPasswordPress(e){

        let re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/g;

        if(e.target.value === ''){
            this.passwordOk = false;
        }else if(e.target.value.length < 8){
            this.passwordOk = false;
        }else if(!re.test(e.target.value)){
            this.passwordOk = false;
        }else{
            this.passwordOk = true;
        }

        this.buttonDisable();
    }

    onPasswordConfirmPress(e){
        if(e.target.value === ''){
            this.passwordConfirmOk = false;
        }else if(e.target.value !== this.passwordInput.value){
            this.passwordConfirmOk = false;
        }else{
            this.passwordConfirmOk = true;
        }

        this.buttonDisable();
    }
    
    buttonDisable(){

        if(this.passwordOk && this.passwordConfirmOk)
            this.submitButton.disabled = false;
        else
            this.submitButton.disabled = true; 
    }
}