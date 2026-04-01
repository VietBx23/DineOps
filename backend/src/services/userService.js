const userModel = require('../models/userModel');

exports.getAllUsers = async () => {
  return userModel.fetchAll();
};

exports.createUser = async ({ name, email }) => {
  return userModel.create({ name, email });
};
