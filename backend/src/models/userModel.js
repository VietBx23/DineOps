const mongoose = require('mongoose');

const userSchema = new mongoose.Schema({
  name: { type: String, required: true },
  email: { type: String, required: true, unique: true },
  password: { type: String },
  role: {
    type: String,
    enum: ['admin', 'manager', 'staff', 'kitchen'],
    default: 'staff',
  },
  organizationId: { type: mongoose.Schema.Types.ObjectId, ref: 'Organization' },
  storeId: { type: mongoose.Schema.Types.ObjectId, ref: 'Store' },
  status: { type: String, enum: ['active', 'inactive'], default: 'active' },
  createdAt: { type: Date, default: Date.now },
});

module.exports = mongoose.model('User', userSchema);
