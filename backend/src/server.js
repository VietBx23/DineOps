const dotenv = require('dotenv');
const http = require('http');
const app = require('./app');
const db = require('./config/db');
const initSockets = require('./socket');

dotenv.config();

const port = process.env.PORT || 4000;
const server = http.createServer(app);

initSockets(server);

db.connect()
  .then(() => {
    server.listen(port, () => {
      console.log(`Backend listening on http://localhost:${port}`);
    });
  })
  .catch((error) => {
    console.error('Failed to start server:', error);
  });

