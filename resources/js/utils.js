import './light-dark'

if(document.querySelector('#profile-dropdown-button')) {
    // toggle dropdown menu
    document.querySelector('#profile-dropdown-button').addEventListener('click', () => {
        document.querySelector('#profile-dropdown-menu').classList.toggle('hidden')
    })
}



