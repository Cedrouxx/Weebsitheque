"use strict";

import Waifu from "./waifu/Waifu.js";
import ChangeStatus from "./forms/artworkList/ChangeStatus.js";
import ArtworkList from "./forms/artworkList/ArtworkList.js";
import Login from "./forms/auth/Login.js";
import Register from "./forms/auth/Register.js";
import ChangeUsername from "./forms/auth/ChangeUsername.js";
import ChangeEmail from "./forms/auth/ChangeEmail.js";
import ChangePassword from "./forms/auth/ChangePassword.js";
import {config} from "./config.js";
import ArtworkSearch from "./artworks/ArtworkSearch.js";

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


    switch(document.title){
        
        case config.title.login:
            new Login();
            break;
            
            case config.title.register:
                new Register();
                break;
                
            case config.title.myAccount:
                new ChangeUsername();
                new ChangeEmail();
                new ChangePassword();
                break;
                    
            case config.title.search:
                new ArtworkSearch(document.querySelector('#JStype').value, new ChangeStatus(), new ArtworkList(), false);
                break;
                        
            case config.title.userList:
                new ArtworkSearch(document.querySelector('#JStype').value, new ChangeStatus(), new ArtworkList(), true);
                break;
    }

    // if (document.title === config.title.userList)
    //     new ChangeStatus();
    
    // if (document.title === config.title.login)
    //     new Login();

    // if (document.title === config.title.register)
    //     new Register();

    // if (document.title === config.title.myAccount){
    //     new ChangeUsername();
    //     new ChangeEmail();
    //     new ChangePassword();
    // }

    // if (document.title === config.title.search)
    //     new ArtworkSearch(document.querySelector('#JStype').value);

    // if (document.title === config.title.myList)
    //     new ArtworkSearch(document.querySelector('#JStype').value, true);

    // new ArtworkList();

});