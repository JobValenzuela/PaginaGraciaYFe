import { ref, nextTick } from 'vue'
import { responseMessages } from './ResponseHandler'

/*
* Clase manejadora de mensajes de la aplicación
*/
class DialogHandler {
  constructor() {
    this.type = ref('')
    this.message = ref('')
  }

  is(e, type) {
    return e.response?.data?.status === type
  }

  async show(type, message) {
    this.type.value = type
    this.message.value = message

    await nextTick() // Espera a que el DOM se actualice

    // Desplazar la pantalla hasta el elemento con id 'topbar'
    const topbar = document.querySelector('#topbar')
    if (topbar) {
      topbar.scrollIntoView({ behavior: 'smooth' })
    }

    setTimeout(() => {
      this.type.value = ''
      this.message.value = ''
    }, 3000)
  }

  handleError(e, handlers) {
    if (handlers) {
      for (const handler of handlers) {
        if (this.is(e, handler.status)) {
          if (handler.message) this.show('error', handler.message)

          if (handler.callback) {
            handler.callback()
          }

          return
        }
      }
    }

    const message = responseMessages[e.response?.data?.status] || 'Ocurrió un error'
    this.show('error', message)
  }
}

export default DialogHandler