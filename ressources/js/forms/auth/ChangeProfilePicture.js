import { checkEmail } from "../../utilities.js";

// helper for change profilePicture 
export default class ChangeProfilePicture{

    constructor(){

        this.profilePictureInput = document.querySelector('input[name="profilePicture"]');
        this.profilePicturelOk = false;
        
        this.submitButton = this.profilePictureInput.closest('form').querySelector('input[type="submit"]');
        
        this.profilePictureInput.addEventListener('change', this.onProfilePictureChange.bind(this));

        console.log(this.profilePictureInput)
        this.buttonDisable();

    }

    onProfilePictureChange(e){
        
        if(e.target.value === ''){
            this.profilePictureOk = false;
        }else{
            this.profilePictureOk = true;
        }

        this.buttonDisable();
    }
    
    buttonDisable(){

        if(this.profilePictureOk)
            this.submitButton.disabled = false;
        else
            this.submitButton.disabled = true; 
    }
}