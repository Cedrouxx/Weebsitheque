export class RefreshArtwork{

    static types = {
        anime: 'anime',
        manga: 'manga',
        all: 'all'
    };

    static async refresh( element, id){

        console.log(element.offsetHeight)

        let scroll = window.scrollY;
        
        let childs = element.children;
        let articles = [];
        for (let i = 0; i < childs.length; i++) {
            if(childs[i].matches('article'))
                articles.push(childs[i]);
        }
        articles.forEach(e => e.remove());
        let html = await this.getHtml(type);
        element.innerHTML += html;

        window.scroll(0, scroll);

    }

    static async getInfo(id){
        let result;
        await fetch('/api/UserList/getUserList/all')
        .then(response => response.text())
        .then(response => result = response)
        return result;
    }

}