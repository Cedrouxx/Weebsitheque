export default class ChangeStatus{

    constructor(){
        
        document.querySelectorAll('#changeStatusButton').forEach(e => e.remove());

        this.makeEvent();
        
    }

    makeEvent(){

        document.querySelectorAll('#changeStatusSelect').forEach(e => e.addEventListener('change' ,this.changeStatus.bind(this)));

    }

    changeStatus(e){

        let myInit = { method: 'POST',
            body: new FormData(e.target.parentNode)
        };

        fetch('/api/UserList/ChangeStatus', myInit);
    }

}