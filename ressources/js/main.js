"use strict";

import Waifu from "./waifu/Waifu.js";
import Carousel from "./Carousel.js";
import ChangeStatus from "./forms/artworkList/ChangeStatus.js";
import ArtworkList from "./forms/artworkList/ArtworkList.js";
import Login from "./forms/auth/Login.js";
import Register from "./forms/auth/Register.js";
import ChangeUsername from "./forms/auth/ChangeUsername.js";
import ChangeEmail from "./forms/auth/ChangeEmail.js";
import ChangePassword from "./forms/auth/ChangePassword.js";
import ArtworkSearch from "./artworks/ArtworkSearch.js";
import ChangeProfilePicture from "./forms/auth/ChangeProfilePicture.js";
import Lang from "./Lang.js";

document.addEventListener('DOMContentLoaded', async () => {

    document.addEventListener('click', e =>{

        document.querySelectorAll('.nav-check').forEach(element => element.checked = false);

        if(e.target.matches('.nav-check')){
            e.target.checked = true;
        }

        // for element <a> with href '#' not work
        if(e.target.getAttribute('href') === '#')
            e.preventDefault();

    });

    document.querySelectorAll('.notJS').forEach(element => element.parentElement.removeChild(element));

    // DIVER WAIFU
    if (document.title === 'Weebsithèque | Waifu')
        new Waifu();

    // TEXTAREA
    let textarea = document.querySelectorAll(`textarea`);
    textarea.forEach(element => element.addEventListener("input", (e) => {
        e.target.rows = ((e.target.value.match(/\n/g) || []).length)+2;
    }));

    new Lang();
    let lang = await Lang.getLang(document.querySelector('html').lang);
    let prefix = lang.pageTitle.prefix;

    switch(document.title){
        
        case prefix+lang.pageTitle.home:
            new ChangeStatus();
            break;

        case prefix+lang.pageTitle.login:
            new Login();
            break;
            
        case prefix+lang.pageTitle.register:
            new Register();
            break;
            
        case prefix+lang.pageTitle.myAccount:
            new ChangeProfilePicture();
            new ChangeUsername();
            new ChangeEmail();
            new ChangePassword();
            break;
                
        case prefix+lang.pageTitle.search:
            new ArtworkSearch(document.querySelector('#JStype').value, new ChangeStatus(), new ArtworkList(), false);
            break;
                    
        case prefix+lang.pageTitle.myList:
            new ArtworkSearch(document.querySelector('#JStype').value, new ChangeStatus(), new ArtworkList(), true);
            break;
    }

    Carousel.getAll();

});