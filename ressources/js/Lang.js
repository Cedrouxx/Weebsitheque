export default class Lang{

    static getLang(lang){

        return fetch('Lang/'+lang+'.json')
        .then(responce => responce.json())
        .catch(error => console.log(error));

    }

    constructor(){
        let form = document.querySelector('form.lang');
        form.querySelector('input[type=submit]').remove();
        let url = form.querySelector('input[type=hidden]').value;
        form.querySelector('select').addEventListener('change',(e) => {
            document.location.href= e.target.value+"/"+url ;
        });

    }
    
}