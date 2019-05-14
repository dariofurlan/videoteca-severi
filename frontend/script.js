const secondaRiga = document.getElementById('secondaRiga');
const ricercaAvanzata = document.getElementById('ricercaAvanzata');
const tableBody = document.getElementById('table-body');
const btnLogin = document.getElementById('btnLogin');
const btnLogout = document.getElementById('btnLogout');
const btnReset = document.getElementById('reset');

function Overlay() {
    this.velo = document.getElementById('velo');
    this.loaded = null;

    this.prenotazione = (id) => {
        console.log(id);
        this.loaded = document.getElementById('overlay_prenotazione');
        return this;
    };

    this.schedafilm = (id) => {
        console.log(id);
        this.loaded = document.getElementById('overlay_schedafilm');
        return this;
    };

    this.login = () => {
        this.loaded = document.getElementById('overlay_login');
        const login_form = document.getElementById('login-form');

        login_form.onsubmit = () => {
            try {
                let username = login_form[0].value;
                let password = login_form[1].value;
                $.ajax({
                    type: "POST",
                    url: "http://10.0.1.252/biblioteca/biblio/backend/admin_api.php/login",
                    data: {username, password}
                }).done((data) => {
                    let response = JSON.parse(data);
                    if (response.logged && response.logged === "true") {
                        logged = true;
                        console.info("logged");
                    }
                }).fail(() => {

                }).always(() => {
                    if (logged) {
                        btnLogin.style.display = "none";
                        btnLogout.style.display = "block";
                        this.hide();
                        request_dvd();
                    } else {
                        btnLogin.style.display = "block";
                        btnLogout.style.display = "none";
                        alert("Login Errato!");
                    }
                });
            } catch (e) {

            }
            return false;
        };
        return this;
    };

    this.show = () => {
        this.velo.style.display = "block";
        this.loaded.style.display = "block";
    };

    this.hide = () => {
        this.velo.style.display = "none";
        this.loaded.style.display = "none";
    };
}

const overlay = new Overlay();

const liste = {
    genere: document.getElementById('listagenere'),
    titoli: document.getElementById('listatitoli'),
    regista: document.getElementById('listaregista'),
    anni: document.getElementById('listaanni'),
    lingua_audio: document.getElementById('listaaudio'),
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

function addOptionToList(lista, value) {
    let el = document.createElement('option');
    el.value = value;
    el.innerText = value;
    lista.appendChild(el);
}

function addRow(id, titolo, regista, genere, anno, lingua_originale, disponibilita) {
    let row = document.createElement('tr');
    let onclick = () => {
        overlay.schedafilm(id).show();
    };

    function td(text = "") {
        let td = document.createElement('td');
        td.innerText = text;
        td.onclick = onclick;
        td.style.cursor = "pointer";
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
    row.appendChild(td(lingua_originale));
    const disp = td(disponibilita);
    disp.style.fontWeight = (disponibilita === "Si") ? "normal" : "bold";
    row.appendChild(disp);

    let btn_prenota = document.createElement("button");
    btn_prenota.value = id;
    btn_prenota.type = "button";
    btn_prenota.innerText = "Prenota";
    btn_prenota.disabled = (logged) ? (disponibilita !== "Si") : true;
    btn_prenota.className = "btn btn-primary btn-prenota";
    if (!logged)
        btn_prenota.style.cursor = "not-allowed";
    btn_prenota.onclick = () => {
        overlay.prenotazione(btn_prenota.value).show();
    };
    let Prenota = td();
    Prenota.onclick = null;
    Prenota.style.cursor = "default";
    Prenota.appendChild(btn_prenota);
    row.appendChild(Prenota);

    tableBody.appendChild(row);
}

function onclosevelo() {
    overlay.hide();
}

function onformsubmit() {
    try {
        request_dvd(params);
    } catch (e) {

    }
    return false;
}

function onformlogin() {

}

function request_dvd() {
    tableBody.innerHTML = "";
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
    $.ajax({
        url: "../backend/user_api.php/" + "dvd",
        data: params,
        success: function (result) {
            let json = JSON.parse(result);
            console.log(json);
            json.contenuto.dvd.forEach(row => {
                addRow(row.Inventario, row.Titolo, row.Regia, row.Nome_Genere, row.Anno, row.Lingua_Originale, row.Disponibilita)
            });
        },
        error: function () {
            console.error("Errore restituzione dvd");
        }
    });
}

btnReset.onclick = () => {
    Object.keys(liste).forEach(key => {
        let obj = liste[key];
        let v;
        if (obj.tagName === "SELECT") {
            obj.selectedIndex = 0;
        } else if (obj.tagName === "DATALIST") {
            datalists[key].value = "";
        } else {
            return false;
        }
    });
};

btnLogin.onclick = () => {
    overlay.login().show();
};

btnLogout.onclick = () => {
    $.get("http://10.0.1.252/biblioteca/biblio/backend/admin_api.php/logout", () => {
        logged = false;
        request_dvd();
        btnLogin.style.display = "block";
        btnLogout.style.display = "none";
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
            if (json.contenuto.genere)
                json.contenuto.genere.forEach((genere) => addOptionToList(liste.genere, genere));
            if (json.contenuto.titoli)
                json.contenuto.titoli.forEach((value) => addOptionToList(liste.titoli, value));
            if (json.contenuto.regia)
                json.contenuto.regia.forEach((value) => addOptionToList(liste.regista, value));
            if (json.contenuto.anno)
                json.contenuto.anno.forEach((value) => addOptionToList(liste.anni, value));
            if (json.contenuto.lingua_audio)
                json.contenuto.lingua_audio.forEach((value) => addOptionToList(liste.lingua_audio, value));
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
        addRow();
    });
};
