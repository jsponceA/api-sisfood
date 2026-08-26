-- ROLLBACK generado 2026-08-19 17:37:07
-- Restaura products id 2,3,191,192 al estado previo

UPDATE products SET name='ALMUERZO', category='COMIDAS', barcode='2010424', purchase_price=NULL, sale_price='8.85', worker_price='1.50', igv_price='8.85', company_price='8.50', updated_at='2026-07-17 16:00:31' WHERE id=2;
UPDATE products SET name='CENA', category='COMIDAS', barcode='CENA123', purchase_price='7.50', sale_price='8.85', worker_price='1.50', igv_price='8.85', company_price='7.50', updated_at='2024-04-01 11:22:11' WHERE id=3;
UPDATE products SET name='CENA', category='COMIDAS', barcode='191200726', purchase_price=NULL, sale_price='10.00', worker_price='10.00', igv_price=NULL, company_price='10.00', updated_at='2026-07-20 11:29:33' WHERE id=191;
UPDATE products SET name='ALMUERZO', category='COMIDAS', barcode='192200726', purchase_price=NULL, sale_price='10.00', worker_price='10.00', igv_price=NULL, company_price='10.00', updated_at='2026-07-20 11:29:54' WHERE id=192;
