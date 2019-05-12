const secondaRiga = document.getElementById('secondaRiga');
const ricercaAvanzata = document.getElementById('ricercaAvanzata');
const tableBody = document.getElementById('table-body');
const btnLogin = document.getElementById('btnLogin');
const btnLogout = document.getElementById('btnLogout');
const velo = document.getElementById('velo');
velo.show = () => {
    velo.style.display = "block";
};
velo.hide = () => {
    velo.style.display = "none";
    overlay_login.hide();
    overlay_prenotazione.hide();
    overlay_schedafilm.hide();
};

const overlay_login = document.getElementById('overlay_login');
overlay_login.show = () => {
    overlay_login.style.display = "block";
    velo.show();
};
overlay_login.hide = () => {
    overlay_login.style.display = "none";
    velo.hide();
};

const overlay_schedafilm = document.getElementById('overlay_schedafilm');
overlay_schedafilm.show = () => {
    overlay_schedafilm.style.display = "block";
    velo.show();
};
overlay_schedafilm.hide = () => {
    overlay_schedafilm.style.display = "none";
    velo.hide();
};

const overlay_prenotazione = document.getElementById('overlay_prenotazione');
overlay_prenotazione.show = () => {
    overlay_prenotazione.style.display = "block";
    velo.show();
};
overlay_prenotazione.hide = () => {
    overlay_prenotazione.style.display = "none";
    velo.hide();
};


const liste = {
    genere: document.getElementById('listagenere'),
    titoli: document.getElementById('listatitoli'),
    regista: document.getElementById('listaregista'),
    anni: document.getElementById('listaanni'),
    lingua_audio: document.getElementById('listaaudio'),
    lingua_sottotitoli: document.getElementById('listasottotitoli'),
    rating: document.getElementById('rating'),
    disponibilita: document.getElementById('listadispobibilita'),
};
const datalists = {
    titoli: document.getElementById("inputtitolo"),
    genere: document.getElementById("inputgenere"),
    regista: document.getElementById("inputregista"),
};
let count_rows = 1;
let logged = false;

function addOption(lista, value) {
    let el = document.createElement('option');
    el.value = value;
    el.innerText = value;
    lista.appendChild(el);
}

function addRow(id, titolo, regista, genere, anno, lingua_audio, lingua_sottotitoli, disponibilita) {
    let row = document.createElement('tr');
    row.onclick = () => {
        onrowclick({});
    };
    row.style.cursor = "pointer";

    function td(text = "") {
        let td = document.createElement('td');
        td.innerText = text;
        return td;
    }

    let N = document.createElement('th');
    N.scope = "row";
    N.innerText = id;
    row.appendChild(N);
    row.appendChild(td(titolo));
    row.appendChild(td(regista));
    row.appendChild(td(genere));
    row.appendChild(td(anno));
    row.appendChild(td(lingua_audio));
    row.appendChild(td(lingua_sottotitoli));
    const disp = td(disponibilita);
    disp.style.fontWeight = (disponibilita === "Si") ? "normal" : "bold";
    row.appendChild(disp);

    let btn_prenota = document.createElement("button");
    btn_prenota.value = id;
    btn_prenota.type = "button";
    btn_prenota.innerText = "Prenota";
    btn_prenota.disabled = (logged) ? (disponibilita !== "Si") : true;
    btn_prenota.className = "btn btn-primary";
    if (!logged)
        btn_prenota.style.cursor = "not-allowed";
    btn_prenota.onclick = () => {
        prenotazione(btn_prenota.value);
    };
    let Prenota = td();
    Prenota.appendChild(btn_prenota);
    row.appendChild(Prenota);

    tableBody.appendChild(row);
}

function onrowclick() {
    velo.show();
}

function onclosevelo() {
    velo.hide();
}

function onformsubmit() {
    try {
        const params = {};
        Object.keys(liste).forEach(key => {
            let obj = liste[key];
            let v;
            if (obj.tagName === "SELECT") {
                v = obj.value;
            } else if (obj.tagName === "DATALIST") {
                v = datalists[key].value;
            } else {
                return false;
            }
            if (v && v !== "")
                params[key] = v;
        });
        console.log(params);
    } catch (e) {

    }
    return false;
}

function onformlogin() {
    try {
        $.get("../backend/admin_api.php/login", (data) => {
            let response = JSON.parse(data);
            if (response.logged)
                if (response.logged === "true") {
                    logged = true;
                    console.info("logged");
                }
        }).fail(() => {
            console.info("not logged");
        }).always(() => {
            if (logged) {
                btnLogin.style.display = "none";
                btnLogout.style.display = "block";
            } else {
                btnLogin.style.display = "block";
                btnLogout.style.display = "none";
            }
            request_dvd({});
        });
    } catch (e) {

    }
    return false;
}

function request_dvd(params) {
    $.ajax({
        url: "../backend/user_api.php/" + "dvd",
        data: params,
        success: function (result, status, xhr) {
            let json = JSON.parse(result);
            console.log(json);
            json.contenuto.dvd.forEach(row => {
                addRow(row.Catalogo, row.Titolo, row.Regia, row.Genere, row.Anno, row.Lingua_Originale, row.Sottotitoli, row.Disponibilita)
            });
        },
        error: function () {
            console.error("Errore restituzione dvd");
        }
    });
}

function prenotazione(value) {
    overlay_prenotazione.show();
}

btnLogin.onclick = () => {
    overlay_login.show();
};

btnLogout.onclick = () => {
    $.get("../backend/admin_api.php/logout", () => {
        logged = false;
    });
};

ricercaAvanzata.onclick = () => {
    $(secondaRiga).toggle('slow');
};

window.onload = function () {
    secondaRiga.style.display = 'none';

    $.ajax({
        url: "../backend/user_api.php/" + "list",
        data: {"titoli": 2, "genere": 1, "regia": 1, "anno": 1, "lingua_audio": 1, "lingua_sottotitoli": 1},
        success: function (result) {
            let json = JSON.parse(result);
            // console.log(json);
            if (json.contenuto.genere)
                json.contenuto.genere.forEach((genere) => addOption(liste.genere, genere));
            if (json.contenuto.titoli)
                json.contenuto.titoli.forEach((value) => addOption(liste.titoli, value));
            if (json.contenuto.regia)
                json.contenuto.regia.forEach((value) => addOption(liste.regista, value));
            if (json.contenuto.anno)
                json.contenuto.anno.forEach((value) => addOption(liste.anni, value));
            if (json.contenuto.lingua_audio)
                json.contenuto.lingua_audio.forEach((value) => addOption(liste.lingua_audio, value));
            if (json.contenuto.lingua_sottotitoli)
                json.contenuto.lingua_sottotitoli.forEach((value) => addOption(liste.lingua_sottotitoli, value));
        },
        error: function (err) {
            console.error("Server non raggiungibile, oppure errore generico.");
        }
    });

    $.get("../backend/admin_api.php/is_logged", (data) => {
        let response = JSON.parse(data);
        if (response.logged)
            if (response.logged === "true") {
                logged = true;
                console.info("logged");
            }
    }).fail(() => {
        console.info("not logged");
    }).always(() => {
        if (logged) {
            btnLogin.style.display = "none";
            btnLogout.style.display = "block";
        } else {
            btnLogin.style.display = "block";
            btnLogout.style.display = "none";
        }
        request_dvd({});
    });
};


for (let i = 0; i < 20; i++) {
    addRow();
}