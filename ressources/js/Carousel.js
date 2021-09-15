export default class Carousel{

    static getAll(){
        document.querySelectorAll('.carousel').forEach(element => new Carousel(element));
    }

    constructor(carousel){

        this.current = 0;

        this.carousel = carousel;
        let children = this.carousel.children;
        this.carouselElements = [];

        this.bullets = [];
        let contBullet = document.createElement('div'); 
        for (let i = 0; i < children.length; i++){
            if (children[i].matches('div')){
                this.carouselElements.push(children[i]);
                let bullet = document.createElement('div');
                bullet.classList = 'round size1rem block borderCoPrim pointer';
                bullet.dataset.number = this.bullets.length;
                bullet.addEventListener('click', this.bulletClick.bind(this));
                this.bullets.push(bullet);
                contBullet.append(this.bullets[i]);
            }
        }

        let beforeButton = document.createElement('button');
        beforeButton.classList = 'beforeButton button';
        beforeButton.innerText = '<';
        let afterButton = document.createElement('button');
        afterButton.classList = 'afterButton button';
        afterButton.innerText = '>';

        beforeButton.addEventListener('click', this.before.bind(this));
        afterButton.addEventListener('click', this.after.bind(this));

        contBullet.classList = 'flex flex-around margeTop';

        this.carousel.append(beforeButton);
        this.carousel.append(afterButton);
        this.carousel.append(contBullet);
        

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

    bulletClick(e){
        
        this.current = parseInt(e.target.dataset.number);

        this.refresh();
    }

    refresh(){
        for (let i = 0; i<this.carouselElements.length; i++){
            if(i !== this.current){
                this.carouselElements[i].classList.add('none');
                this.bullets[i].classList.remove('bgcPrim');
            }else{
                this.carouselElements[i].classList.remove('none');
                this.bullets[i].classList.add('bgcPrim');
            }
        }
    }

}