CREATE DATABASE zowify;
USE zowify;

CREATE TABLE category (
	id			INT PRIMARY KEY AUTO_INCREMENT,
	`name`		VARCHAR(100) UNIQUE
);

CREATE TABLE product (
	id				INT PRIMARY KEY AUTO_INCREMENT,
	title			VARCHAR(150) NOT NULL,
	`description`	VARCHAR(500) NOT NULL,
	price			DECIMAL(10, 2) NOT NULL,
	discount		DECIMAL(5, 2) DEFAULT 0,
	discount_type	VARCHAR(20) DEFAULT 'percentage',
	stock			INT NOT NULL DEFAULT 0,
	category_id		INT NOT NULL,
	image			VARCHAR(100) DEFAULT NULL,
	deleted_at		DATETIME DEFAULT NULL,
    CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES category(id)
);

CREATE TABLE `user` (
	id				INT PRIMARY KEY AUTO_INCREMENT,
	first_name		VARCHAR(150) NOT NULL,
	last_name		VARCHAR(150) NOT NULL,
	address			VARCHAR(100),
	email			VARCHAR(100) NOT NULL UNIQUE,
	`password`		VARCHAR(100) NOT NULL,
	created_at		DATETIME DEFAULT CURRENT_TIMESTAMP,
	updated_at		DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	deleted_at		DATETIME DEFAULT NULL
);

CREATE TABLE `order` (
	id				INT PRIMARY KEY AUTO_INCREMENT,
	id_user			INT NOT NULL,
	payment_status	VARCHAR(50) NOT NULL DEFAULT 'pending',
	shipping_status	VARCHAR(20) NOT NULL DEFAULT 'pending',
	total_price		DECIMAL(10, 2) NOT NULL,
	created_at		DATETIME DEFAULT CURRENT_TIMESTAMP,
	updated_at		DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES `user`(id)
);

CREATE TABLE order_item (
	id				INT PRIMARY KEY AUTO_INCREMENT,
	id_order		INT NOT NULL,
	id_product		INT NOT NULL,
	quantity		INT NOT NULL,
	price			DECIMAL(10, 2) NOT NULL,
	CONSTRAINT fk_order FOREIGN KEY (id_order) REFERENCES `order`(id),
	CONSTRAINT fk_product FOREIGN KEY (id_product) REFERENCES product(id)
);

INSERT INTO category (`name`) VALUES
('Hombre'),
('Mujer'),
('Bebés'),
('Calzado'),
('Accesorios'),
('Carteras y Mochilas'),
('Belleza'),
('Joyería'),
('Perfumes'),
('Cuidado Personal'),
('Otros');

INSERT INTO product (title, `description`, price, discount, discount_type, stock, category_id, image) VALUES
('Camiseta Básica Hombre', 'Camiseta de algodón 100% premium', 19.99, 5.00, 'percentage', 50, 1, 'camiseta_hombre.jpg'),
('Pantalón Chino Hombre', 'Pantalón casual de excelente calidad', 49.99, 10.00, 'percentage', 35, 1, 'pantalon_chino.jpg'),
('Polo Deportivo Hombre', 'Polo transpirable para deporte', 34.99, 0.00, 'percentage', 40, 1, 'polo_deportivo.jpg'),
('Blusa Floral Mujer', 'Blusa elegante estampado floral', 39.99, 8.00, 'percentage', 45, 2, 'blusa_floral.jpg'),
('Vestido Negro Mujer', 'Vestido clásico para cualquier ocasión', 59.99, 15.00, 'percentage', 30, 2, 'vestido_negro.jpg'),
('Jeans Skinny Mujer', 'Jeans ajustado trending', 54.99, 12.00, 'percentage', 40, 2, 'jeans_skinny.jpg'),
('Body Bebé Algodón', 'Body suave para recién nacidos', 14.99, 3.00, 'percentage', 60, 3, 'body_bebe.jpg'),
('Pelele Bebé Estampado', 'Pelele cómodo y adorable', 24.99, 5.00, 'percentage', 50, 3, 'pelele_bebe.jpg'),
('Zapatilla Deportiva Blanca', 'Zapatilla cómoda para diario', 69.99, 20.00, 'percentage', 45, 4, 'zapatilla_blanca.jpg'),
('Tacón Negro Alto', 'Tacón elegante para eventos', 79.99, 0.00, 'percentage', 25, 4, 'tacos_negro.jpg'),
('Sandalia Plana Mujer', 'Sandalia cómoda verano', 29.99, 7.00, 'percentage', 55, 4, 'sandalia_plana.jpg'),
('Sneaker Hombre Gris', 'Sneaker moderno y cómodo', 74.99, 18.00, 'percentage', 35, 4, 'sneaker_hombre.jpg'),
('Gafas de Sol Aviador', 'Gafas clásicas estilo aviador', 44.99, 10.00, 'percentage', 40, 5, 'gafas_aviador.jpg'),
('Cinturón Cuero Negro', 'Cinturón de cuero genuino', 34.99, 0.00, 'percentage', 50, 5, 'cinturon_negro.jpg'),
('Bufanda de Lana', 'Bufanda suave y abrigadora', 24.99, 5.00, 'percentage', 45, 5, 'bufanda_lana.jpg'),
('Reloj Pulsera Mujer', 'Reloj elegante dorado', 89.99, 25.00, 'percentage', 20, 5, 'reloj_mujer.jpg'),
('Mochila Backpack', 'Mochila resistente para viajes', 59.99, 15.00, 'percentage', 30, 6, 'mochila_backpack.jpg'),
('Cartera Tote Mujer', 'Cartera grande para diario', 64.99, 0.00, 'percentage', 25, 6, 'cartera_tote.jpg'),
('Crossbody Bag', 'Bolsa de hombro moderna', 49.99, 12.00, 'percentage', 35, 6, 'crossbody_bag.jpg'),
('Labial Rojo Intenso', 'Labial de larga duración', 12.99, 2.00, 'percentage', 60, 7, 'labial_rojo.jpg'),
('Base de Maquillaje', 'Base cobertura total', 18.99, 4.00, 'percentage', 45, 7, 'base_maquillaje.jpg'),
('Sombra de Ojos 12 Colores', 'Paleta pigmentada profesional', 24.99, 6.00, 'percentage', 35, 7, 'sombra_ojos.jpg'),
('Rímel Voluminizador', 'Rímel para pestañas largas', 14.99, 3.00, 'percentage', 50, 7, 'rimal_volumetrico.jpg'),
('Anillo de Oro', 'Anillo elegante oro 18K', 89.99, 0.00, 'percentage', 15, 8, 'anillo_oro.jpg'),
('Collar de Perlas', 'Collar clásico de perlas', 129.99, 30.00, 'percentage', 10, 8, 'collar_perlas.jpg'),
('Pulsera Plata Mujer', 'Pulsera fina de plata', 44.99, 10.00, 'percentage', 25, 8, 'pulsera_plata.jpg'),
('Aretes Brillantes', 'Aretes con piedras brillantes', 34.99, 8.00, 'percentage', 30, 8, 'aretes_brillantes.jpg'),
('Perfume Floral 100ml', 'Perfume aroma floral fresco', 59.99, 15.00, 'percentage', 40, 9, 'perfume_floral.jpg'),
('Champú Premium 400ml', 'Champú nutritivo para cabello', 16.99, 0.00, 'percentage', 55, 10, 'champu_premium.jpg'),
('Crema Hidratante Facial', 'Crema facial de día SPF 30', 21.99, 5.00, 'percentage', 50, 10, 'crema_hidratante.jpg');

INSERT INTO `user` (first_name, last_name, address, email, `password`) VALUES 
('Zoe', 'Rivero', 'Calle 5 #123, Lima', 'zoe.rivero@email.com', 'pass123456'),
('María', 'López', 'Av. Principal 456, Lima', 'maria.lopez@email.com', 'pass789012'),
('Carlos', 'Martínez', 'Calle 10 #789, Surco', 'carlos.martinez@email.com', 'pass345678'),
('Ana', 'Rodríguez', 'Av. Larco 321, Miraflores', 'ana.rodriguez@email.com', 'pass901234'),
('Yuliett', 'Lorusso', 'Calle 20 #654, San Isidro', 'yuliett.lorusso@email.com', 'pass567890'),
('Laura', 'Sánchez', 'Av. Universitaria 789, Breña', 'laura.sanchez@email.com', 'pass234567'),
('Roberto', 'Gómez', 'Calle 15 #432, Independencia', 'roberto.gomez@email.com', 'pass890123'),
('Sandra', 'Díaz', 'Av. Paseo de la República 555, Cercado', 'sandra.diaz@email.com', 'pass456789'),
('Francisco', 'Torres', 'Calle 8 #987, San Miguel', 'francisco.torres@email.com', 'pass123789'),
('Patricia', 'Morales', 'Av. 28 de Julio 222, Lince', 'patricia.morales@email.com', 'pass654321');

INSERT INTO `order` (id_user, payment_status, shipping_status, total_price) VALUES 
(1, 'entregado', 45.50),
(2, 'procesando', 89.99),
(3, 'pendiente', 125.48),
(4, 'entregado', 32.99),
(5, 'enviado', 198.50);

INSERT INTO order_item (id_order, id_product, quantity, price) VALUES 
(1, 1, 2, 19.99),
(1, 9, 1, 69.99),
(1, 13, 1, 44.99),
(1, 20, 2, 14.99),
(2, 5, 1, 59.99),
(2, 6, 1, 54.99),
(2, 18, 1, 64.99),
(2, 24, 1, 89.99),
(3, 2, 1, 49.99),
(3, 10, 1, 79.99),
(3, 11, 2, 29.99),
(3, 22, 1, 24.99),
(3, 25, 1, 129.99),
(3, 28, 1, 59.99),
(4, 3, 1, 34.99),
(4, 12, 1, 74.99),
(4, 15, 1, 24.99),
(4, 19, 1, 49.99),
(4, 29, 1, 16.99),
(5, 4, 1, 39.99),
(5, 7, 1, 14.99),
(5, 8, 1, 24.99),
(5, 14, 1, 34.99),
(5, 16, 1, 89.99),
(5, 17, 1, 44.99),
(5, 21, 1, 12.99),
(5, 23, 1, 14.99),
(5, 26, 1, 44.99),
(5, 27, 1, 34.99),
(5, 30, 1, 21.99);