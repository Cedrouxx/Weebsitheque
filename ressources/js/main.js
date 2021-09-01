"use strict";

document.addEventListener('DOMContentLoaded', () => {

    document.addEventListener('click', e =>{

        document.querySelectorAll('.nav-check').forEach(element => element.checked = false);

        if(e.target.matches('.nav-check')){
            e.target.checked = true;
        }

        // element <a> with href '#' not work
        if(e.target.getAttribute('href') === '#')
            e.preventDefault();

    });
        
});