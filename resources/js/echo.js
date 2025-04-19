import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

// Exportamos Echo para que orders.js pueda importarlo
export default Echo
