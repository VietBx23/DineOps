-- ============================================================
--  F&B Management System — MySQL Database Schema
--  Version : 1.0
--  Engine  : InnoDB | Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO';

-- ============================================================
-- DATABASE
-- ============================================================
CREATE DATABASE IF NOT EXISTS fnb_management
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE fnb_management;

-- ============================================================
-- 1. ORGANIZATIONS
-- ============================================================
CREATE TABLE organizations (
  id            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  name          VARCHAR(120)    NOT NULL,
  slug          VARCHAR(120)    NOT NULL,
  status        ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_org_slug (slug)
) ENGINE=InnoDB;

-- ============================================================
-- 2. CITIES
-- ============================================================
CREATE TABLE cities (
  id              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  organization_id INT UNSIGNED  NOT NULL,
  name            VARCHAR(100)  NOT NULL,
  created_at      DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_city_org (organization_id),
  CONSTRAINT fk_city_org
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 3. STORES
-- ============================================================
CREATE TABLE stores (
  id              INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  organization_id INT UNSIGNED    NOT NULL,
  city_id         INT UNSIGNED    NOT NULL,
  name            VARCHAR(120)    NOT NULL,
  address         VARCHAR(255)        NULL,
  phone           VARCHAR(20)         NULL,
  status          ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_store_org  (organization_id),
  KEY idx_store_city (city_id),
  CONSTRAINT fk_store_org
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_store_city
    FOREIGN KEY (city_id) REFERENCES cities(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 4. USERS
-- ============================================================
CREATE TABLE users (
  id              INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  organization_id INT UNSIGNED    NOT NULL,
  store_id        INT UNSIGNED        NULL,           -- NULL for admin
  name            VARCHAR(100)    NOT NULL,
  email           VARCHAR(180)    NOT NULL,
  password_hash   VARCHAR(255)    NOT NULL,           -- bcrypt
  role            ENUM('admin','manager','staff','kitchen') NOT NULL,
  status          ENUM('active','inactive') NOT NULL DEFAULT 'active',
  last_login_at   DATETIME            NULL,
  created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_user_email (email),
  KEY idx_user_org   (organization_id),
  KEY idx_user_store (store_id),
  CONSTRAINT fk_user_org
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_user_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 5. TABLES (dining tables)
-- ============================================================
CREATE TABLE tables (
  id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  store_id    INT UNSIGNED    NOT NULL,
  name        VARCHAR(60)     NOT NULL,               -- e.g. "Bàn 01"
  code        VARCHAR(40)     NOT NULL,               -- QR token: HCM_Q1_B01_X7H2
  capacity    TINYINT UNSIGNED    NULL,
  status      ENUM('available','occupied','reserved','inactive') NOT NULL DEFAULT 'available',
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_table_code (store_id, code),
  KEY idx_table_store (store_id),
  CONSTRAINT fk_table_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 6. CATEGORIES (product categories)
-- ============================================================
CREATE TABLE categories (
  id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  store_id    INT UNSIGNED    NOT NULL,
  name        VARCHAR(80)     NOT NULL,
  sort_order  SMALLINT        NOT NULL DEFAULT 0,
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_cat_store (store_id),
  CONSTRAINT fk_cat_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 7. PRODUCTS
-- ============================================================
CREATE TABLE products (
  id          INT UNSIGNED        NOT NULL AUTO_INCREMENT,
  store_id    INT UNSIGNED        NOT NULL,
  category_id INT UNSIGNED            NULL,
  name        VARCHAR(120)        NOT NULL,
  description TEXT                    NULL,
  price       DECIMAL(12,2)       NOT NULL,
  image_url   VARCHAR(500)            NULL,
  status      ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at  DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_prod_store    (store_id),
  KEY idx_prod_category (category_id),
  CONSTRAINT fk_prod_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_prod_cat
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 8. INGREDIENTS
-- ============================================================
CREATE TABLE ingredients (
  id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  store_id    INT UNSIGNED    NOT NULL,
  name        VARCHAR(120)    NOT NULL,
  unit        VARCHAR(20)     NOT NULL,               -- e.g. gram, ml, cái
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_ing_store (store_id),
  CONSTRAINT fk_ing_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 9. RECIPES (1 product → 1 recipe head)
-- ============================================================
CREATE TABLE recipes (
  id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  product_id  INT UNSIGNED    NOT NULL,
  note        VARCHAR(255)        NULL,
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_recipe_product (product_id),
  CONSTRAINT fk_recipe_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 10. RECIPE_INGREDIENTS (recipe lines)
-- ============================================================
CREATE TABLE recipe_ingredients (
  id            INT UNSIGNED        NOT NULL AUTO_INCREMENT,
  recipe_id     INT UNSIGNED        NOT NULL,
  ingredient_id INT UNSIGNED        NOT NULL,
  quantity      DECIMAL(10,4)       NOT NULL,         -- per 1 serving

  PRIMARY KEY (id),
  UNIQUE KEY uq_recipe_ing (recipe_id, ingredient_id),
  KEY idx_ri_ing (ingredient_id),
  CONSTRAINT fk_ri_recipe
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_ri_ing
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 11. INVENTORY (current stock per ingredient per store)
-- ============================================================
CREATE TABLE inventory (
  id            INT UNSIGNED        NOT NULL AUTO_INCREMENT,
  store_id      INT UNSIGNED        NOT NULL,
  ingredient_id INT UNSIGNED        NOT NULL,
  quantity      DECIMAL(14,4)       NOT NULL DEFAULT 0,
  updated_at    DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_inv_store_ing (store_id, ingredient_id),
  KEY idx_inv_ing (ingredient_id),
  CONSTRAINT fk_inv_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_inv_ing
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 12. ORDERS
-- ============================================================
CREATE TABLE orders (
  id              INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  store_id        INT UNSIGNED    NOT NULL,
  table_id        INT UNSIGNED    NOT NULL,
  created_by      INT UNSIGNED        NULL,           -- staff user_id
  status          ENUM('pending','cooking','done','cancelled') NOT NULL DEFAULT 'pending',
  note            TEXT                NULL,
  total_amount    DECIMAL(14,2)   NOT NULL DEFAULT 0,
  created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_order_store      (store_id),
  KEY idx_order_table      (table_id),
  KEY idx_order_status     (store_id, status),
  KEY idx_order_created_at (store_id, created_at),
  CONSTRAINT fk_order_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_order_table
    FOREIGN KEY (table_id) REFERENCES tables(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_order_staff
    FOREIGN KEY (created_by) REFERENCES users(id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 13. ORDER_ITEMS
-- ============================================================
CREATE TABLE order_items (
  id          INT UNSIGNED        NOT NULL AUTO_INCREMENT,
  order_id    INT UNSIGNED        NOT NULL,
  product_id  INT UNSIGNED        NOT NULL,
  quantity    SMALLINT UNSIGNED   NOT NULL DEFAULT 1,
  unit_price  DECIMAL(12,2)       NOT NULL,           -- snapshot at order time
  note        VARCHAR(255)            NULL,

  PRIMARY KEY (id),
  KEY idx_oi_order   (order_id),
  KEY idx_oi_product (product_id),
  CONSTRAINT fk_oi_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_oi_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 14. STOCK_IMPORTS (nhập kho — header)
-- ============================================================
CREATE TABLE stock_imports (
  id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  store_id    INT UNSIGNED    NOT NULL,
  created_by  INT UNSIGNED        NULL,
  note        VARCHAR(255)        NULL,
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_si_store (store_id),
  KEY idx_si_date  (store_id, created_at),
  CONSTRAINT fk_si_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_si_user
    FOREIGN KEY (created_by) REFERENCES users(id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 15. STOCK_IMPORT_ITEMS (nhập kho — lines)
-- ============================================================
CREATE TABLE stock_import_items (
  id            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  import_id     INT UNSIGNED    NOT NULL,
  ingredient_id INT UNSIGNED    NOT NULL,
  quantity      DECIMAL(14,4)   NOT NULL,
  unit_cost     DECIMAL(12,2)       NULL,

  PRIMARY KEY (id),
  KEY idx_sii_ing (ingredient_id),
  CONSTRAINT fk_sii_import
    FOREIGN KEY (import_id) REFERENCES stock_imports(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_sii_ing
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 16. STOCK_EXPORTS (xuất kho — header)
--     type: 'order' (auto) | 'manual' (manager)
-- ============================================================
CREATE TABLE stock_exports (
  id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  store_id    INT UNSIGNED    NOT NULL,
  order_id    INT UNSIGNED        NULL,               -- set when type='order'
  created_by  INT UNSIGNED        NULL,
  type        ENUM('order','manual','waste') NOT NULL DEFAULT 'order',
  note        VARCHAR(255)        NULL,
  created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_se_store (store_id),
  KEY idx_se_order (order_id),
  KEY idx_se_date  (store_id, created_at),
  CONSTRAINT fk_se_store
    FOREIGN KEY (store_id) REFERENCES stores(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_se_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_se_user
    FOREIGN KEY (created_by) REFERENCES users(id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 17. STOCK_EXPORT_ITEMS (xuất kho — lines)
-- ============================================================
CREATE TABLE stock_export_items (
  id            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  export_id     INT UNSIGNED    NOT NULL,
  ingredient_id INT UNSIGNED    NOT NULL,
  quantity      DECIMAL(14,4)   NOT NULL,

  PRIMARY KEY (id),
  KEY idx_sei_ing (ingredient_id),
  CONSTRAINT fk_sei_export
    FOREIGN KEY (export_id) REFERENCES stock_exports(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_sei_ing
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 18. ORDER_STATUS_LOGS (audit trail)
-- ============================================================
CREATE TABLE order_status_logs (
  id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  order_id    INT UNSIGNED    NOT NULL,
  from_status VARCHAR(20)         NULL,
  to_status   VARCHAR(20)     NOT NULL,
  changed_by  INT UNSIGNED        NULL,
  changed_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_osl_order (order_id),
  CONSTRAINT fk_osl_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_osl_user
    FOREIGN KEY (changed_by) REFERENCES users(id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SEED DATA — minimal bootstrap
-- ============================================================

INSERT INTO organizations (name, slug) VALUES ('Demo F&B Corp', 'demo-fnb-corp');

INSERT INTO cities (organization_id, name) VALUES (1, 'Hồ Chí Minh'), (1, 'Hà Nội');

INSERT INTO stores (organization_id, city_id, name, address)
VALUES
  (1, 1, 'Chi nhánh Quận 1',   '123 Lê Lợi, Q.1, TP.HCM'),
  (1, 1, 'Chi nhánh Quận 7',   '456 Nguyễn Thị Thập, Q.7, TP.HCM'),
  (1, 2, 'Chi nhánh Hoàn Kiếm','78 Hàng Bài, Hoàn Kiếm, Hà Nội');

-- Passwords are bcrypt hashes of "password123"
INSERT INTO users (organization_id, store_id, name, email, password_hash, role) VALUES
  (1, NULL, 'Super Admin',    'admin@demo.com',    '$2b$12$examplehashADMIN',   'admin'),
  (1, 1,    'Manager Q1',     'mgr.q1@demo.com',   '$2b$12$examplehashMGR1',    'manager'),
  (1, 1,    'Staff Q1',       'staff.q1@demo.com', '$2b$12$examplehashSTAFF1',  'staff'),
  (1, 1,    'Kitchen Q1',     'ktc.q1@demo.com',   '$2b$12$examplehashKTC1',    'kitchen'),
  (1, 2,    'Manager Q7',     'mgr.q7@demo.com',   '$2b$12$examplehashMGR2',    'manager');

INSERT INTO tables (store_id, name, code, capacity) VALUES
  (1, 'Bàn 01', 'HCM_Q1_B01_A1B2', 4),
  (1, 'Bàn 02', 'HCM_Q1_B02_C3D4', 4),
  (1, 'Bàn VIP','HCM_Q1_VIP_E5F6', 8),
  (2, 'Bàn 01', 'HCM_Q7_B01_G7H8', 4);

INSERT INTO categories (store_id, name, sort_order) VALUES
  (1, 'Đồ uống',   1),
  (1, 'Món chính', 2),
  (1, 'Tráng miệng', 3);

INSERT INTO products (store_id, category_id, name, price) VALUES
  (1, 1, 'Cà phê đen',    25000),
  (1, 1, 'Cà phê sữa',    30000),
  (1, 2, 'Cơm tấm sườn', 55000),
  (1, 3, 'Chè ba màu',    20000);

INSERT INTO ingredients (store_id, name, unit) VALUES
  (1, 'Cà phê bột',  'gram'),
  (1, 'Sữa đặc',     'gram'),
  (1, 'Cơm',         'gram'),
  (1, 'Sườn heo',    'gram'),
  (1, 'Đậu xanh',    'gram');

INSERT INTO inventory (store_id, ingredient_id, quantity) VALUES
  (1, 1, 5000),
  (1, 2, 3000),
  (1, 3, 10000),
  (1, 4, 8000),
  (1, 5, 2000);

INSERT INTO recipes (product_id) VALUES (1),(2),(3),(4);

INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES
  (1, 1, 15),          -- Cà phê đen: 15g cà phê bột
  (2, 1, 15),          -- Cà phê sữa: 15g cà phê bột
  (2, 2, 30),          --             30g sữa đặc
  (3, 3, 200),         -- Cơm tấm   : 200g cơm
  (3, 4, 150),         --             150g sườn
  (4, 5, 50);          -- Chè ba màu: 50g đậu xanh

-- ============================================================
-- USEFUL VIEWS
-- ============================================================

CREATE OR REPLACE VIEW v_inventory_status AS
SELECT
  s.id         AS store_id,
  s.name       AS store_name,
  i.id         AS ingredient_id,
  i.name       AS ingredient_name,
  i.unit,
  inv.quantity AS current_stock,
  CASE
    WHEN inv.quantity <= 0    THEN 'out_of_stock'
    WHEN inv.quantity < 500   THEN 'low_stock'
    ELSE                           'in_stock'
  END          AS stock_status
FROM inventory inv
JOIN stores      s ON s.id = inv.store_id
JOIN ingredients i ON i.id = inv.ingredient_id;

CREATE OR REPLACE VIEW v_order_summary AS
SELECT
  o.id          AS order_id,
  s.name        AS store_name,
  t.name        AS table_name,
  o.status,
  o.total_amount,
  COUNT(oi.id)  AS item_count,
  o.created_at
FROM orders o
JOIN stores      s  ON s.id  = o.store_id
JOIN tables      t  ON t.id  = o.table_id
LEFT JOIN order_items oi ON oi.order_id = o.id
GROUP BY o.id, s.name, t.name, o.status, o.total_amount, o.created_at;

-- ============================================================
-- STORED PROCEDURE: deduct inventory when order → cooking
-- ============================================================
DELIMITER $$

CREATE PROCEDURE sp_deduct_inventory(
  IN p_order_id  INT UNSIGNED,
  IN p_user_id   INT UNSIGNED
)
BEGIN
  DECLARE v_store_id     INT UNSIGNED;
  DECLARE v_ingredient   INT UNSIGNED;
  DECLARE v_needed       DECIMAL(14,4);
  DECLARE v_current      DECIMAL(14,4);
  DECLARE v_export_id    INT UNSIGNED;
  DECLARE done           INT DEFAULT 0;

  DECLARE cur CURSOR FOR
    SELECT
      ri.ingredient_id,
      SUM(ri.quantity * oi.quantity) AS total_needed
    FROM order_items oi
    JOIN recipes          r  ON r.product_id    = oi.product_id
    JOIN recipe_ingredients ri ON ri.recipe_id  = r.id
    WHERE oi.order_id = p_order_id
    GROUP BY ri.ingredient_id;

  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

  SELECT store_id INTO v_store_id FROM orders WHERE id = p_order_id;

  START TRANSACTION;

  -- Create export header
  INSERT INTO stock_exports (store_id, order_id, created_by, type)
  VALUES (v_store_id, p_order_id, p_user_id, 'order');
  SET v_export_id = LAST_INSERT_ID();

  OPEN cur;
  deduct_loop: LOOP
    FETCH cur INTO v_ingredient, v_needed;
    IF done THEN LEAVE deduct_loop; END IF;

    -- Lock row for update
    SELECT quantity INTO v_current
    FROM inventory
    WHERE store_id = v_store_id AND ingredient_id = v_ingredient
    FOR UPDATE;

    IF v_current < v_needed THEN
      ROLLBACK;
      SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Out of stock: insufficient ingredient quantity';
    END IF;

    UPDATE inventory
    SET quantity = quantity - v_needed
    WHERE store_id = v_store_id AND ingredient_id = v_ingredient;

    INSERT INTO stock_export_items (export_id, ingredient_id, quantity)
    VALUES (v_export_id, v_ingredient, v_needed);

  END LOOP;
  CLOSE cur;

  COMMIT;
END$$

DELIMITER ;

-- ============================================================
-- END OF SCHEMA
-- ============================================================