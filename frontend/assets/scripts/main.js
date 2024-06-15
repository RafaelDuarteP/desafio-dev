// CONSTANTES

const API_URL = 'http://localhost:8080';

// NAVEGAÇÃO ENTRE AS PÁGINAS

const pages = {
    1: 'cadastro',
    2: 'busca',
    3: 'lista'
};

function changePage(page, obj) {
    if (page in pages) {
        Object.values(pages).forEach(page => {
            document.querySelector(`.page#${page}`).style.display = 'none';
        });
        document.querySelector(`.page#${pages[page]}`).style.display = 'block';
    }
    document.querySelectorAll('a.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    obj.classList.add('active');
}

// FUNÇÕES DE ACESSO A API

async function fetchData(url) {
    try {
        const response = await fetch(url);
        if (response.status === 404) {
            return null;
        }
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Could not fetch data:", error);
    }
}

async function postData(url, data) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const responseData = await response.json();
        return responseData;
    } catch (error) {
        console.error("Could not post data:", error);
    }
}


// FUNÇÕES DE PREENCHIMENTO DE DADOS

function preencheCidadao(local, data) {
    const cardCidadao = document.querySelector(`#${local} .card-cidadao`);
    if (data) {
        cardCidadao.innerHTML = generateCidadaoHTML(data);
    } else {
        cardCidadao.innerHTML = generateNotFoundHTML();
    }
}

function generateCidadaoHTML(data) {
    return `
        <div class="row justify-content-center">
            <img class="col-3 col-md-3" src="./assets/imgs/user_icon.svg" alt="">
            <div class="col-8 col-md-auto">
                <div class="row align-items-center h-100">
                    <h3 class="col-12">${data.nome}</h3>
                    <p class="col-12">NIS: ${data.nis}</p>
                </div>
            </div>
        </div>
    `;
}

function generateNotFoundHTML() {
    return '<h3 class="text-center">Cidadão não encontrado</h3>';
}

function generateRows(data) {
    let rows = "";
    for (let i = 0; i < data.length; i++) {
        rows += `
        <tr>
            <th scope="row">${data[i].nis}</th>
            <td>${data[i].nome}</td>
        </tr>
        `;
    }
    return rows;
}

function updateTable(rows) {
    const table = document.querySelector('#lista-cidadaos>tbody');
    if (rows !== "") {
        table.innerHTML = rows;
    }
}


// FUNÇÕES DE CADASTRO E BUSCA

async function criaCidadao(event) {
    event.preventDefault();
    const inputNome = document.querySelector('#nome');
    validaNome(inputNome);
    const value = inputNome.value
    if (validaNome(inputNome)) {
        alertNome();
        return;
    };
    inputNome.value = '';
    try {
        const data = {
            nome: value
        };
        const response = await postData(`${API_URL}/cidadaos`, data);
        preencheCidadao('cadastro', response);
    } catch (error) {
        console.error("Erro ao cadastrar cidadão:", error);
    }
}

async function buscaCidadao(event) {
    event.preventDefault();
    const inputNis = document.querySelector('#nis');
    const value = inputNis.value;
    if (validaNis(inputNis)) {
        alertNis();
        return;
    }
    inputNis.value = '';
    try {
        const response = await fetchData(`${API_URL}:8080/cidadaos/${value}`);
        preencheCidadao('busca', response);
    } catch (error) {
        console.error("Erro ao buscar dados do cidadão:", error);
    }
}

async function buscaAllCidadaos() {
    const response = await fetchData(`${API_URL}/cidadaos`);
    const rows = generateRows(response);
    updateTable(rows);
}

// MASCARA DE FORMULÁRIO

function mascaraNis(event) {
    event.target.value = event.target.value
        .replace(/[^0-9]/g, '');
}

// COMPONENTES DO DOM

const formBusca = document.querySelector('#form-busca');
const formCadastro = document.querySelector('#form-cadastro');
const listaCidadaos = document.querySelector('#lista');
const inputNis = document.querySelector('#nis');

// LISTENERS

inputNis.addEventListener('input', mascaraNis);
formBusca.addEventListener('submit', buscaCidadao);
formCadastro.addEventListener('submit', criaCidadao);
document.addEventListener("DOMContentLoaded", function () {
    function handlePageStyleChange(mutations) {
        mutations.forEach(mutation => {
            if (mutation.attributeName === "style") {
                let target = mutation.target;
                if (target.style.display === "block") {
                    buscaAllCidadaos();
                }
            }
        });
    }

    const observer = new MutationObserver(handlePageStyleChange);
    const config = { attributes: true, attributeFilter: ['style'] };

    observer.observe(listaCidadaos, config);
});

// VALIDAÇÃO DE FORMULÁRIO

function validaNome(input) {
    const value = input.value;
    return (value.length < 3)
}

function alertNome() {
    alert("Nome deve ter no mínimo 3 caracteres.");
}

function validaNis(input) {
    const value = input.value;
    return (value.length !== 11)
}

function alertNis() {
    alert("NIS deve ter 11 caracteres.");
}

// CRÉDITOS

function imprimirCreditos() {
    console.log("%cFeito por Rafael Duarte Pereira - https://www.rafaelduartep.dev", "background: #009688; color: #FFFFFF; font-size: 13px; padding: 8px; border-radius: 5px;");
}

imprimirCreditos();