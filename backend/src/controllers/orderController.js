const orderService = require('../services/orderService');

exports.getOrders = async (req, res) => {
  try {
    const orders = await orderService.fetchAll();
    res.json(orders);
  } catch (error) {
    res.status(500).json({ error: 'Unable to fetch orders' });
  }
};

exports.createOrder = async (req, res) => {
  try {
    const { storeId, tableId, items } = req.body;
    const order = await orderService.create({ storeId, tableId, items });
    res.status(201).json(order);
  } catch (error) {
    res.status(500).json({ error: 'Unable to create order' });
  }
};
