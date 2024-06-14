const pages = {
    1: 'cadastro',
    2: 'busca',
    3: 'lista'
};
let activePage = 1;

function changePage(page, obj) {
    if (page in pages) {
        activePage = page;
        Object.values(pages).forEach(page => {
            document.querySelector('.page#' + page).style.display = 'none';
        });
        document.querySelector('.page#' + pages[page]).style.display = 'block';
    }
    document.querySelectorAll('a.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    obj.classList.add('active');

}

