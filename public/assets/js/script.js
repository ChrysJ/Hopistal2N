const navLink = document.querySelectorAll('.nav-link');

// NavLink active
if (location.pathname == '/ajouterPatient') {
    navLink[0].classList.add('nav-active');
}
if (location.pathname == '/listePatients') {
    navLink[1].classList.add('nav-active');
}
if (location.pathname == '/ajouterRendez-vous') {
    navLink[2].classList.add('nav-active');
}
if (location.pathname == '/listeRendez-vous') {
    navLink[3].classList.add('nav-active');
}

