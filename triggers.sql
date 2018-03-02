DELIMITER //
CREATE TRIGGER tr_updStockIngreso AFTER INSERT ON detalle_ingreso
	FOR EACH ROW BEGIN
		UPDATE articulo SET stock = stock + NEW.cantidad
        WHERE articulo.idarticulo = NEW.idarticulo;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER tr_updStockVenta AFTER INSERT ON detalle_venta
	FOR EACH ROW BEGIN
		UPDATE articulo SET stock = stock + NEW.cantidad
        WHERE articulo.idarticulo = NEW.idarticulo;
END //
DELIMITER ;

SELECT * FROM users;
truncate table users;

create database emarketbdoo;