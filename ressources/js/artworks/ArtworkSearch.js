export default class ArtworkSearch{

    lang = document.querySelector('html').lang;
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

        this.artworks = await this.getAllArtwork();
        this.allStatus = await this.getAllStatus();

        this.searchInput.addEventListener('keyup', this.onSearch.bind(this));
    }

    async getAllArtwork(){
        let result;
        await fetch(`${this.baseUrl}/${this.lang}/api/artwork/${this.type}`)
        .then(response => response.json())
        .then(response => result = response);
        return result;
    }

    async getAllArtworkInUserList(){
        let result;
        await fetch(`${this.baseUrl}/${this.lang}/api/UserList/getUserList/${this.type}`)
        .then(response => response.json())
        .then(response => result = response);
        return result;
    }

    async getAllStatus(){
        let result;
        await fetch(`${this.baseUrl}/${this.lang}/api/status`)
        .then(response => response.json())
        .then(response => result = response);
        return result;
    }

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

    makeHtml(artwork, userArtwork, genre){

        let article = document.createElement('article');
        article.classList.add('shadow');
        article.classList.add('borderAll');

        let figure = document.createElement('figure');
        figure.classList.add('hover-caption');
        figure.tabIndex = 0;

        let img = document.createElement('img');
        img.src = artwork.image;
        img.alt = artwork.name;

        let span = document.createElement('span');
        if(userArtwork !== undefined){
            if(this.isUserList){
                span = document.createElement('form');
                span.action = '/set-artwork-list-status';
                span.method = 'post';

                let inputSpan = document.createElement('input');
                inputSpan.type = 'hidden';
                inputSpan.name = 'artwork_id';
                inputSpan.value = artwork.id;

                let select = document.createElement('select');
                select.id = 'changeStatusSelect';
                select.name = 'status';
                this.allStatus.forEach( status => {
                    let option = new Option(status.name, status.id, status.name === userArtwork.status, status.name === userArtwork.status);
                    select.append(option);
                });

                span.append(inputSpan);
                span.append(select);
            }else{
                if(userArtwork === undefined){
                    span.classList.add('none');
                }else{
                    span.innerText = userArtwork.status;
                }
            }
        } else{
            span.classList.add('none');
        }
        span.classList.add('user-status');
        
        let figcaption = document.createElement('figcaption');

        let div = document.createElement('div');

        let h3 = document.createElement('h3');
        h3.innerText = artwork.name;

        let pAuthor = document.createElement('p');
        pAuthor.innerText = 'Créer par : ' + artwork.author;

        let pGenre = document.createElement('p');
        pGenre.innerText = 'Genre : ' + genre;

        let a = document.createElement('a');
        a.classList.add('button');
        a.classList.add('block-center');
        a.href = `${this.lang}/${this.type}/info/${artwork.slug}`;
        a.innerText = 'Plus d\'info';

        div.append(h3);
        div.append(pAuthor);
        div.append(pGenre);
        div.append(a);

        let form = document.createElement('form');
        form.action = `${this.lang}/add-artwork-list`;
        form.method = 'post';

        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'artwork_id';
        input.value = artwork.id;

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

        form.append(input);
        if(this.userList.length > 0) form.append(button);

        figcaption.append(div);
        figcaption.append(form);

        figure.append(img);
        figure.append(span);
        figure.append(figcaption);

        article.append(figure);

        return article;
        
    }

}