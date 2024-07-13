// Ovaj javaScript sadrži:
//      - standardne implementacija za:
//          *   setCookie
//          *   getCookie
//          *   eraseCookie
//      - funkciju za spremanje (i updateanje) artikla u košaricu (ID ponude i količina)
//      - funkciju za micanje artikla iz kosarice
//      - funkciju za dohvacanje kolicine artikla u kosarici
//      - funkciju za brisanje kosarice (jednog korisnika)
// Sve funkcije su inicijalno napisane za korištenje u kartice.js
//  za lakšu manipulaciju cookie-ja iz JavaScripta


// Postavljeni Cookie traje 7 dana
function setCookie(name, value) {
    const date = new Date();
    date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toUTCString();

    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Čitanje cookieja
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Brisanje (Overwriteanje cookija i postavljanje da odma istekne)
function eraseCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}

function spremi_artikl_u_kosaricu(userID, ponudaID, kolicina){
    
    let kosarica = getCookie("kosarica"+userID)
    kosarica = kosarica ? JSON.parse(kosarica) : {};

    // AKo je vec u kosarici dodaje količinu
    if(kosarica[parseInt(ponudaID)]){
        kosarica[parseInt(ponudaID)] = parseFloat(kosarica[parseInt(ponudaID)]) + parseFloat(kolicina);
    }
    // Inače ju tek inicijalizira
    else{
        kosarica[parseInt(ponudaID)] = parseFloat(kolicina);
    }


    // Set the updated cookie
    setCookie("kosarica"+userID, JSON.stringify(kosarica));
}

function makni_artikl_iz_kosarice(userID, ponudaID){
    
    let kosarica = getCookie("kosarica"+userID)
    kosarica = kosarica ? JSON.parse(kosarica) : {};

    if(kosarica){
        delete kosarica[parseInt(ponudaID)];
    }
    
    // Set the updated cookie
    setCookie("kosarica"+userID, JSON.stringify(kosarica));
}

function kolicina_artikla(userID, ponudaID){
    
    let kosarica = getCookie("kosarica"+userID)
    kosarica = kosarica ? JSON.parse(kosarica) : {};

    if(kosarica){
        return kosarica[parseInt(ponudaID)];
    }
    return null;
}

function isprazni_kosaricu(userID){
    eraseCookie("kosarica"+userID);
}