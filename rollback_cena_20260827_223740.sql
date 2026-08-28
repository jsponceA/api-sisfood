-- ROLLBACK generado 2026-08-27 22:37:40 (previo a renombrar CENA duplicada)
UPDATE products SET name='CENA', sale_price='10.00', worker_price='1.50', igv_price='8.85', company_price='8.50', company_price_no_grant='1.15', updated_at='2026-08-27 17:30:42' WHERE id=3;
UPDATE products SET name='CENA', sale_price='10.00', worker_price='10.00', igv_price=NULL, company_price='10.00', company_price_no_grant='0.00', updated_at='2026-07-20 11:29:33' WHERE id=191;
