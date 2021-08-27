"use strict";

document.addEventListener('DOMContentLoaded', () => {

    document.addEventListener('click', e =>{

        // for mobile to use the navBar
        let parentElement = e.target.parentElement || e.target;
        
        if (parentElement.matches('header nav>ul>li')){
            parentElement.classList.toggle('navbar-open');
        }else{
            document.querySelectorAll('header nav>ul>li').forEach( element => element.classList.remove('navbar-open') );
        }

        // element <a> with href '#' not work
        if(e.target.getAttribute('href') === '#')
            e.preventDefault();

    });
        
});