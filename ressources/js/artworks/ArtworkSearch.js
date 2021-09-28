import Lang from "../Lang.js";

export default class ArtworkSearch{

    langName = document.querySelector('html').lang;
    baseUrl = document.querySelector('base').href;

    constructor(type, changeStatus, artworkList, isUserList = false){

        this.type = type;
        this.changeStatus = changeStatus;
        this.artworkList = artworkList;
        this.section = document.querySelector('section.grid-3');
        this.searchInput = document.querySelector('#search');
        this.isUserList = isUserList;
        
        this.searchInput.disabled = false;

        this.construct();
    }

    async construct(){

        this.lang = await Lang.getLang(this.langName);

        this.artworks = await this.getAllArtwork();
        this.allStatus = await this.getAllStatus();

        this.searchInput.addEventListener('keyup', this.onSearch.bind(this));
    }

    async getAllArtwork(){
        let result;
        await fetch(`${this.baseUrl}/${this.langName}/api/artwork/${this.type}`)
        .then(response => response.json())
        .then(response => result = response);
        return result;
    }

    async getAllArtworkInUserList(){
        let result;
        await fetch(`${this.baseUrl}/${this.langName}/api/UserList/getUserList/${this.type}`)
        .then(response => response.json())
        .then(response => result = response);
        return result;
    }

    async getAllStatus(){
        let result;
        await fetch(`${this.baseUrl}/${this.langName}/api/status`)
        .then(response => response.json())
        .then(response => result = response);
        return result;
    }

    // search event
    async onSearch(){

        this.userList = await this.getAllArtworkInUserList();

        let value = this.searchInput.value;
        let table;

        if (this.isUserList === true){
            table = this.userList.filter(item => item.name.toLocaleLowerCase().includes(value.toLocaleLowerCase()));
        }else{
            table = this.artworks.filter(item => item.name.toLocaleLowerCase().includes(value.toLocaleLowerCase()));
        }
        let section = document.querySelector('section.grid-3');

        section.querySelectorAll('article').forEach(element => element.remove());

        table.forEach(artwork => {
            let genre;
        
            if (Array.isArray(artwork.genre)){
                genre = artwork.genre.join(', ');
            }else {
                genre = artwork.genre;
            }

            let userArtwork = this.userList.find(value => value.id == artwork.id);

            section.appendChild(this.makeHtml(artwork, userArtwork, genre));
        });

        this.changeStatus.makeEvent();
        this.artworkList.makeEvent();

    }
 
    // Make a html for one artwork 
    makeHtml(artwork, userArtwork, genre){

        // article
        let article = document.createElement('article');
        article.classList.add('shadow');
        article.classList.add('borderAll');

        // figure
        let figure = document.createElement('figure');
        figure.classList.add('hover-caption');
        figure.tabIndex = 0;

        // image
        let img = document.createElement('img');
        img.src = artwork.image;
        img.alt = artwork.name;

        // span
        let span = document.createElement('span');
        if(userArtwork !== undefined){
            if(this.isUserList){
                
                // form
                span = document.createElement('form');
                span.action = '/set-artwork-list-status';
                span.method = 'post';

                // input hidden artwork_id
                let inputSpan = document.createElement('input');
                inputSpan.type = 'hidden';
                inputSpan.name = 'artwork_id';
                inputSpan.value = artwork.id;

                // select
                let select = document.createElement('select');
                select.id = 'changeStatusSelect';
                select.name = 'status';
                this.allStatus.forEach( status => {
                    let option = new Option(this.lang.status[status], status, status === userArtwork.status, status === userArtwork.status);
                    select.append(option);
                });

                // append in form
                span.append(inputSpan);
                span.append(select);
            }else{
                if(userArtwork === undefined){
                    span.classList.add('none');
                }else{
                    span.innerText = this.lang.status[userArtwork.status];
                }
            }
        } else{
            span.classList.add('none');
        }
        span.classList.add('user-status');
        
        // figcaption
        let figcaption = document.createElement('figcaption');

        // div
        let div = document.createElement('div');

        // title
        let h3 = document.createElement('h3');
        h3.innerText = artwork.name;

        // author
        let pAuthor = document.createElement('p');
        pAuthor.innerText = 'Créer par : ' + artwork.author;

        // genre
        let pGenre = document.createElement('p');
        pGenre.innerText = 'Genre : ' + genre;

        // note
        let pNote = document.createElement('p');
        pNote.innerText = 'Note : ' + artwork.note + '/10';

        // button more info
        let a = document.createElement('a');
        a.classList.add('button');
        a.classList.add('block-center');
        a.href = `${this.langName}/${this.type}/info/${artwork.slug}`;
        a.innerText = 'Plus d\'info';

        // append to div
        div.append(h3);
        div.append(pAuthor);
        if (artwork.genre !== '') div.append(pGenre);
        if (artwork.note !== '') div.append(pNote);
        div.append(a);

        // form
        let form = document.createElement('form');
        form.action = `${this.langName}/add-artwork-list`;
        form.method = 'post';

        // input
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'artwork_id';
        input.value = artwork.id;

        // button
        let button;
        if(this.userList.length > 0){
            button = document.createElement('button');
            button.classList.add('artwork-list-button');
            if(userArtwork === undefined){
                button.id = 'addArtworkList';
                button.classList.add('add');
            }else{
                button.id = 'removeArtworkList';
                button.classList.add('remove');
            }
        }

        // append to form
        form.append(input);
        if(this.userList.length > 0) form.append(button);

        // append to figcaption
        figcaption.append(div);
        figcaption.append(form);

        // append to figure
        figure.append(img);
        figure.append(span);
        figure.append(figcaption);

        // append to article
        article.append(figure);

        return article;
        
    }

}