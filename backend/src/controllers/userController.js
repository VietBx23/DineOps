const userService = require('../services/userService');

exports.getUsers = async (req, res) => {
  try {
    const users = await userService.getAllUsers();
    res.json(users);
  } catch (error) {
    res.status(500).json({ error: 'Unable to fetch users' });
  }
};

exports.createUser = async (req, res) => {
  try {
    const { name, email } = req.body;
    const result = await userService.createUser({ name, email });
    res.status(201).json({ id: result.insertId, name, email });
  } catch (error) {
    res.status(500).json({ error: 'Unable to create user' });
  }
};
