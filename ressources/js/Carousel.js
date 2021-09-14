export default class Carousel{

    static getAll(){
        document.querySelectorAll('.carousel').forEach(element => new Carousel(element));
    }

    constructor(carousel){

        this.current = 0;

        this.carousel = carousel;
        let children = this.carousel.children;
        this.carouselElements = [];

        for (let i = 0; i < children.length; i++){
            if (children[i].matches('div'))
                this.carouselElements.push(children[i]);
        }

        carousel.querySelector('.beforeButton').addEventListener('click', this.before.bind(this));
        carousel.querySelector('.afterButton').addEventListener('click', this.after.bind(this));

        this.refresh();

    }

    before(){
        this.current --;
        if(this.current < 0)
            this.current = this.carouselElements.length - 1;
        this.refresh();
    }

    after(){
        this.current ++;
        if(this.current > this.carouselElements.length - 1)
            this.current = 0;
        this.refresh();
    }

    refresh(){
        this.carouselElements.forEach((element, index) => {
            if(index !== this.current){
                element.classList.add('none');
            }else{
                element.classList.remove('none');
            }
        });
    }

}