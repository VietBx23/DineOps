const db = require('../config/db');

exports.fetchAll = () => {
  return new Promise((resolve, reject) => {
    db.query('SELECT id, name, email FROM users', (err, results) => {
      if (err) return reject(err);
      resolve(results);
    });
  });
};

exports.create = ({ name, email }) => {
  return new Promise((resolve, reject) => {
    db.query(
      'INSERT INTO users (name, email) VALUES (?, ?)',
      [name, email],
      (err, result) => {
        if (err) return reject(err);
        resolve(result);
      }
    );
  });
};
