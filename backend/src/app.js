const express = require('express');
const cors = require('cors');
const userRoutes = require('./routes/users');
const orderRoutes = require('./routes/orders');

const app = express();

app.use(cors());
app.use(express.json());

app.get('/api/health', (req, res) => {
  res.json({ status: 'ok', timestamp: Date.now() });
});

app.use('/api/users', userRoutes);
app.use('/api/orders', orderRoutes);

module.exports = app;
