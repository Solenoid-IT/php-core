CREATE OR REPLACE VIEW `core_demo`.`view::visitor::last_month` AS

SELECT
    YEAR(visitor_table.`datetime.insert`) AS `year`,
    MONTH(visitor_table.`datetime.insert`) AS `month`,
    DAY(visitor_table.`datetime.insert`) AS `day`,

    COUNT(*) AS `qty`
FROM
    `visitor` visitor_table
WHERE
    YEAR(visitor_table.`datetime.insert`) = YEAR(CURRENT_TIMESTAMP)
        AND
    MONTH(visitor_table.`datetime.insert`) = MONTH(CURRENT_TIMESTAMP)
GROUP BY
    YEAR(visitor_table.`datetime.insert`),
    MONTH(visitor_table.`datetime.insert`),
    DAY(visitor_table.`datetime.insert`)
ORDER BY
    YEAR(visitor_table.`datetime.insert`) ASC,
    MONTH(visitor_table.`datetime.insert`) ASC,
    DAY(visitor_table.`datetime.insert`) ASC
;