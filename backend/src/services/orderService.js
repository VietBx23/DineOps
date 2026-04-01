const Order = require('../models/orderModel');

exports.fetchAll = async () => {
  return Order.find().sort({ createdAt: -1 });
};

exports.create = async ({ storeId, tableId, items }) => {
  const order = new Order({ storeId, tableId, items });
  return order.save();
};
