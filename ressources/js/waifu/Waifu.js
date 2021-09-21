import {capitalizeFirstLetter} from '../utilities.js';

export default class Waifu{

    constructor(){

        let main = document.querySelector('main>div>section');

        let div = document.createElement('div');
        div.classList.add('text-center');

        let divInput = document.createElement('div');
        divInput.classList.add('margeBottom');

        this.select = document.createElement('select');
        this.select.classList = 'button margeAll inlineBlock';
        for (const element of this.getTable()) {
            this.select.append(this.createOption(element, capitalizeFirstLetter(element)));
        }
        divInput.append(this.select);

        this.pushButton = document.createElement('button');
        this.pushButton.classList = 'button inlineBlock';
        this.pushButton.innerText = 'Go !'
        divInput.append(this.pushButton);

        div.append(divInput);
        
        this.image = document.createElement('img');
        this.image.classList.add('maxheight')
        this.image.classList.add('block');
        this.image.classList.add('block-center');
        this.image.classList.add('borderAll');
        this.image.classList.add('shadow');
        div.append(this.image);
        
        this.pushButton.addEventListener('click', this.onPush.bind(this));

        main.append(div);

        this.onPush();
    }

    createOption(value, text){
        let option = document.createElement('option');
        option.value = value;
        option.innerText = text;
        return option;
    }

    onPush(){
        fetch(`https://api.waifu.pics/sfw/${this.select.value}`)
        .then(response => response.json())
        .then(this.drawImage.bind(this));
    }

    drawImage(response){
        this.image.src = response.url;
    }

    getTable(){
        return [
            'waifu',
            'neko',
            'shinobu',
            'megumin',
            'bully',
            'cuddle',
            'cry',
            'hug',
            'awoo',
            'kiss',
            'lick',
            'pat',
            'smug',
            'bonk',
            'yeet',
            'blush',
            'smile',
            'wave',
            'highfive',
            'handhold',
            'nom',
            'bite',
            'glomp',
            'slap',
            'kill',
            'kick',
            'happy',
            'wink',
            'poke',
            'dance',
            'cringe'
        ]
    }

}