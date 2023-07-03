// light mode and dark mode
let theme =  localStorage.getItem('theme') ? JSON.parse(localStorage.getItem('theme')).theme : 'light'
const lightBtn = document.querySelector('#light-btn')
const darkBtn = document.querySelector('#dark-btn')

// reusable functions
const changeLight = () => {
    document.documentElement.classList.remove('dark')

    lightBtn.classList.remove('hidden')
    darkBtn.classList.add('hidden')
}

const changeDark = () => {
    document.documentElement.classList.add('dark')

    lightBtn.classList.add('hidden')
    darkBtn.classList.remove('hidden')
}


if(theme === 'light') {
    changeLight()
}else {
    changeDark()
}

// click actions
lightBtn.addEventListener('click', () => {
    changeDark()

    localStorage.setItem('theme', JSON.stringify({ theme: 'dark'}))

})
darkBtn.addEventListener('click', () => {
    changeLight()

    localStorage.setItem('theme', JSON.stringify({ theme: 'light'}))
})

// hide flash message
if(document.querySelector('#flash-message')) {
    setTimeout(() => {
        document.querySelector('#flash-message').classList.add('hidden')
    }, 3000)
}
