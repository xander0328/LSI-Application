import io from 'socket.io-client';

const socket = io('https://lsi-socketio.vercel.app/api/socket'); // Replace with your server URL and port

export default socket;
