export default class ArtworkList{

    lang = document.querySelector('html').lang;

    constructor(){
        this.makeEvent();
    }

    makeEvent(){
        document.querySelectorAll('.artwork-list-button').forEach((element) => {
            element.addEventListener('click', this.onChange.bind(this))

        })
    }

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
            status.innerText = 'Non défini';
            status.classList.remove('none');
            this.send('add', form);
        }else{
            document.location.reload();
        }
    }

    send(requestType, form){

        let url;

        if(requestType === 'remove')
            url = `/${this.lang}/api/UserList/RemoveArtworkList`;
        else if(requestType === 'add')
            url = `/${this.lang}/api/UserList/AddArtworkList`;

        let myInit = { method: 'POST',
            body: new FormData(form)
        };

        let result;

        fetch(url, myInit)
        .then(response => response.text())
        .then(response => result = response);

        return result;

    }

}