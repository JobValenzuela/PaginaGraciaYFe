import Swal from 'sweetalert2'
import UserStore from '@/stores/UserStore'
let background = ''
let foreground = ''

const setTheme = () => {
    const userStore = UserStore()
    
    if (!userStore.modo) {
        background = '#212121'
        foreground = '#fff'
    } else {
        background = '#fff'
        foreground = '#000'
    }
}

export const showConfirmDialog = async (title, text, confirmBtnText = 'Continuar', cancelBtnText = 'Cancelar') => {
    setTheme()

    const confirm = await Swal.fire({
        color: foreground,
        background: background,
        title: title,
        text: text,
        icon: "info",
        showCancelButton: true,
        confirmButtonText: confirmBtnText,
        cancelButtonText: cancelBtnText,
        confirmButtonColor: '#607D8B',
        cancelButtonColor: '#263238'
    })

    return confirm.isConfirmed
}

export const showDialog = async (type, text) => {
    setTheme()

    return await Swal.fire({
        position: 'top-end',
        toast: true,
        background: background,
        color: foreground,
        icon: type,
        html: `<p>${text}</p>`,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    })
}