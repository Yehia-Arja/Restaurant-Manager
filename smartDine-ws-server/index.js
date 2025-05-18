const express = require('express');
const http = require('http');
const cors = require('cors');
const { Server } = require('socket.io');

const app = express();
app.use(cors());
const server = http.createServer(app);

const io = new Server(server, {
  cors: {
    origin: '*',
    methods: ['GET', 'POST']
  }
});

io.on('connection', socket => {
  console.log('New client connected');

  socket.on('disconnect', () => {
    console.log('Client disconnected');
  });
});

// Laravel will call this
app.post('/api/broadcast', express.json(), (req, res) => {
  const { table_id, is_occupied } = req.body;
  io.emit('table_update', { table_id, is_occupied });
  return res.status(200).json({ success: true });
});

const PORT = 3001;
server.listen(PORT, () => {
  console.log(`WebSocket server running on port ${PORT}`);
});
