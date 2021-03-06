export default class ChangeStatus{

    lang = document.querySelector('html').lang;
    baseUrl = document.querySelector('base').href;

    constructor(){
        
        document.querySelectorAll('.changeStatusButton').forEach(e => e.remove());

        this.makeEvent();
        
    }

    makeEvent(){

        document.querySelectorAll('.changeStatusSelect').forEach(e => e.addEventListener('change' ,this.changeStatus.bind(this)));

    }

    changeStatus(e){

        let myInit = { method: 'POST',
            body: new FormData(e.target.parentNode)
        };

        fetch(`${this.baseUrl}/${this.lang}/api/UserList/ChangeStatus`, myInit);
    }

}