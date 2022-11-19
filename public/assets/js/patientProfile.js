const infoPatient = document.querySelector('.info-patient');
const formUpdatePatient = document.querySelector('.form-update-patient');
const patientAppointments = document.querySelector('.patient-appointments');

const navLinksPatient = document.querySelectorAll('.nav-link-patient');

navLinksPatient.forEach(navLinkPatient => {
    navLinkPatient.addEventListener('click', () => {
        removeNavPatientActive();
        navLinkPatient.classList.add('nav-patient-active');

        if (navLinksPatient[0].classList.contains('nav-patient-active')) {
            infoPatient.classList.remove('switch-box-patient');
            formUpdatePatient.classList.add('switch-box-patient');
            patientAppointments.classList.add('switch-box-patient');
        } else if (navLinksPatient[1].classList.contains('nav-patient-active')) {
            infoPatient.classList.add('switch-box-patient');
            formUpdatePatient.classList.remove('switch-box-patient');
            patientAppointments.classList.add('switch-box-patient');
        } else if (navLinksPatient[2].classList.contains('nav-patient-active')) {
            infoPatient.classList.add('switch-box-patient');
            formUpdatePatient.classList.add('switch-box-patient');
            patientAppointments.classList.remove('switch-box-patient');
        };
    })
});

const removeNavPatientActive = () => {
    navLinksPatient.forEach(navLinkPatient => {
        navLinkPatient.classList.remove('nav-patient-active');
    });
};