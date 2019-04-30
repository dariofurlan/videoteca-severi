const secondaRiga = document.getElementById('secondaRiga');
const ricercaAvanzata = document.getElementById('ricercaAvanzata');
const liste = {
  genere: document.getElementById('listagenere'),
  titoli: document.getElementById('listatitoli'),
  regista: document.getElementById('listaregista'),
  anni: document.getElementById('listaanni'),
  lingua_audio: document.getElementById('listaaudio'),
  lingua_sottotitoli: document.getElementById('listasottotitoli'),
};

function addOption(lista, value) {
  let el = document.createElement('option');
  el.value = value;
  el.innerText = value;
  lista.appendChild(el);
}

ricercaAvanzata.onclick = () => {
  $(secondaRiga).toggle('slow');
};

window.onload = function () {
    secondaRiga.style.display = 'none';

    $.ajax({
      url: "../backend/user_api.php/"+"list",
      data: {"titoli":2,"genere":1},
      success: function(result, status, xhr) {
        let json = JSON.parse(result);
        console.log(json);
        if (json.contenuto.genere)
          json.contenuto.genere.forEach((genere)=>addOption(liste.genere, genere));
        if (json.contenuto.titoli)
          json.contenuto.titoli.forEach((value)=>addOption(liste.titoli, value));
      },
      error: function(aa) {
        console.error(aa);
      }
    });
};




// inizialmente lista:  Titoli, genere
// lista poi: regista, anni, lingua_audio, lingua_sottotitoli
