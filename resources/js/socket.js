import io from 'socket.io-client';

const socket = io('http://localhost:3000'); // Replace with your server URL and port

export default socket;
