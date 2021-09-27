import Lang from "../../Lang.js";

export default class ArtworkList{

    langName = document.querySelector('html').lang;
    baseUrl = document.querySelector('base').href;

    constructor(){
        this.construct();
    }

    async construct(){
        this.lang = await Lang.getLang(this.langName);
        this.makeEvent();
    }

    /* 
     * Make event for all artwork-list-button 
     * callable with auther class
    */
    makeEvent(){
        document.querySelectorAll('.artwork-list-button').forEach((element) => {
            element.addEventListener('click', this.onChange.bind(this))

        })
    }

    // event change of select
    onChange(e){
        e.preventDefault();

        let form = e.target.parentNode;
        let status = e.target.closest('article').querySelector('.user-status');

        if(e.target.matches('.remove')){
            if (document.title === 'Weebsithèque | Ma liste'){
                let element = e.target;
                while(!element.matches('article')){
                    element = element.parentNode;
                }
                element.remove();
            } else{
                e.target.classList.remove('remove');
                e.target.classList.add('add');
                status.classList.add('none');
            }
            this.send('remove', form);
        }else if(e.target.matches('.add')){
            e.target.classList.remove('add');
            e.target.classList.add('remove');
            status.innerText = this.lang.status['Undefined'];
            status.classList.remove('none');
            this.send('add', form);
        }else{
            document.location.reload();
        }
    }

    // send add or remove one artwork on user list to bdd
    async send(requestType, form){

        let url;

        if(requestType === 'remove')
            url = `${this.baseUrl}/${this.langName}/api/UserList/RemoveArtworkList`;
        else if(requestType === 'add')
            url = `${this.baseUrl}/${this.langName}/api/UserList/AddArtworkList`;

        let myInit = { method: 'POST',
            body: new FormData(form)
        };

        let result;

        await fetch(url, myInit)
        .then(response => response.text())
        .then(response => result = response);

        return result;

    }

}