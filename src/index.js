const openModalButtons = document.querySelectorAll('[data-modal-target]');
const closeModalButtons = document.querySelectorAll('[data-close-button]');
const overlay = document.getElementById('overlay');

openModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.modalTarget);
        openModal(modal);
    })
})

overlay.addEventListener('click', () => {
    const modals = document.querySelectorAll('.modalActive');
    modals.forEach(modal => {
        closeModal(modal);
    })
})

closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal');
        closeModal(modal);
    })
})

function openModal(modal) {
    if (modal == null) return
    modal.classList.add('active');
    overlay.classList.add('active');
}

function closeModal(modal) {
    if (modal == null) return
    modal.classList.remove('active');
    overlay.classList.remove('active');
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.getElementById('location').value = '';
}

function modal(num,veldNr){
    if (num === 1){
        //Taak wijzigen
        //alert('Functie uitgeschakeld.');
        openModal(document.getElementById('modal1'));
    } else if (num === 2){
        //Taak afronden
        //alert('Functie uitgeschakeld.');
         openModal(document.getElementById('modal2'));
    } else if (num === 3){
        //Taak verwijderen
        let title = document.getElementById('title_'+veldNr).innerHTML;
        let description = document.getElementById('description_'+veldNr).innerHTML;
        let location = document.getElementById('location_'+veldNr).innerHTML;
        document.getElementById('modal_title').innerHTML = title;
        document.getElementById('modal_description').innerHTML = description;
        document.getElementById('modal_location').innerHTML = location;
        openModal(document.getElementById('modal3'));
    }
}