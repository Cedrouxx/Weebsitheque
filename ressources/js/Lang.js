export default class Lang{

    static getLang(lang){

        return fetch('Lang/'+lang+'.json')
        .then(responce => responce.json())
        .catch(error => console.log(error));

    }
    
}