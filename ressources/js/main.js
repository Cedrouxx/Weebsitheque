"use strict";

import Waifu from "./waifu/Waifu.js";

document.addEventListener('DOMContentLoaded', () => {

    document.addEventListener('click', e =>{

        document.querySelectorAll('.nav-check').forEach(element => element.checked = false);

        if(e.target.matches('.nav-check')){
            e.target.checked = true;
        }

        // for element <a> with href '#' not work
        if(e.target.getAttribute('href') === '#')
            e.preventDefault();

    });

    document.querySelectorAll('.notJS').forEach( element => element.parentElement.removeChild(element));

    // DIVER WAIFU
    if (document.title === 'Weebsithèque | Waifu')
        new Waifu();

    // TEXTAREA
    let textarea = document.querySelectorAll(`textarea`);
    textarea.forEach(element => element.addEventListener("input", (e) => {
        e.target.rows = ((e.target.value.match(/\n/g) || []).length)+2;
    }));
});