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

function prepareModal(num, veldNr, taskId) {
    let title = document.getElementById('title_'+veldNr).innerHTML;
    let description = document.getElementById('description_'+veldNr).innerHTML;
    let location = document.getElementById('location_'+veldNr).innerHTML;

    document.getElementById('modal_title_' + num).innerHTML = title;
    document.getElementById('modal_description_' + num).innerHTML = description;
    document.getElementById('modal_location_' + num).innerHTML = location;
    document.getElementById('modal_taskId_' + num).value = taskId;

    openModal(document.getElementById('modal' + num));
}

function modal(num,veldNr, taskId){
    if (num === 1){
        //Taak wijzigen
        if (document.getElementById('date_completed').value === "") {
            openModal(document.getElementById('modal1'));
        } else {
            alert('Een afgeronde taak kan niet meer gewijzigd worden!');
        }
    } else if (num === 2) {
        //Taak afronden
        alert(document.getElementById('date_completed').value);
        if (document.getElementById('date_completed').value === "") {
            prepareModal(num, veldNr, taskId)
        } else {
            alert("Je hebt deze taak al afgerond!");
        }
    } else {
        //Taak verwijderen
        prepareModal(num, veldNr, taskId)
    }
}